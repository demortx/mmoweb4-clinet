class BeFormWizard {
    /*
     * Init Wizard defaults
     *
     */
    static initWizardDefaults() {
        jQuery.fn.bootstrapWizard.defaults.tabClass         = 'nav nav-tabs';
        jQuery.fn.bootstrapWizard.defaults.nextSelector     = '[data-wizard="next"]';
        jQuery.fn.bootstrapWizard.defaults.previousSelector = '[data-wizard="prev"]';
        jQuery.fn.bootstrapWizard.defaults.firstSelector    = '[data-wizard="first"]';
        jQuery.fn.bootstrapWizard.defaults.lastSelector     = '[data-wizard="lsat"]';
        jQuery.fn.bootstrapWizard.defaults.finishSelector   = '[data-wizard="finish"]';
        jQuery.fn.bootstrapWizard.defaults.backSelector     = '[data-wizard="back"]';
    }

    /*
     * Init simple wizard, for more examples you can check out https://github.com/VinceG/twitter-bootstrap-wizard
     *
     */
    static initWizardSell() {
        jQuery('.js-wizard-simple').bootstrapWizard({
            onTabShow: (tab, navigation, index) => {
                let percent = ((index + 1) / navigation.find('li').length) * 100;

                // Get progress bar
                let progress = navigation.parents('.block').find('[data-wizard="progress"] > .progress-bar');

                // Update progress bar if there is one
                if (progress.length) {
                    progress.css({ width: percent + 1 + '%' });
                }
            }
        });
    }


    /*
     * Init functionality
     *
     */
    static init() {
        this.initWizardDefaults();
        this.initWizardSell();

    }
}

// Initialize when page loads
jQuery(() => { BeFormWizard.init(); });
