// This file is part of Moodle - http://moodle.org/
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
 * Planet eStream Filter Plugin
 *
 * @package    filter_planetestream
 * @copyright  Planet eStream
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @requires   Planet eStream v5.61 or later
 */

Planet eStream iFrame Filter 

The Planet eStream iFrame Filter converts Planet eStream content added with the Planet eStream 
Moodle Repository Plugin from a flash player format to an iFrame format.  

The conversion takes place for any new Planet eStream items added using the Repository Plugin and 
also for all the existing Planet eStream items already added to your Moodle system using the Repository Plugin.

Using iFrames, Planet eStream system can detect the best video delivery method and use either a 
flash player or a HTML5 player, as appropriate.  This enables the content to be viewed on a wider 
range of platforms including Android and IOS devices.

The iFrame filter is compatible with Moodle v2.3 and later and requires Planet eStream v5.61 or later.

Installation Instructions
-------------------------

Within the Site administration section in Moodle, select "Plugins" and then "Install add-ons".

From the Plugin type drop down list, select Text filter (filter).

Drag and drop the MoodleFilter.zip file into the Zip package area (or click "Choose a file..")

Tick the Acknowledgement tick-box, if you agree to the statement.

Click the "Install add-on from the ZIP file" button, a page will be displayed showing a "Validation passed" message.

Click the "Install add-on!" button at the bottom of the page.

The plugins page will be displayed showing the Planet eStream iFrame Filter as "To be installed".

Click the "Upgrade Moodle database now" button.

Click "Continue" on the next screen to proceed to the Manage Filters page.

Within the drop down list adjacent to the Planet eStream iFrame Filter, select "On".

The page will automatically refresh and the filter will be activated - no additional configuration of the filter is required 

Ensure that the filter is listed below "Multimedia plugins" in the list.
