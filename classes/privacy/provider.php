<?php
/**
 * Library Search Block - Privacy API implementation.
 *
 * This provides the privacy provider for the block, allowing Moodle to
 * identify that this plugin does not store persistent personal data in the database,
 * although it uses session storage for UX purposes.
 *
 * @package    block_librarysearch
 * @copyright  2025 Open University of Kenya
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_librarysearch\privacy;

defined('MOODLE_INTERNAL') || die();

use core_privacy\local\metadata\collection;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\userlist;

/**
 * Privacy Subsystem for the Library Search block.
 */
class provider implements
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\plugin\provider {

    /**
     * Returns metadata about the data stored by this plugin.
     *
     * @param collection $items The collection to add metadata to.
     * @return collection The updated collection.
     */
    public static function get_metadata(collection $items): collection {
        // This plugin does not store any personal data in the Moodle database.
        // It uses browser sessionStorage and localStorage for search history and query persistence.
        return $items;
    }

    /**
     * Get the list of contexts where data is stored for this user.
     *
     * @param int $userid The user to get contexts for.
     * @return contextlist The list of contexts.
     */
    public static function get_contexts_for_userid(int $userid): contextlist {
        return new contextlist();
    }

    /**
     * Export all user data for the specified contexts.
     *
     * @param approved_contextlist $contextlist The list of contexts.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        // No data to export.
    }

    /**
     * Delete all user data for this user from the list of contexts.
     *
     * @param approved_contextlist $contextlist The list of contexts.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        // No data to delete.
    }

    /**
     * Delete all user data for this user from the list of contexts.
     *
     * @param approved_contextlist $contextlist The list of contexts.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        // No data to delete.
    }
}
