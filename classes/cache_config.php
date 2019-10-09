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
 * Cache factory extension class
 *
 * @package   tool_cacheconfig
 * @author    Peter Burnett <peterburnett@catalyst-au.net>
 * @copyright Catalyst IT
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_cacheconfig;

defined('MOODLE_INTERNAL') || die();

class cache_config extends \cache_factory {

    public function create_cache(\cache_definition $definition) {
        global $CFG;
        // 1. Get list of stores from CFG
        // 2. Filter list of stores through rules until 1 is selected
        $class = $definition->get_cache_class();

        //create new File cache store
        $configuration = array(
            'path' => '',
            'autocreate' => false,
            'singledirectory' => false,
            'prescan' => false
        );
        $details = array(
            'name' => $definition->get_id(),
            'plugin' => 'file',
            'configuration' => $configuration,
            'class' => 'cachestore_file'
        );
        $store = $this::create_store_from_config($definition->get_id(), $details, $definition);

        $loader = new $class($definition, $store, null);
        $i=1;
        return $loader;
    }
}