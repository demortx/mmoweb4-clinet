<?php

//namespace VisualAppeal;

use VisualAppeal\Exception;
use VisualAppeal\RuntimeException;


use VisualAppeal\Exceptions\DownloadException;
use VisualAppeal\Exceptions\ParserException;

/**
 * Auto update class.
 */
class AutoUpdate {
    /**
     * The latest version.
     *
     * @var string
     */
    private $latestVersion;

    /**
     * Updates not yet installed.
     *
     * @var array
     */
    private $updates;

    /**
     * Result of simulated install.
     *
     * @var array
     */
    private $simulationResults = array();

    /**
     * Temporary download directory.
     *
     * @var string
     */
    private $tempDir = '';

    /**
     * Install directory.
     *
     * @var string
     */
    private $installDir = '';

    /**
     * Update branch.
     *
     * @var string
     */
    private $branch = '';

    /**
     * Username authentication
     *
     * @var string
     */
    private $username = '';

    /**
     * Password authentication
     *
     * @var string
     */
    private $password = '';

    /*
     * Callbacks to be called when each update is finished
     *
     * @var array
     */
    private $onEachUpdateFinishCallbacks = [];

    /*
     * Callbacks to be called when all updates are finished
     *
     * @var array
     */
    private $onAllUpdateFinishCallbacks = [];

    /**
     * If curl should verify the host certificate.
     *
     * @var bool
     */
    private $sslVerifyHost = true;

    /**
     * Url to the update folder on the server.
     *
     * @var string
     */
    protected $updateUrl = 'https://example.com/updates/';

    /**
     * Version filename on the server.
     *
     * @var string
     */
    protected $updateFile = 'update.json';

    /**
     * Current version.
     *
     * @var string
     */
    protected $currentVersion;

    /**
     * Create new folders with this privileges.
     *
     * @var int
     */
    public $dirPermissions = 0755;

    /**
     * Update script filename.
     *
     * @var string
     */
    public $updateScriptName = '_upgrade.php';

    /**
     * How long the cache should be valid (in seconds).
     *
     * @var int
     */
    protected $cacheTtl = 3600;

    /**
     * No update available.
     */
    const NO_UPDATE_AVAILABLE = 0;

    /**
     * Could not check for last version.
     */
    const ERROR_VERSION_CHECK = 20;

    /**
     * Temp directory does not exist or is not writable.
     */
    const ERROR_TEMP_DIR = 30;

    /**
     * Install directory does not exist or is not writable.
     */
    const ERROR_INSTALL_DIR = 35;

    /**
     * Could not download update.
     */
    const ERROR_DOWNLOAD_UPDATE = 40;

    /**
     * Could not delete zip update file.
     */
    const ERROR_DELETE_TEMP_UPDATE = 50;

    /**
     * Error in simulated install.
     */
    const ERROR_SIMULATE = 70;

    /** Логи операций
     * @var array
     */
    public $log_update = array();

    /**
     * Create new instance
     *
     * @param string|null $tempDir
     * @param string|null $installDir
     * @param int $maxExecutionTime
     */
    public function __construct($tempDir, $installDir, $maxExecutionTime = 60)
    {

        $this->setTempDir($tempDir);
        $this->setInstallDir($installDir);

        $this->latestVersion  = '0.0.0';
        $this->currentVersion = '0.0.0';

        ini_set('max_execution_time', $maxExecutionTime);
    }

    /**
     * Set the temporary download directory.
     *
     * @param $dir
     * @return bool
     */
    public function setTempDir($dir)
    {
        $dir = $this->addTrailingSlash($dir);

        if (!is_dir($dir)) {
            log_write('update', sprintf('Creating new temporary directory "%s"', $dir));

            if (!mkdir($dir, 0755, true) && !is_dir($dir)) {
                log_write('update', sprintf('Could not create temporary directory "%s"', $dir));

                return false;
            }
        }

        $this->tempDir = $dir;

        return true;
    }

    /**
     * Set the install directory.
     *
     * @param $dir
     * @return bool
     */
    public function setInstallDir($dir)
    {
        $dir = $this->addTrailingSlash($dir);

        if (!is_dir($dir)) {
            log_write('update', sprintf('Creating new install directory "%s"', $dir));

            if (!mkdir($dir, 0755, true) && !is_dir($dir)) {
                log_write('update', sprintf('Could not create install directory "%s"', $dir));

                return false;
            }
        }

        $this->installDir = $dir;

        return true;
    }

    /**
     * Set the update filename.
     *
     * @param $updateFile
     * @return AutoUpdate
     */
    public function setUpdateFile($updateFile)
    {
        $this->updateFile = $updateFile;

        return $this;
    }

    /**
     * Set the update filename.
     *
     * @param $updateUrl
     * @return AutoUpdate
     */
    public function setUpdateUrl($updateUrl)
    {
        $this->updateUrl = $updateUrl;

        return $this;
    }

    /**
     * Set the update branch.
     *
     * @param branch
     * @return AutoUpdate
     */
    public function setBranch($branch)
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * Set the version of the current installed software.
     *
     * @param $currentVersion
     * @return AutoUpdate
     */
    public function setCurrentVersion($currentVersion)
    {
        $this->currentVersion = $currentVersion;

        return $this;
    }

    /**
     * Set username and password for basic authentication.
     *
     * @param $username
     * @param $password
     * @return AutoUpdate
     */
    public function setBasicAuth($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        return $this;
    }

    /**
     * Set authentication header if username and password exist.
     *
     * @return null|resource
     */
    private function useBasicAuth()
    {
        if ($this->username && $this->password) {
            return stream_context_create(array(
                'http' => array(
                    'header' => "Authorization: Basic " . base64_encode("$this->username:$this->password")
                )
            ));
        }

        return null;
    }


    /**
     * Get the name of the latest version.
     *
     * @return string
     */
    public function getLatestVersion()
    {
        return $this->latestVersion;
    }

    /**
     * Get an of versions which will be installed.
     *
     * @return array
     */
    public function getVersionsToUpdate()
    {
        if (count($this->updates) > 0) {
            return array_map(static function ($update) {
                return $update['version'];
            }, $this->updates);
        }

        return [];
    }

    /**
     * Get an of versions which will be installed.
     *
     * @return array
     */
    public function getVersionsToUpdateDesc()
    {
        if (count($this->updates) > 0) {
            return $this->updates;
        }

        return [];
    }

    /**
     * Get the results of the last simulation.
     *
     * @return array
     */
    public function getSimulationResults()
    {
        return $this->simulationResults;
    }

    /**
     * @return bool
     */
    public function getSslVerifyHost()
    {
        return $this->sslVerifyHost;
    }

    /**
     * @param $sslVerifyHost
     * @return AutoUpdate
     */
    public function setSslVerifyHost($sslVerifyHost)
    {
        $this->sslVerifyHost = $sslVerifyHost;

        return $this;
    }

    /**
     * Check for a new version
     *
     * @param int $timeout Download timeout in seconds (Only applied for downloads via curl)
     * @return int|bool
     *         true: New version is available
     *         false: Error while checking for update
     *         int: Status code (i.e. AutoUpdate::NO_UPDATE_AVAILABLE)
     * @throws DownloadException
     * @throws ParserException
     */
    public function checkUpdate($timeout = 10)
    {
        log_write('update', 'Checking for a new update...');

        // Reset previous updates
        $this->latestVersion = '0.0.0';
        $this->updates       = [];

        $versions = get_cache('update-versions');

        // Create absolute url to update file
        $updateFile = $this->updateUrl . '/' . $this->updateFile;
        if (!empty($this->branch)) {
            $updateFile .= '.' . $this->branch;
        }

        // Check if cache is empty
        if ($versions === null || $versions === false) {
            log_write('update', sprintf('Get new updates from %s', $updateFile));

            // Read update file from update server
            if (function_exists('curl_version') && $this->isValidUrl($updateFile)) {
                $update = $this->downloadCurl($updateFile, $timeout);

                if ($update === false) {
                    log_write('update', sprintf('Could not download update file "%s" via curl!', $updateFile));

                    throw new DownloadException($updateFile);
                }
            } else {
                $update = @file_get_contents($updateFile, false, $this->useBasicAuth());

                if ($update === false) {
                    log_write('update', sprintf('Could not download update file "%s" via file_get_contents!',
                        $updateFile));

                    throw new DownloadException($updateFile);
                }
            }

            // Parse update file
            $updateFileExtension = substr(strrchr($this->updateFile, '.'), 1);
            switch ($updateFileExtension) {
                case 'ini':
                    $versions = parse_ini_string($update, true);
                    if (!is_array($versions)) {
                        log_write('update', 'Unable to parse ini update file!');

                        throw new ParserException(sprintf('Could not parse update ini file %s!', $this->updateFile));
                    }

                    $versions = array_map(static function ($block) {
                        return isset($block['url']) ? $block['url'] : false;
                    }, $versions);

                    break;
                case 'json':
                    $versions = (array) json_decode($update, false);
                    if (!is_array($versions)) {
                        log_write('update', 'Unable to parse json update file!');

                        throw new ParserException(sprintf('Could not parse update json file %s!', $this->updateFile));
                    }

                    break;
                default:
                    log_write('update', sprintf('Unknown file extension "%s"', $updateFileExtension));

                    throw new ParserException(sprintf('Unknown file extension for update file %s!', $this->updateFile));
            }

            set_cache('update-versions', $versions, $this->cacheTtl);
        } else {
            log_write('update', 'Got updates from cache');
        }

        if (!is_array($versions)) {
            log_write('update', sprintf('Could not read versions from server %s', $updateFile));

            return false;
        }

        // Check for latest version
        foreach ($versions as $version => $info) {
            if ($this->greaterThan($version, $this->currentVersion)) {
                if ($this->greaterThan($version, $this->latestVersion)) {
                    $this->latestVersion = $version;
                }

                $this->updates[] = [
                    'version' => $version,
                    'url'     => $info->url,
                    'desc'     => $info->desc,
                ];
            }
        }

        // Sort versions to install
        usort($this->updates, function ($a, $b) {
            if ($this->equalTo($a['version'], $b['version'])) {
                return 0;
            }

            return $this->lessThan($a['version'], $b['version']) ? - 1 : 1;
        });

        if ($this->newVersionAvailable()) {
            log_write('update', sprintf('New version "%s" available', $this->latestVersion));

            return true;
        }

        log_write('update', 'No new version available');

        return self::NO_UPDATE_AVAILABLE;
    }

    /**
     * Check if a new version is available.
     *
     * @return bool
     */
    public function newVersionAvailable()
    {
        return $this->greaterThan($this->latestVersion, $this->currentVersion);
    }

    /**
     * Check if url is valid.
     *
     * @param $url
     * @return bool
     */
    protected function isValidUrl($url)
    {
        return (filter_var($url, FILTER_VALIDATE_URL) !== false);
    }

    /**
     * Download file via curl.
     *
     * @param $url URL to file
     * @param int $timeout
     * @return string|false
     */
    protected function downloadCurl($url, $timeout = 10)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $this->sslVerifyHost ? 2 : 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->sslVerifyHost);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        $update = curl_exec($curl);

        $success = true;
        if (curl_error($curl)) {
            $success = false;
            log_write('update', sprintf(
                'Could not download update "%s" via curl: %s!',
                $url,
                curl_error($curl)
            ));
        }
        curl_close($curl);

        return ($success === true) ? $update : false;
    }

    /**
     * Download the update
     *
     * @param $updateUrl Url where to download from
     * @param $updateFile Path where to save the download
     * @return bool
     * @throws DownloadException
     * @throws Exception
     */
    protected function downloadUpdate($updateUrl, $updateFile)
    {
        log_write('update', sprintf('Downloading update "%s" to "%s"', $updateUrl, $updateFile));
        if (function_exists('curl_version') && $this->isValidUrl($updateUrl)) {
            $update = $this->downloadCurl($updateUrl);
            if ($update === false) {
                return false;
            }
        } elseif (ini_get('allow_url_fopen')) {
            $update = @file_get_contents($updateUrl, false, $this->useBasicAuth());

            if ($update === false) {
                log_write('update', sprintf('Could not download update "%s"!', $updateUrl));

                throw new DownloadException($updateUrl);
            }
        } else {
            throw new RuntimeException('No valid download method found!');
        }

        $handle = fopen($updateFile, 'wb');
        if (!$handle) {
            log_write('update', sprintf('Could not open file handle to save update to "%s"!', $updateFile));

            return false;
        }

        if (!fwrite($handle, $update)) {
            log_write('update', sprintf('Could not write update to file "%s"!', $updateFile));
            fclose($handle);

            return false;
        }

        fclose($handle);

        return true;
    }

    /**
     * Simulate update process.
     *
     * @param $updateFile
     * @return bool
     */
    protected function simulateInstall($updateFile)
    {
        log_write('update', '[SIMULATE] Install new version');
        clearstatcache();

        // Check if zip file could be opened
        $zip = new \ZipArchive();
        $resource = $zip->open($updateFile);
        if ($resource !== true) {
            log_write('update', sprintf('Could not open zip file "%s", error: %d', $updateFile, $resource));

            return false;
        }

        $files           = [];
        $simulateSuccess = true;

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $fileStats        = $zip->statIndex($i);
            $filename         = $fileStats['name'];
            $foldername       = $this->installDir . dirname($filename);
            $absoluteFilename = $this->installDir . $filename;

            $files[$i] = [
                'filename'          => $filename,
                'foldername'        => $foldername,
                'absolute_filename' => $absoluteFilename,
            ];

            log_write('update', sprintf('[SIMULATE] Updating file "%s"', $filename));

            // Check if parent directory is writable
            if (!is_dir($foldername)) {
                if (!mkdir($foldername) && !is_dir($foldername)) {
                    throw new RuntimeException(sprintf('Directory "%s" was not created', $foldername));
                }
                log_write('update', sprintf('[SIMULATE] Create directory "%s"', $foldername));
                $files[$i]['parent_folder_exists'] = false;

                $parent = dirname($foldername);
                if (!is_writable($parent)) {
                    $files[$i]['parent_folder_writable'] = false;

                    $simulateSuccess = false;
                    log_write('update', sprintf('[SIMULATE] Directory "%s" has to be writeable!', $parent));
                } else {
                    $files[$i]['parent_folder_writable'] = true;
                }
            }

            // Skip if entry is a directory
            if ($filename[strlen($filename) - 1] === DIRECTORY_SEPARATOR) {
                continue;
            }

            // Write to file
            if (file_exists($absoluteFilename)) {
                $files[$i]['file_exists'] = true;
                if (!is_writable($absoluteFilename)) {
                    $files[$i]['file_writable'] = false;

                    $simulateSuccess = false;
                    log_write('update', sprintf('[SIMULATE] Could not overwrite "%s"!', $absoluteFilename));
                }
            } else {
                $files[$i]['file_exists'] = false;

                if (is_dir($foldername)) {
                    if (!is_writable($foldername)) {
                        $files[$i]['file_writable'] = false;

                        $simulateSuccess = false;
                        log_write('update', sprintf('[SIMULATE] The file "%s" could not be created!',
                            $absoluteFilename));
                    } else {
                        $files[$i]['file_writable'] = true;
                    }
                } else {
                    $files[$i]['file_writable'] = true;

                    log_write('update', sprintf('[SIMULATE] The file "%s" could be created', $absoluteFilename));
                }
            }

            if ($filename === $this->updateScriptName) {
                log_write('update', sprintf('[SIMULATE] Update script "%s" found', $absoluteFilename));
                $files[$i]['update_script'] = true;
            } else {
                $files[$i]['update_script'] = false;
            }
        }

        $zip->close();

        $this->simulationResults = $files;

        return $simulateSuccess;
    }

    /**
     * Install update.
     *
     * @param $updateFile Path to the update file
     * @param $simulateInstall Check for directory and file permissions instead of installing the update
     * @param $version
     * @return bool
     */
    protected function install($updateFile, $simulateInstall, $version)
    {
        $this->log_update[$version][] = log_write('update', sprintf('Trying to install update "%s"', $updateFile));

        // Check if install should be simulated
        if ($simulateInstall) {
            if ($this->simulateInstall($updateFile)) {
                $this->log_update[$version][] = log_write('update', sprintf('Simulation of update "%s" process succeeded', $version));

                return true;
            }

            $this->log_update[$version][] = log_write('update', sprintf('Simulation of update  "%s" process failed!', $version));

            return self::ERROR_SIMULATE;
        }

        clearstatcache();

        // Install only if simulateInstall === false

        // Check if zip file could be opened
        $zip = new \ZipArchive();
        $resource = $zip->open($updateFile);
        if ($resource !== true) {
            $this->log_update[$version][] = log_write('update', sprintf('Could not open zip file "%s", error: %d', $updateFile, $resource));

            return false;
        }

        // Read every file from archive
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $fileStats        = $zip->statIndex($i);

            $filename         = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $fileStats['name']);
            if(stristr($filename, '.DS_Store') !== FALSE) {
                continue;
            }

            $foldername       = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR,
                $this->installDir . dirname($filename));
            $absoluteFilename = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $this->installDir);
            $this->log_update[$version][] = log_write('update', sprintf('Updating file "%s"', $filename));



            if (!is_dir($foldername) && !mkdir($foldername, $this->dirPermissions, true) && !is_dir($foldername)) {
                $this->log_update[$version][] = log_write('update', sprintf('Directory "%s" has to be writeable!', $foldername));

                return false;
            }

            // Skip if entry is a directory
            if ($filename[strlen($filename) - 1] === DIRECTORY_SEPARATOR) {
                continue;
            }

            //делаем бекап файла
            $this->backupFiles($fileStats['name'],$absoluteFilename,  $version);

            // Extract file
            if ($zip->extractTo($absoluteFilename, $fileStats['name']) === false) {
                $this->log_update[$version][] = log_write('update', sprintf('Coud not read zip entry "%s"', $fileStats['name']));
                continue;
            }

            //If file is a update script, include
            if ($filename === $this->updateScriptName) {
                $this->log_update[$version][] = log_write('update', sprintf('Try to include update script "%s"', $absoluteFilename));
                require($absoluteFilename);

                $this->log_update[$version][] = log_write('update', sprintf('Update script "%s" included!', $absoluteFilename));
                if (!unlink($absoluteFilename)) {
                    $this->log_update[$version][] = log_write('update', sprintf('Could not delete update script "%s"!', $absoluteFilename));
                }
            }
        }

        $zip->close();

        $this->log_update[$version][] = log_write('update', sprintf('Update "%s" successfully installed', $version));

        return true;
    }

    /**
     * @param $files
     * @param $dir
     * @param $version
     */
    public function backupFiles( $files, $dir, $version){

        $backup_dir = ROOT_DIR . '/Files/backup/';

        if (!is_dir($backup_dir.$version.'/'.dirname($files)))
        {
            if (!mkdir($backup_dir.$version.'/'.dirname($files), $this->dirPermissions, true)) {
                $this->log_update[$version][] = log_write('update', sprintf('Failed to create backup folder: "%s"', $backup_dir . $version . '/' . dirname($files)));
                return false;
            }
        }

        if (file_exists($dir.$files)) {
            if (!copy($dir . $files, $backup_dir . $version . '/' . $files)) {
                $this->log_update[$version][] = log_write('update', sprintf('Failed to backup file: "%s"', $files));
            } else
                $this->log_update[$version][] = log_write('update', sprintf('Backup file: "%s"', '/Files/backup/' . $version . '/' . $files));
        }
    }

    /**
     * Update to the latest version
     *
     * @param $simulateInstall Check for directory and file permissions before copying files (Default: true)
     * @param $deleteDownload Delete download after update (Default: true)
     * @return integer|bool
     * @throws DownloadException
     * @throws ParserException
     */
    public function update($simulateInstall = true, $deleteDownload = true)
    {
        $this->log_update['sys'][] = log_write('update', 'Trying to perform update');
        $err = '';

        // Check for latest version
        if ($this->latestVersion === null || count($this->updates) === 0) {
            $this->checkUpdate();
        }

        if ($this->latestVersion === null || count($this->updates) === 0) {
            $this->log_update['sys'][] = $err = log_write('update', 'Could not get latest version from server!');

            return $err;//self::ERROR_VERSION_CHECK;
        }

        // Check if current version is up to date
        if (!$this->newVersionAvailable()) {
            $this->log_update['sys'][] = $err = log_write('update', 'No update available!');

            return $err;//self::NO_UPDATE_AVAILABLE;
        }

        foreach ($this->updates as $update) {
            $this->log_update[$update['version']][] = log_write('update', sprintf('Update to version "%s"', $update['version']));

            // Check for temp directory
            if (empty($this->tempDir) || !is_dir($this->tempDir) || !is_writable($this->tempDir)) {
                $this->log_update[$update['version']][] = $err = log_write('update', sprintf('Temporary directory "%s" does not exist or is not writeable!',
                    $this->tempDir));

                return $err;//self::ERROR_TEMP_DIR;
            }

            // Check for install directory
            if (empty($this->installDir) || !is_dir($this->installDir) || !is_writable($this->installDir)) {
                $this->log_update[$update['version']][] = $err = log_write('update', sprintf('Install directory "%s" does not exist or is not writeable!',
                    $this->installDir));

                return $err;//self::ERROR_INSTALL_DIR;
            }

            $updateFile = $this->tempDir . $update['version'] . '.zip';

            // Download update
            if (!is_file($updateFile)) {
                if (!$this->downloadUpdate($update['url'], $updateFile)) {
                    $this->log_update[$update['version']][] = $err = log_write('update', sprintf('Failed to download update from "%s" to "%s"!', $update['url'],
                        $updateFile));

                    return $err;//self::ERROR_DOWNLOAD_UPDATE;
                }

                $this->log_update[$update['version']][] = log_write('update', sprintf('Latest update downloaded to "%s"', $updateFile));
            } else {
                $this->log_update[$update['version']][] = log_write('update', sprintf('Latest update already downloaded to "%s"', $updateFile));
            }

            // Install update
            $result = $this->install($updateFile, $simulateInstall, $update['version']);
            if ($result === true) {
                $this->runOnEachUpdateFinishCallbacks($update['version'], $simulateInstall);
                if ($deleteDownload) {
                    $this->log_update[$update['version']][] = log_write('update', sprintf('Trying to delete update file "%s" after successfull update',
                        $updateFile));
                    if (unlink($updateFile)) {
                        $this->log_update[$update['version']][] = log_write('update', sprintf('Update file "%s" deleted after successfull update', $updateFile));
                    } else {
                        $this->log_update[$update['version']][] = $err = log_write('update', sprintf('Could not delete update file "%s" after successfull update!',
                            $updateFile));

                        return $err;//self::ERROR_DELETE_TEMP_UPDATE;
                    }
                }
            } else {
                if ($deleteDownload) {
                    $this->log_update[$update['version']][] = log_write('update', sprintf('Trying to delete update file "%s" after failed update', $updateFile));
                    if (unlink($updateFile)) {
                        $this->log_update[$update['version']][] = $err = log_write('update', sprintf('Update file "%s" deleted after failed update', $updateFile));
                    } else {
                        $this->log_update[$update['version']][] = $err = log_write('update', sprintf('Could not delete update file "%s" after failed update!',
                            $updateFile));
                    }
                }

                return $err;
            }
        }

        $this->runOnAllUpdateFinishCallbacks($this->getVersionsToUpdate());

        return true;
    }

    /**
     * @return array
     */
    public function getLogsUpdate(){
        return $this->log_update;
    }

    /**
     * Add slash at the end of the path.
     *
     * @param $dir
     * @return string
     */
    public function addTrailingSlash($dir)
    {
        if (substr($dir, - 1) !== DIRECTORY_SEPARATOR) {
            $dir .= DIRECTORY_SEPARATOR;
        }

        return $dir;
    }

    /**
     * Add callback which is executed after each update finished.
     *
     * @param $callback
     * @return $this
     */
    public function onEachUpdateFinish($callback)
    {
        $this->onEachUpdateFinishCallbacks[] = $callback;

        return $this;
    }

    /**
     * Add callback which is executed after all updates finished.
     *
     * @param $callback
     * @return $this
     */
    public function setOnAllUpdateFinishCallbacks($callback)
    {
        $this->onAllUpdateFinishCallbacks[] = $callback;

        return $this;
    }

    /**
     * Run callbacks after each update finished.
     *
     * @param $updateVersion
     * @param $simulate
     * @return void
     */
    private function runOnEachUpdateFinishCallbacks($updateVersion, $simulate)
    {
        foreach ($this->onEachUpdateFinishCallbacks as $callback) {
            $callback($updateVersion, $simulate);
        }
    }

    /**
     * Run callbacks after all updates finished.
     *
     * @param $updatedVersions
     * @return void
     */
    private function runOnAllUpdateFinishCallbacks($updatedVersions)
    {
        foreach ($this->onAllUpdateFinishCallbacks as $callback) {
            $callback($updatedVersions);
        }
    }

    /*
     * This file is part of composer/semver.
     *
     * (c) Composer <https://github.com/composer>
     *
     * For the full copyright and license information, please view
     * the LICENSE file that was distributed with this source code.
     */

    /**
     * Evaluates the expression: $version1 > $version2.
     *
     * @param $version1
     * @param $version2
     *
     * @return bool
     */
    public static function greaterThan($version1, $version2)
    {
        return self::compare($version1, '>', $version2);
    }

    /**
     * Evaluates the expression: $version1 >= $version2.
     *
     * @param $version1
     * @param $version2
     *
     * @return bool
     */
    public static function greaterThanOrEqualTo($version1, $version2)
    {
        return self::compare($version1, '>=', $version2);
    }

    /**
     * Evaluates the expression: $version1 < $version2.
     *
     * @param $version1
     * @param $version2
     *
     * @return bool
     */
    public static function lessThan($version1, $version2)
    {
        return self::compare($version1, '<', $version2);
    }

    /**
     * Evaluates the expression: $version1 <= $version2.
     *
     * @param $version1
     * @param $version2
     *
     * @return bool
     */
    public static function lessThanOrEqualTo($version1, $version2)
    {
        return self::compare($version1, '<=', $version2);
    }

    /**
     * Evaluates the expression: $version1 == $version2.
     *
     * @param $version1
     * @param $version2
     *
     * @return bool
     */
    public static function equalTo($version1, $version2)
    {
        return self::compare($version1, '==', $version2);
    }

    /**
     * Evaluates the expression: $version1 != $version2.
     *
     * @param $version1
     * @param $version2
     *
     * @return bool
     */
    public static function notEqualTo($version1, $version2)
    {
        return self::compare($version1, '!=', $version2);
    }

    /**
     * Evaluates the expression: $version1 $operator $version2.
     *
     * @param $version1
     * @param $operator
     * @param $version2
     *
     * @return bool
     */
    public static function compare($version1, $operator, $version2)
    {
        $constraint = new \Constraint($operator, $version2);

        return $constraint->matchSpecific(new \Constraint('==', $version1), true);
    }
}



