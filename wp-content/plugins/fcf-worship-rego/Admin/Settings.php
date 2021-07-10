<?php


namespace WorshipRego\Admin;

use WorshipRego\Admin\SettingsBase;
use WorshipRego\Admin\Admin_List_Table;

// If this file is called directly, abort.
if (!defined('ABSPATH')) exit;

/**
 * Settings of the admin area.
 * Add the appropriate suffix constant for every field ID to take advantake the standardized sanitizer.
 *
 * @since      1.0.0
 *
 * @package    WorshipRego
 * @subpackage WorshipRego/Admin
 */
class Settings extends SettingsBase
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     */
    private string $pluginSlug;

    /**
     * The slug name for the menu.
     * Should be unique for this menu page and only include
     * lowercase alphanumeric, dashes, and underscores characters to be compatible with sanitize_key().
     *
     * @since    1.0.0
     */
    private string $menuSlug;

    /**
     * General settings' group name.
     *
     * @since    1.0.0
     */
    private string $generalOptionGroup;
    private string $exampleOptionGroup;

    /**
     * General settings' section.
     * The slug-name of the section of the settings page in which to show the box.
     *
     * @since    1.0.0
     */
    private string $generalSettingsSectionId;
    private string $exampleSettingsSectionId;

    /**
     * General settings page.
     * The slug-name of the settings page on which to show the section.
     *
     * @since    1.0.0
     */
    private string $generalPage;
    private string $examplePage;

    /**
     * Name of general options. Expected to not be SQL-escaped.
     *
     * @since    1.0.0
     */
    private string $generalOptionName;
    private string $exampleOptionName;

    /**
     * Collection of options.
     *
     * @since    1.0.0
     */
    private array $generalOptions;
    private array $exampleOptions;

    /**
     * Ids of setting fields.
     */
    private string $debugId;

    private string $textExampleId;
    private string $textareaExampleId;
    private string $checkboxExampleId;
    private string $radioExampleId;
    private string $selectExampleId;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    $pluginSlug       The name of this plugin.
     */
    public function __construct(string $pluginSlug)
    {
        $this->pluginSlug = $pluginSlug;
        $this->menuSlug = $this->pluginSlug;

        /**
         * General
         */
        $this->generalOptionGroup = $pluginSlug . '-general-option-group';
        $this->generalSettingsSectionId = $pluginSlug . '-general-section';
        $this->generalPage = $pluginSlug . '-general';
        $this->generalOptionName = $pluginSlug . '-general';

        $this->debugId = 'debug' . self::CHECKBOX_SUFFIX;

        /**
         * Input example
         */
        $this->exampleOptionGroup = $pluginSlug . '-example-option-group';
        $this->exampleSettingsSectionId = $pluginSlug . '-example-section';
        $this->examplePage = $pluginSlug . '-example';
        $this->exampleOptionName = $pluginSlug . '-example';

        $this->textExampleId = 'text-example' . self::TEXT_SUFFIX;
        $this->textareaExampleId = 'textarea-example' . self::TEXTAREA_SUFFIX;
        $this->checkboxExampleId = 'checkbox-example' . self::CHECKBOX_SUFFIX;
        $this->radioExampleId = 'radio-example' . self::RADIO_SUFFIX;
        $this->selectExampleId = 'select-example' . self::SELECT_SUFFIX;
    }

    /**
     * Register all the hooks of this class.
     *
     * @since    1.0.0
     * @param   $isAdmin    Whether the current request is for an administrative interface page.
     */
    public function initializeHooks(bool $isAdmin): void
    {
        // Admin
        if ($isAdmin)
        {
            add_action('admin_menu', array($this, 'setupSettingsMenu'), 10);
            add_action('admin_init', array($this, 'initializeGeneralOptions'), 10);

        }
    }

    /**
     * This function introduces the plugin options into the Main menu.
     */
    public function setupSettingsMenu(): void
    {
        //Add the menu item to the Main menu
        add_menu_page(
            'Worship Registration Options',                      // Page title: The title to be displayed in the browser window for this page.
            'Worship',                              // Menu title: The text to be used for the menu.
            'manage_options',                           // Capability: The capability required for this menu to be displayed to the user.
            $this->menuSlug,                            // Menu slug: The slug name to refer to this menu by. Should be unique for this menu page.
            array($this, 'renderSettingsPageContent'),  // Callback: The name of the function to call when rendering this menu's page
            'dashicons-smiley',                         // Icon
            81                                          // Position: The position in the menu order this item should appear.
        );

        
    }

    /**
     * Renders the Settings page to display for the Settings menu defined above.
     *
     * @since   1.0.0
     * @param   activeTab       The name of the active tab.
     */
    public function renderSettingsPageContent(string $activeTab = ''): void
    {

        // Check user capabilities
        if (!current_user_can('manage_options'))
        {
            return;
        }

        // Add error/update messages
        // check if the user have submitted the settings. Wordpress will add the "settings-updated" $_GET parameter to the url
        if (isset($_GET['settings-updated']))
        {
            // Add settings saved message with the class of "updated"
            add_settings_error($this->pluginSlug, $this->pluginSlug . '-message', __('Settings saved.'), 'success');
        }

        // Show error/update messages
        settings_errors($this->pluginSlug);

        ?>

        <!-- Create a header in the default WordPress 'wrap' container -->
        <div class="wrap">
          <h2><?php esc_html_e('Worship Registration', 'worship-rego'); ?></h2>
            <div>
            </div>
        </div>
        <?php

        $registration_list_table = new Admin_List_Table();
        $registration_list_table->prepare_items();
        ?>
            <div class="wrap">
                <div id="icon-users" class="icon32"></div>
                <?php $registration_list_table->display(); ?>
            </div>
        <?php

    }


    /**
     * Initializes the General Options by registering the Sections, Fields, and Settings.
     *
     * This function is registered with the 'admin_init' hook.
     */
    public function initializeGeneralOptions(): void
    {




    }

    /**
     * Return the General options.
     */
    public function getGeneralOptions(): array
    {
        if (isset($this->generalOptions))
        {
            return $this->generalOptions;
        }

        $this->generalOptions = get_option($this->generalOptionName, array());

        // If options don't exist, create them.
        if ($this->generalOptions === array())
        {
            $this->generalOptions = $this->defaultGeneralOptions();
            update_option($this->generalOptionName, $this->generalOptions);
        }

        return $this->generalOptions;
    }

    /**
     * Provide default values for the General Options.
     *
     * @return array
     */
    private function defaultGeneralOptions(): array
    {
        return array(
            $this->debugId => false
        );
    }

    /**
     * This function provides a simple description for the General Options page.
     *
     * It's called from the initializeGeneralOptions function by being passed as a parameter
     * in the add_settings_section function.
     */
    public function generalOptionsCallback(): void
    {
        // Display the settings data for easier examination. Delete it, if you don't need it.
        echo '<p>Display the settings as stored in the database:</p>';
        $this->generalOptions = $this->getGeneralOptions();
        var_dump($this->generalOptions);

        echo '<p>' . esc_html__('General options.', 'worship-rego') . '</p>';
    }

    public function debugCallback(): void
    {
        printf('<input type="checkbox" id="%s" name="%s[%s]" value="1" %s />', $this->debugId, $this->generalOptionName, $this->debugId, checked($this->generalOptions[$this->debugId], true, false));
    }

    /**
     * Get Debug option.
     */
    public function getDebug(): bool
    {
        $this->generalOptions = $this->getGeneralOptions();
        return (bool)$this->generalOptions[$this->debugId];
    }

}

