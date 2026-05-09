<?php
/**
 * Library Search Block - Admin settings page.
 *
 * @package    block_librarysearch
 * @copyright  2025 Open University of Kenya
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    // SECTION 1: Library Connection.
    $settings->add(new admin_setting_heading(
        'block_librarysearch/connection_heading',
        get_string('settings_heading', 'block_librarysearch'),
        get_string('settings_desc', 'block_librarysearch')
    ));

    $settings->add(new admin_setting_configtext(
        'block_librarysearch/library_base_url',
        get_string('library_base_url', 'block_librarysearch'),
        get_string('library_base_url_desc', 'block_librarysearch'),
        'https://library.ouk.ac.ke',
        PARAM_URL
    ));

    $settings->add(new admin_setting_configtext(
        'block_librarysearch/search_path',
        get_string('search_path', 'block_librarysearch'),
        get_string('search_path_desc', 'block_librarysearch'),
        '/search?q=',
        PARAM_RAW_TRIMMED
    ));

    $settings->add(new admin_setting_configcheckbox(
        'block_librarysearch/open_newtab',
        get_string('open_newtab', 'block_librarysearch'),
        get_string('open_newtab_desc', 'block_librarysearch'),
        1
    ));

    $settings->add(new admin_setting_configcheckbox(
        'block_librarysearch/enable_quicklinks',
        get_string('enable_quicklinks', 'block_librarysearch'),
        get_string('enable_quicklinks_desc', 'block_librarysearch'),
        1
    ));

    // SECTION 2: UI Customisation.
    $settings->add(new admin_setting_heading(
        'block_librarysearch/ui_heading',
        'UI Customisation',
        ''
    ));

    $settings->add(new admin_setting_configtext(
        'block_librarysearch/block_title',
        get_string('block_title_setting', 'block_librarysearch'),
        get_string('block_title_setting_desc', 'block_librarysearch'),
        get_string('defaulttitle', 'block_librarysearch'),
        PARAM_TEXT
    ));

    $settings->add(new admin_setting_configtext(
        'block_librarysearch/placeholder',
        get_string('placeholder_setting', 'block_librarysearch'),
        get_string('placeholder_setting_desc', 'block_librarysearch'),
        get_string('searchplaceholder', 'block_librarysearch'),
        PARAM_TEXT
    ));

    // SECTION 3: SSO.
    $settings->add(new admin_setting_heading(
        'block_librarysearch/sso_heading',
        get_string('sso_heading', 'block_librarysearch'),
        get_string('sso_heading_desc', 'block_librarysearch')
    ));

    $settings->add(new admin_setting_configcheckbox(
        'block_librarysearch/enable_sso',
        get_string('enable_sso', 'block_librarysearch'),
        get_string('enable_sso_desc', 'block_librarysearch'),
        0
    ));

    $ssomethods = [
        'none'   => get_string('sso_none',   'block_librarysearch'),
        'token'  => get_string('sso_token',  'block_librarysearch'),
        'jwt'    => get_string('sso_jwt',    'block_librarysearch'),
        'oauth2' => get_string('sso_oauth2', 'block_librarysearch'),
        'cas'    => get_string('sso_cas',    'block_librarysearch'),
        'email'  => get_string('sso_email',  'block_librarysearch'),
    ];
    $settings->add(new admin_setting_configselect(
        'block_librarysearch/sso_method',
        get_string('sso_method', 'block_librarysearch'),
        get_string('sso_method_desc', 'block_librarysearch'),
        'none',
        $ssomethods
    ));

    $settings->add(new admin_setting_configpasswordunmask(
        'block_librarysearch/sso_secret',
        get_string('sso_secret', 'block_librarysearch'),
        get_string('sso_secret_desc', 'block_librarysearch'),
        ''
    ));

    $settings->add(new admin_setting_configtext(
        'block_librarysearch/sso_param',
        get_string('sso_param', 'block_librarysearch'),
        get_string('sso_param_desc', 'block_librarysearch'),
        'sso_token',
        PARAM_ALPHANUMEXT
    ));

    $settings->add(new admin_setting_configtext(
        'block_librarysearch/sso_client_id',
        get_string('sso_client_id', 'block_librarysearch'),
        get_string('sso_client_id_desc', 'block_librarysearch'),
        '',
        PARAM_RAW_TRIMMED
    ));

    $settings->add(new admin_setting_configpasswordunmask(
        'block_librarysearch/sso_client_secret',
        get_string('sso_client_secret', 'block_librarysearch'),
        get_string('sso_client_secret_desc', 'block_librarysearch'),
        ''
    ));
}
