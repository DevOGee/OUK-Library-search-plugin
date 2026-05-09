<?php
/**
 * Library Search Block - Per-instance configuration form.
 *
 * @package    block_librarysearch
 * @copyright  2025 Open University of Kenya
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_librarysearch_edit_form extends block_edit_form {

    /**
     * Add form elements specific to this block instance.
     *
     * @param MoodleQuickForm $mform The form object
     */
    protected function specific_definition($mform) {

        $mform->addElement(
            'header',
            'configheader',
            get_string('blocksettings', 'block')
        );

        $mform->addElement(
            'text',
            'config_title',
            get_string('config_title', 'block_librarysearch')
        );
        $mform->setType('config_title', PARAM_TEXT);
    }
}
