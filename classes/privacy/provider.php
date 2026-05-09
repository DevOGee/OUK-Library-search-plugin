<?php
/**
 * Library Search Block - Privacy provider.
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

/**
 * Privacy provider for the Library Search block.
 */
class provider implements
    \core_privacy\local\metadata\null_provider {

    /**
     * Get the language string identifier with the component's name.
     *
     * @return  string
     */
    public static function get_reason(): string {
        return 'privacy:metadata';
    }
}
