<?php
/**
 * Library Search Block - Main block class.
 *
 * @package    block_librarysearch
 * @copyright  2025 Open University of Kenya
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_librarysearch extends block_base {

    /**
     * Initialise the block.
     */
    public function init(): void {
        $this->title = get_string('pluginname', 'block_librarysearch');
    }

    /**
     * Can there be multiple instances?
     */
    public function instance_allow_multiple(): bool {
        return false;
    }

    /**
     * Global config?
     */
    public function has_config(): bool {
        return true;
    }

    /**
     * Instance config?
     */
    public function instance_allow_config(): bool {
        return true;
    }

    /**
     * Applicable formats.
     */
    public function applicable_formats(): array {
        return [
            'all'         => true,
            'my'          => true,
            'site-index'  => true,
            'course-view' => true,
            'admin'       => false,
        ];
    }

    /**
     * Get content.
     */
    public function get_content(): stdClass {
        global $CFG, $USER, $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';

        // Read configuration.
        $libbaseurl       = get_config('block_librarysearch', 'library_base_url') ?: 'https://library.ouk.ac.ke';
        $searchpath       = get_config('block_librarysearch', 'search_path') ?: '/search?q=';
        $enable_sso       = (bool) get_config('block_librarysearch', 'enable_sso');
        $sso_method       = get_config('block_librarysearch', 'sso_method') ?: 'none';
        $sso_secret       = get_config('block_librarysearch', 'sso_secret') ?: '';
        $sso_param        = get_config('block_librarysearch', 'sso_param') ?: 'sso_token';
        $open_newtab      = get_config('block_librarysearch', 'open_newtab') !== '0';
        $enable_quicklinks= (bool) get_config('block_librarysearch', 'enable_quicklinks');
        $placeholder      = get_config('block_librarysearch', 'placeholder') ?: get_string('searchplaceholder', 'block_librarysearch');

        if (!empty($this->config->title)) {
            $this->title = format_string($this->config->title);
        } else {
            $this->title = get_config('block_librarysearch', 'block_title') ?: get_string('defaulttitle', 'block_librarysearch');
        }

        // Generate SSO data.
        $ssodata = '';
        if ($enable_sso && isloggedin() && !isguestuser() && $sso_method !== 'none') {
            if (!empty($sso_secret)) {
                $ssodata = $this->generate_sso_token($USER, $sso_method, $sso_secret);
            }
        }

        // Build quick links.
        $quicklinks = [];
        if ($enable_quicklinks) {
            $quicklinks = [
                ['url' => 'https://research.ebsco.com/c/dzwow6/results', 'label' => get_string('ebooks',     'block_librarysearch'), 'icon' => 'fa-book'],
                ['url' => 'https://research.ebsco.com/c/dzwow6/results', 'label' => get_string('journals',   'block_librarysearch'), 'icon' => 'fa-newspaper-o'],
                ['url' => 'https://erepository.ouk.ac.ke/home',          'label' => get_string('repository', 'block_librarysearch'), 'icon' => 'fa-archive'],
                ['url' => 'https://research.ebsco.com/c/dzwow6/results', 'label' => get_string('opac',       'block_librarysearch'), 'icon' => 'fa-search-plus'],
            ];
        }

        // Prepare data for template.
        $renderdata = [
            'searchurl'   => $libbaseurl . $searchpath,
            'placeholder' => $placeholder,
            'buttontext'  => get_string('searchbutton', 'block_librarysearch'),
            'newtab'      => $open_newtab,
            'quicklinks'  => $quicklinks,
            'ssoparam'    => $sso_param,
            'ssodata'     => $ssodata,
        ];

        // Use custom renderer or Mustache directly.
        $this->content->text = $OUTPUT->render_from_template('block_librarysearch/search', $renderdata);

        return $this->content;
    }

    /**
     * Generate a signed SSO token.
     *
     * @param stdClass $user Moodle user object
     * @param string $method SSO method
     * @param string $secret Shared secret
     * @return string
     */
    protected function generate_sso_token($user, $method, $secret): string {
        switch ($method) {
            case 'token':
                // Simple HMAC token: hmac(email + timestamp, secret)
                $time = time();
                $data = $user->email . '|' . $time;
                $hash = hash_hmac('sha256', $data, $secret);
                return base64_encode($data . '|' . $hash);

            case 'email':
                return base64_encode($user->email);

            default:
                return '';
        }
    }
}
