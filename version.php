<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/**
 * Library Search Block - Version definition.
 *
 * @package    block_librarysearch
 * @copyright  2025 Open University of Kenya
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->component  = 'block_librarysearch';   // MUST match folder name exactly.
$plugin->version    = 2025050900;              // Today: 2025-05-09, build 00.
$plugin->requires   = 2022112800;              // Minimum: Moodle 4.1.
$plugin->maturity   = MATURITY_STABLE;         // Options: ALPHA, BETA, RC, STABLE.
$plugin->release    = '1.0.0';                 // Human-readable version.
