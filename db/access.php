<?php
/**
 * Library Search Block - Capability definitions.
 *
 * @package    block_librarysearch
 * @copyright  2025 Open University of Kenya
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$capabilities = [
    'block/librarysearch:addinstance' => [
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => [
            'editingteacher' => CAP_ALLOW,
            'teacher'        => CAP_ALLOW,
            'manager'        => CAP_ALLOW,
            'coursecreator'  => CAP_ALLOW,
        ],
        'clonepermissionsfrom' => 'moodle/site:manageblocks',
    ],

    'block/librarysearch:myaddinstance' => [
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'captype'     => 'write',
        'contextlevel'=> CONTEXT_SYSTEM,
        'archetypes'  => [
            'user'    => CAP_ALLOW,
            'student' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
        ],
    ],

    'block/librarysearch:view' => [
        'captype'     => 'read',
        'contextlevel'=> CONTEXT_BLOCK,
        'archetypes'  => [
            'guest'          => CAP_ALLOW,
            'user'           => CAP_ALLOW,
            'student'        => CAP_ALLOW,
            'teacher'        => CAP_ALLOW,
            'editingteacher' => CAP_ALLOW,
            'manager'        => CAP_ALLOW,
            'coursecreator'  => CAP_ALLOW,
            'frontpage'      => CAP_ALLOW,
        ],
    ],
];
