<?php

namespace WorshipRegistration\Frontend;

// If this file is called directly, abort.
if (!defined('ABSPATH')) exit;

/**
 * Contact form and Shortcode template.
 *
 * @link       http://example.com
 * @since      1.0.0
 * @package    WorshipRegistration
 * @subpackage WorshipRegistration/Includes
 * @author     Your Name <email@example.com>
 */
class ContactForm
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     */
    private string $pluginSlug;

    /**
     * Initialize the class and set its properties.
     *
     * @since   1.0.0
     * @param   $pluginSlug     The name of the plugin.
     * @param   $version        The version of this plugin.
     */
    public function __construct(string $pluginSlug)
    {
        $this->pluginSlug = $pluginSlug;
    }

    /**
     * Register all the hooks of this class.
     *
     * @since   1.0.0
     * @param   $isAdmin    Whether the current request is for an administrative interface page.
     */
    public function initializeHooks(bool $isAdmin): void
    {
        if (!$isAdmin)
        {
            add_shortcode('add_worship_registration_form', array($this, 'formShortcode'));
        }
    }

    /**
     * Contact form shortcode.
     *
     * @link https://developer.wordpress.org/reference/functions/add_shortcode/
     * Shortcode attribute names are always converted to lowercase before they are passed into the handler function. Values are untouched.
     *
     * The function called by the shortcode should never produce output of any kind.
     * Shortcode functions should return the text that is to be used to replace the shortcode.
     * Producing the output directly will lead to unexpected results.
     *
     * @since   1.0.0
     * @param   $attributes Attributes.
     * @param   $content    The post content.
     * @param   $tag        The name of the shortcode.
     * @return  The text that is to be used to replace the shortcode.
     */
    public function formShortcode($attributes = null, $content = null, string $tag = ''): string
    {
        // Enqueue scripts
        wp_enqueue_script($this->pluginSlug . 'contact-form');

        // Inline scripts. This is how we pass data to scripts
        $script  = 'ajaxUrl = ' . json_encode(admin_url('admin-ajax.php')) . '; ';
        $script .= 'nonce = ' . json_encode(wp_create_nonce('capitalizeText')) . '; ';
        if (wp_add_inline_script($this->pluginSlug . 'contact-form', $script, 'before') === false)
        {
            // It throws error on the Post edit screen and I don't know why. It works on the frontend.
            // exit('wp_add_inline_script() failed. Inlined script: ' . $script);
        }

        global $wpdb;

        $table_name = $wpdb->prefix . 'worship_registration';

        if ( pll_current_language()=='en' ) {
            $session = 'English';
        } else {
            $session = 'Chinese';
        }

        $worshipers = $wpdb->get_row( "
                  SELECT COUNT(*) as count FROM $table_name
                  WHERE session = '$session'
                  AND is_del = 0" );

        $worship_registration_options = get_option('worship-registration-options');

        if ( $session == 'English' && $worshipers->count >= $worship_registration_options['english-limit'] ) {
            $html = '<p>Registration is closed.</p>';
        } else if ( $session == 'Chinese' && $worshipers->count >= $worship_registration_options['chinese-limit']) {
            $html = '<p>Registration is closed.</p>';
        } else {
            $html = $this->getFormHtml();
            $this->processFormData();
        }

        return $html;
    }

    /**
     * This is a template how to receive data from a script, then return data back.
     * In this case it returns a text in capitalized.
     *
     * @since   1.0.0
     */
    public function capitalizeText()
    {
        // Verifies the AJAX request
        if (check_ajax_referer('capitalizeText', 'nonce', false) === false)
        {
            wp_send_json_error('Failed nonce', 403); // Sends json_encoded success=false.
        }

        // Sanitize values
        $text = sanitize_text_field($_POST['text']);

        // Generate response data
        $responseData = array(
            'capitalizedText' => strtoupper($text)
        );

        // Send a JSON response back to an AJAX request, and die().
        wp_send_json($responseData, 200);
    }

    /**
     * The Form's HTML code.
     * @since    1.0.0
     * @return  The form's HTML code.
     */
    private function getFormHtml(): string
    {
        $html = '<div>
            <p id="capitalized-subject"></p>
            <form action="' . esc_url($_SERVER['REQUEST_URI']) . '" method="post" id="worship-registration">
            <input type="hidden" name="token" id="token" />
            <input type="hidden" name="action" id="action" />
            <p>' . wp_nonce_field('getFormHtml', 'getFormHtml_nonce', true, false) . '</p>
            <p>
            <label for="fullname">' . pll__('Name') . '&nbsp;<span class="required">*</span></label>
            <input type="text" id="fullname" name="fullname" required />
            </p>
            <p>
            <label for="email">' . pll__('Email') . '&nbsp;<span class="required"></span></label>
            <input type="email" id="email" name="email" />
            </p>
            <p>
            <label for="phone_number">' . pll__('Mobile Phone Number') . '&nbsp;<span class="required"></span></label>
            <input type="number" id="phone_number" name="phone_number" />
            </p>
            <p>
            <label for="services">' . pll__('Which service will you be attending?') . '&nbsp;<span class="required">*</span></label>
            <div>
              <input type="checkbox" id="bob" value="bob" name="services[]">
              <label for="bob">BOB</label>
            </div>
            <div>
              <input type="checkbox" id="worship service" value="worship service" name="services[]">
              <label for="worship_service">Worship Service</label>
            </div>
            <div>
              <input type="checkbox" id="nursery" value="nursery" name="services[]">
              <label for="nursery">Nursery</label>
            </div>
            <div>
              <input type="checkbox" id="jss" value="jss" name="services[]">
              <label for="jss">JSS</label>
            </div>
           </p>
            <p><input type="submit" name="form-submitted" value="' . esc_html__('Submit', 'worship-registration') . '"/></p>
            </form>
            <script src="https://www.google.com/recaptcha/api.js?render=6LcNW8sZAAAAAKj4DH9Vpv9bQz1OMvDG7niQPn0K"></script>
            <script type="text/javascript">
            jQuery(document).ready(function(){
            setInterval(function(){
            grecaptcha.ready(function() {
            grecaptcha.execute("6LcNW8sZAAAAAKj4DH9Vpv9bQz1OMvDG7niQPn0K", {action: "application_form"}).then(function(token) {
            jQuery("#token").val(token);
            jQuery("#action").val("application_form");
            });
            });
            }, 3000);
            });
            </script>
            </div>';

        return $html;
    }

    /**
     * Validates and process the submitted data.
     * @since    1.0.0
     */
    private function processFormData(): void
    {
        global $wpdb;

        // Check the Submit button is clicked
        if(isset($_POST['form-submitted']))
        {

            $token  = $_POST['token'];
            $action = $_POST['action'];

            $curlData = array(
                'secret' => '6LcNW8sZAAAAALhdRufDj4HojxyNMgqPVB0By78u',
                'response' => $token
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($curlData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $curlResponse = curl_exec($ch);

            $captchaResponse = json_decode($curlResponse, true);

            // Verify Nonce
            if (wp_verify_nonce($_POST['getFormHtml_nonce'], 'getFormHtml') !== false)
            {

                $fullname = sanitize_text_field($_POST["fullname"]);
                $email = sanitize_email($_POST["email"]);
                $phone_number = sanitize_text_field($_POST["phone_number"]);
                if ( is_array ( $_POST['services'] ) ) {
                    $services = $_POST['services'];
                    $checked_services = implode(', ', $services);
                }

                if ( pll_current_language()=='en' ) {
                    $session = 'English';
                } else {
                    $session = 'Chinese';
                }

                $table_name = $wpdb->prefix . 'worship_registration';

                $is_duplicate = $wpdb->get_row( "
                  SELECT * FROM $table_name
                  WHERE fullname = '$fullname'
                  AND is_del = 0
                  " );

                // if ( isset($fullname) && !isset($is_duplicate) && $captchaResponse['success'] == '1' && $captchaResponse['action'] == $action && $captchaResponse['score'] >= 0.5 && $captchaResponse['hostname'] == $_SERVER['SERVER_NAME'] ) {
                if ( isset($fullname) && !isset($is_duplicate) ) {
                  $inserted = $wpdb->insert(
                  $table_name,
                  array(
                      'time' => date('Y-m-d H:i:s'),
                      'fullname' => $fullname,
                      'email' => $email,
                      'phone_number' => $phone_number,
                      'service' => $checked_services,
                      'session' => $session
                  ));
                  if ( $inserted ) {
                    echo("<script> jQuery('#worship-registration')[0].reset();</script>");
                    echo "<p>".pll__('Thank you')."</p>";
                  } else {
                    echo "<p>Form submission failed.</p>";
                  }

                } else {

                  echo "<p>".pll__('Worship duplicate message')."</p>";

                }

            } else {

              exit(esc_html__('Failed security check.', 'worship-registration'));

            }
        }
    }
}
