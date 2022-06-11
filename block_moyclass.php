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
 * block_moyclass file description here.
 *
 * @package    block_moyclass
 * @copyright  2022 mac <kamenik1@icloud.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use local_moyclass\pages\dashboard;

class block_moyclass extends block_base {
    function init() {
        $this->title = get_string('pluginname', 'block_moyclass');
    }

    function has_config() {
        return true;
    }

    function get_content() {
        global $DB, $USER;
        if ($this->content !== null) {
            return $this->content;
        }

        $content = "";
        $showcourses = get_config("block_moyclass", "showwidget");

        $is_student = $DB->get_record('local_moyclass_students', ['email' => $USER->email]);

        if ($showcourses && $is_student) {
            $dashboard = new dashboard();
            $content = $dashboard->render();
        }

        $this->content = new stdClass;
        $this->content->text = $content;
        $this->page->requires->js_call_amd('local_moyclass/confirm');

        return $this->content;
    }

    public function applicable_formats() {
        return [
            'admin' => false,
            'site-index' => false,
            'course-view' => false,
            'mod' => false,
            'my' => true,
        ];
    }
}
