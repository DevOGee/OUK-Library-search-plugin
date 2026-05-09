<?php
/**
 * Library Search Block - English language strings.
 *
 * @package    block_librarysearch
 * @copyright  2025 Open University of Kenya
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname']         = 'Library Search';
$string['librarysearch']      = 'Library Search';
$string['defaulttitle']       = 'Library Search';
$string['searchplaceholder']  = 'Search books, journals, theses...';
$string['searchbutton']       = 'Search Library';
$string['openlibrary']        = 'Open Library Portal';
$string['advancedsearch']     = 'Advanced Search';
$string['quicklinks']         = 'Quick Links';
$string['ebooks']             = 'E-Books';
$string['journals']           = 'Journals';
$string['repository']         = 'Repository';
$string['opac']               = 'OPAC';
$string['logintosearch']      = 'Please log in to search the library with SSO.';
$string['noresults']          = 'No results found. Try different keywords.';

// Capability strings.
$string['librarysearch:addinstance']   = 'Add a Library Search block';
$string['librarysearch:myaddinstance'] = 'Add a Library Search block to Dashboard';
$string['librarysearch:view']          = 'View Library Search block';

// Admin settings.
$string['settings_heading']         = 'Library Connection Settings';
$string['settings_desc']            = 'Configure how this block connects to your university library system.';
$string['library_base_url']         = 'Library Base URL';
$string['library_base_url_desc']    = 'Root URL of your library portal. Example: https://library.ouk.ac.ke';
$string['search_path']              = 'Search Path';
$string['search_path_desc']         = 'URL path for search queries. Example: /search?q= OR /cgi-bin/koha/opac-search.pl?q=';
$string['open_newtab']              = 'Open results in new tab';
$string['open_newtab_desc']         = 'When checked, library search results open in a new browser tab.';
$string['enable_quicklinks']        = 'Show quick links';
$string['enable_quicklinks_desc']   = 'Show E-Books, Journals, Repository, OPAC links below the search box.';
$string['block_title_setting']      = 'Default Block Title';
$string['block_title_setting_desc'] = 'Default title shown at the top of the block.';
$string['placeholder_setting']      = 'Search Input Placeholder';
$string['placeholder_setting_desc'] = 'Text shown inside the empty search box.';

// SSO settings.
$string['sso_heading']       = 'SSO (Single Sign-On) Settings';
$string['sso_heading_desc']  = 'Optional: Configure SSO so users are automatically authenticated in the library.';
$string['enable_sso']        = 'Enable SSO';
$string['enable_sso_desc']   = 'Pass a signed identity token to the library when searching.';
$string['sso_method']        = 'SSO Method';
$string['sso_method_desc']   = 'Authentication method supported by your library system.';
$string['sso_secret']        = 'Shared Secret';
$string['sso_secret_desc']   = 'Secret key shared between Moodle and the library server. Minimum 32 characters.';
$string['sso_param']         = 'Token Parameter Name';
$string['sso_param_desc']    = 'Query string parameter name the library expects. Example: sso_token, auth, ticket';
$string['sso_client_id']     = 'Client ID (OAuth2)';
$string['sso_client_id_desc']= 'OAuth2 Client ID if using OAuth2/OpenID Connect method.';
$string['sso_client_secret'] = 'Client Secret (OAuth2)';
$string['sso_client_secret_desc'] = 'OAuth2 Client Secret.';

// SSO method option labels.
$string['sso_none']   = 'None — Public search only (no authentication)';
$string['sso_token']  = 'HMAC Token — Signed token (Recommended for Koha/custom systems)';
$string['sso_jwt']    = 'JWT — JSON Web Token (For FOLIO, Ex Libris Alma/Primo)';
$string['sso_oauth2'] = 'OAuth2/OpenID Connect (For Azure AD, Google Workspace)';
$string['sso_cas']    = 'CAS — Central Authentication Service';
$string['sso_email']  = 'Email passthrough — Internal/trusted networks only';

// Instance config.
$string['config_title']      = 'Custom block title';
$string['config_title_desc'] = 'Override the global default title for this specific block instance.';

// Error strings.
$string['error_nosecret']    = 'SSO is enabled but no shared secret is configured.';
$string['error_nourl']       = 'Library base URL is not configured.';

// Privacy strings.
$string['privacy:metadata'] = 'The Library Search block only displays search functionality and does not store any personal data itself. However, it may pass user identification (like email or username) to the library system if SSO is enabled.';
