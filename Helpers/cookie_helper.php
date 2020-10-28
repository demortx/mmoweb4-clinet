<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    CodeIgniter
 * @author    EllisLab Dev Team
 * @copyright    Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright    Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license    http://opensource.org/licenses/MIT	MIT License
 * @link    http://codeigniter.com
 * @since    Version 1.0.0
 * @filesource
 */
defined('ROOT_DIR') OR exit('No direct script access allowed');

/**
 * CodeIgniter Cookie Helpers
 *
 * @package        CodeIgniter
 * @subpackage    Helpers
 * @category    Helpers
 * @author        EllisLab Dev Team
 * @link        http://codeigniter.com/user_guide/helpers/cookie_helper.html
 */

// ------------------------------------------------------------------------


if ( ! function_exists('set_cookie'))
{
    /**
     * Set cookie
     *
     * Accepts seven parameters, or you can submit an associative
     * array in the first parameter containing all the values.
     *
     * @param	mixed
     * @param	string	the value of the cookie
     * @param	string	the number of seconds until expiration
     * @param	string	the cookie domain.  Usually:  .yourdomain.com
     * @param	string	the cookie path
     * @param	string	the cookie prefix
     * @param	bool	true makes the cookie secure
     * @param	bool	true makes the cookie accessible via http(s) only (no javascript)
     * @return	void
     */
    function set_cookie($name, $value = '', $expire = '', $domain = '', $path = '/', $secure = FALSE, $httponly = FALSE)
    {
        if ($domain == '.'){
            if(isset($_SERVER['HTTP_HOST']) AND !empty($_SERVER['HTTP_HOST']))
                $pars_url = parse_url($_SERVER['HTTP_HOST']);
            elseif(isset($_SERVER['SERVER_NAME']) AND !empty($_SERVER['SERVER_NAME']))
                $pars_url = parse_url($_SERVER['SERVER_NAME']);
            else
                $pars_url["path"] = '';

            if(substr_count($pars_url["path"], '.') > 1){
                $pars_url["path"] = stristr($pars_url["path"], '.');
            }else{
                $pars_url["path"] = '.' . $pars_url["path"];
            }

            $domain = $pars_url["path"];
        }

        // Set the config file options
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('get_cookie'))
{
    /**
     * Fetch an item from the COOKIE array
     *
     * @param	string
     * @param	bool
     * @return	mixed
     */
    function get_cookie($index)
    {
        if(isset($_COOKIE[ $index ]))
            return $_COOKIE[ $index ];
        else
            return false;
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('delete_cookie'))
{
    /**
     * Delete a COOKIE
     *
     * @param	mixed
     * @param	string	the cookie domain. Usually: .yourdomain.com
     * @param	string	the cookie path
     * @param	string	the cookie prefix
     * @return	void
     */
    function delete_cookie($name, $domain = '', $path = '/')
    {
        if ($domain == '.'){
            if(isset($_SERVER['HTTP_HOST']) AND !empty($_SERVER['HTTP_HOST']))
                $pars_url = parse_url($_SERVER['HTTP_HOST']);
            elseif(isset($_SERVER['SERVER_NAME']) AND !empty($_SERVER['SERVER_NAME']))
                $pars_url = parse_url($_SERVER['SERVER_NAME']);
            else
                $pars_url["path"] = '';

            if(substr_count($pars_url["path"], '.') > 1){
                $pars_url["path"] = stristr($pars_url["path"], '.');
            }else{
                $pars_url["path"] = '.' . $pars_url["path"];
            }

            $domain = $pars_url["path"];
        }

        setcookie($name, '', 0, $path, $domain);
    }
}
