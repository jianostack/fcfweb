<?php
declare(strict_types=1);

namespace WorshipRegistration\Admin;

use WorshipRegistration\Admin\SettingsBase;
use WorshipRegistration\Admin\Admin_List_Table;

// If this file is called directly, abort.
if (!defined('ABSPATH')) exit;

/**
 * Settings of the admin area.
 * Add the appropriate suffix constant for every field ID to take advantake the standardized sanitizer.
 *
 * @since      1.0.0
 *
 * @package    WorshipRegistration
 * @subpackage WorshipRegistration/Admin
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
    private string $worshipLimitsSection;

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

    private string $englishLimit;
    private string $chineseLimit;
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
        $this->worshipLimitsSection = $pluginSlug . '-example-section';
        $this->examplePage = $pluginSlug . '-example';
        $this->exampleOptionName = $pluginSlug . '-options';

        $this->englishLimit = 'english-limit';
        $this->chineseLimit = 'chinese-limit';
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
            add_action('admin_init', array($this, 'initializeInputExamples'), 10);
        }
    }

    /**
     * This function introduces the plugin options into the Main menu.
     */
    public function setupSettingsMenu(): void
    {
      add_menu_page('Worship Registration','Worship','manage_options',$this->menuSlug,array($this, 'renderSettingsPageContent'),'dashicons-smiley',81);
      add_submenu_page( 'worship-registration', 'Worship Options', 'Options', 'manage_options', 'worship-options', array($this, 'renderSettingsPageOptions') );
    }

    public function renderSettingsPageOptions(string $activeTab = ''): void
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

            <h2><?php esc_html_e('Worship Registration Options', 'worship-registration'); ?></h2>

            <form method="post" action="options.php">
              <?php
              settings_fields($this->exampleOptionGroup);
              do_settings_sections($this->examplePage);
              submit_button();
              ?>
            </form>

        </div><!-- /.wrap -->
        <?php
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
          <h2><?php esc_html_e('Worship Registration', 'worship-registration'); ?></h2>
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
      // Get the values of the setting we've registered with register_setting(). It used in the callback functions.
      $this->generalOptions = $this->getGeneralOptions();

        // Add a new section to a settings page.
      add_settings_section(
            $this->generalSettingsSectionId,            // ID used to identify this section and with which to register options
            __('General', 'worship-registration'),               // Title to be displayed on the administration page
            array($this, 'generalOptionsCallback'),     // Callback used to render the description of the section
            $this->generalPage                          // Page on which to add this section of options
          );

        // Next, we'll introduce the fields for toggling the visibility of content elements.
      add_settings_field(
            $this->debugId,                        // ID used to identify the field throughout the theme.
            __('Debug', 'worship-registration'),            // The label to the left of the option interface element.
            array($this, 'debugCallback'),         // The name of the function responsible for rendering the option interface.
            $this->generalPage,                    // The page on which this option will be displayed.
            $this->generalSettingsSectionId,       // The name of the section to which this field belongs.
            array('label_for' => $this->debugId)   // Extra arguments used when outputting the field. CSS Class can also be added to the <tr> element with the 'class' key.
          );

        // Finally, we register the fields with WordPress.
        /**
         * If you want to use the setting in the REST API (wp-json/wp/v2/settings),
         * you’ll need to call register_setting() on the rest_api_init action, in addition to the normal admin_init action.
         */
        $registerSettingArguments = array(
          'type' => 'array',
          'description' => '',
          'sanitize_callback' => array($this, 'sanitizeOptionsCallback'),
          'show_in_rest' => false
        );
        register_setting($this->generalOptionGroup, $this->generalOptionName, $registerSettingArguments);
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
        // var_dump($this->generalOptions);

        echo '<p>' . esc_html__('General options.', 'worship-registration') . '</p>';
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

    /**
     * Initializes the plugins's input example by registering the Sections, Fields, and Settings.
     * This particular group of options is used to demonstration validation and sanitization.
     *
     * This function is registered with the 'admin_init' hook.
     */
    public function initializeInputExamples(): void
    {
        $this->exampleOptions = $this->getExampleOptions();

        add_settings_section($this->worshipLimitsSection, __('Limits', 'worship-registration'), array($this, 'inputExamplesCallback'), $this->examplePage);

        add_settings_field($this->englishLimit, __('English session limit', 'worship-registration'), array($this, 'inputElementCallback'), $this->examplePage, $this->worshipLimitsSection, array('label_for' => $this->englishLimit));

        add_settings_field($this->chineseLimit, __('Chinese session limit', 'worship-registration'), array($this, 'inputElementCallbacktwo'), $this->examplePage, $this->worshipLimitsSection, array('label_for' => $this->chineseLimit));

        $registerSettingArguments = array(
            'type' => 'array',
            'description' => '',
            'sanitize_callback' => array($this, 'sanitizeOptionsCallback'),
            'show_in_rest' => false
        );
        register_setting($this->exampleOptionGroup, $this->exampleOptionName, $registerSettingArguments);

    }

    /**
     * Return the Example options.
     */
    public function getExampleOptions(): array
    {
        if (isset($this->exampleOptions))
        {
            return $this->exampleOptions;
        }

        $this->exampleOptions = get_option($this->exampleOptionName, array());

        // If the options don't exist, create them.
        if ($this->exampleOptions === array())
        {
            $this->exampleOptions = $this->defaultInputOptions();
            update_option($this->exampleOptionName, $this->exampleOptions);
        }

        return $this->exampleOptions;
    }

    /**
     * Provides default values for the Input Options.
     *
     * @return array
     */
    private function defaultInputOptions(): array
    {
        return array(
            $this->englishLimit => 250,
            $this->chineseLimit => 250,
        );
    }

    /**
     * This function provides a simple description for the Input Examples page.
     */
    public function inputExamplesCallback(): void
    {
        // Display the settings data for easier examination. Delete it, if you don't need it.
        $this->exampleOptions = $this->getExampleOptions();
        // echo '<p>Display the settings as stored in the database:</p>';
        // var_dump($this->exampleOptions);

        // echo '<p>' . esc_html__('Provides examples of the five basic element types.', 'worship-registration') . '</p>';
    }

    public function inputElementCallback(): void
    {
        printf('<input type="text" id="%s" name="%s[%s]" value="%s" />', $this->englishLimit, $this->exampleOptionName, $this->englishLimit, esc_attr($this->exampleOptions[$this->englishLimit]));
    }

    public function inputElementCallbacktwo(): void
    {
        printf('<input type="text" id="%s" name="%s[%s]" value="%s" />', $this->chineseLimit, $this->exampleOptionName, $this->chineseLimit, esc_attr($this->exampleOptions[$this->chineseLimit]));
    }

    public function textareaElementCallback(): void
    {
        printf('<textarea id="%s" name="%s[%s]" rows="5" cols="50">%s</textarea>', $this->textareaExampleId, $this->exampleOptionName, $this->textareaExampleId, esc_textarea($this->exampleOptions[$this->textareaExampleId]));
    }

    /**
     * This function renders the interface elements for toggling the visibility of the checkbox element.
     *
     * It accepts an array or arguments and expects the first element in the array to be the description
     * to be displayed next to the checkbox.
     */
    public function checkboxElementCallback(): void
    {
        // We update the name attribute to access this element's ID in the context of the display options array.
        // We also access the show_header element of the options collection in the call to the checked() helper function.
        $html = sprintf('<input type="checkbox" id="%s" name="%s[%s]" value="1" %s />', $this->checkboxExampleId, $this->exampleOptionName, $this->checkboxExampleId, checked($this->exampleOptions[$this->checkboxExampleId], true, false));
        $html .= '&nbsp;';

        // Here, we'll take the first argument of the array and add it to a label next to the checkbox
        $html .= sprintf('<label for="%s">This is an example of a checkbox</label>', $this->checkboxExampleId);

        echo $html;
    }

    public function radioElementCallback(): void
    {
        $html = sprintf('<input type="radio" id="radio-example-one" name="%s[%s]" value="1" %s />', $this->exampleOptionName, $this->radioExampleId, checked($this->exampleOptions[$this->radioExampleId], 1, false));
        $html .= '&nbsp;';
        $html .= '<label for="radio-example-one">Option One</label>';
        $html .= '&nbsp;';
        $html .= sprintf('<input type="radio" id="radio-example-two" name="%s[%s]" value="2" %s />', $this->exampleOptionName, $this->radioExampleId, checked($this->exampleOptions[$this->radioExampleId], 2, false));
        $html .= '&nbsp;';
        $html .= '<label for="radio-example-two">Option Two</label>';

        echo $html;
    }

    public function selectElementCallback(): void
    {
        $html = sprintf('<select id="%s" name="%s[%s]">', $this->selectExampleId, $this->exampleOptionName, $this->selectExampleId);
        $html .= '<option value="default">' . esc_html__('Select a time option...', 'worship-registration') . '</option>';
        $html .= sprintf('<option value="never" %s >%s</option>', selected($this->exampleOptions[$this->selectExampleId], 'never', false), esc_html__('Never', 'worship-registration'));
        $html .= sprintf('<option value="sometimes" %s >%s</option>', selected($this->exampleOptions[$this->selectExampleId], 'sometimes', false), esc_html__('Sometimes', 'worship-registration'));
        $html .= sprintf('<option value="always" %s >%s</option>', selected($this->exampleOptions[$this->selectExampleId], 'always', false), esc_html__('Always', 'worship-registration'));
        $html .= '</select>';

        echo $html;
    }

    /**
     * Get Text Example option.
     */
    public function getTextExample(): string
    {
        $this->exampleOptions = $this->getExampleOptions();
        return $this->exampleOptions[$this->englishLimit];
    }

    /**
     * Get Textarea Example option.
     */
    public function getTextareaExample(): string
    {
        $this->exampleOptions = $this->getExampleOptions();
        return $this->exampleOptions[$this->textareaExampleId];
    }

    /**
     * Get Checkbox Example option.
     */
    public function getCheckboxExample(): string
    {
        $this->exampleOptions = $this->getExampleOptions();
        return (bool)$this->exampleOptions[$this->checkboxExampleId];
    }

    /**
     * Get Radio Example option.
     */
    public function getRadioExample(): string
    {
        $this->exampleOptions = $this->getExampleOptions();
        return $this->exampleOptions[$this->radioExampleId];
    }

    /**
     * Get Select Example option.
     */
    public function getSelectExample(): string
    {
        $this->exampleOptions = $this->getExampleOptions();
        return $this->exampleOptions[$this->selectExampleId];
    }
}

