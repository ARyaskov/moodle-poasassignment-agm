<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * This file keeps track of upgrades to the poasassignment module
 *
 * Sometimes, changes between versions involve alterations to database
 * structures and other major things that may break installations. The upgrade
 * function in this file will attempt to perform all the necessary actions to
 * upgrade your older installtion to the current version. If there's something
 * it cannot do itself, it will tell you what you need to do.  The commands in
 * here will all be database-neutral, using the functions defined in
 * lib/ddllib.php
 *
 * @package   mod_poasassignment
 * @copyright 2010 Your Name
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

/**
 * xmldb_poasassignment_upgrade
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_poasassignment_upgrade($oldversion=0) {

    global $CFG, $THEME, $db, $DB;
    $dbman = $DB->get_manager();
    $result = true;


    if ($result && $oldversion < 2014010100) {

// Adding tables ...
        $table = new xmldb_table('poasassignment_rating');

        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('value', XMLDB_TYPE_NUMBER, '10, 2', null, null, null, null);
        $table->add_field('attemptid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('fk_attemptid', XMLDB_KEY_FOREIGN, array('attemptid'), 'poasassignment_attempts', array('id'));

        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

// ... Here data trasfer...

// Removing tables ...
// $table = new xmldb_table('poasassignment_rating_values');

//if ($dbman->table_exists($table)) {
// $dbman->drop_table($table);
//}

// $table = new xmldb_table('poasassignment_criterions');

//if ($dbman->table_exists($table)) {
// $dbman->drop_table($table);
//}

// $table = new xmldb_table('poasassignment_graders');

//if ($dbman->table_exists($table)) {
// $dbman->drop_table($table);
//}

// $table = new xmldb_table('poasassignment_used_graders');

//if ($dbman->table_exists($table)) {
// $dbman->drop_table($table);
//}

    }
    upgrade_mod_savepoint(true, 2014010100, 'poasassignment');
    return $result;
}
