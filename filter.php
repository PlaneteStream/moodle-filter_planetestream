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
 * Planet eStream Filter Plugin
 *
 * @package    filter_planetestream
 * @copyright  Planet eStream
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */
global $CFG;
require_once($CFG->libdir . '/filelib.php');
defined('MOODLE_INTERNAL') || die();
class filter_planetestream extends moodle_text_filter
{
    /**
     * Get attribute from tag
     *
     * @param string $tag to search
     * @param string $attr to return
     * @return boolean
     */
    private function get_attr($tag, $attr) {
        $varregex = '/' . preg_quote($attr) . '=([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/is';
        if (preg_match($varregex, $tag, $match)) {
            return $match[2];
        }
        return false;
    }
    /**
     * Moodle text filter
     *
     * @param string $html 
     * @param array() options
     * @return string
     */
    public function filter($html, array $options = array()) {
        $url = "";
        if (stripos($html, "_planetestreamiframe_") !== false) {
            $url = rtrim(get_config('assignsubmission_estream', 'url') , '/');
            if (empty($url)) {
                $url = rtrim(get_config('planetestream', 'url') , '/');
            }
        }
        $i = 0;
        if (!empty($url)) {
            do {
                $i = stripos($html, "_planetestreamiframe_", $i);
                if ($i === false) {
                    break;
                }
                $j = strrpos($html, "<a ", ($i - strlen($html)));
                if ($j === false) {
                    break;
                }
                $l = strrpos($html, "</iframe>", ($j - strlen($html)));
                if ($l == ($j - 9)) {
                    break;
                }
                $k = stripos($html, "</a>", $j);
                if (($k === false) | ($k - $j > 300)) {
                    break;
                }
                $k += 4;
                $strhref = substr($html, $j, $k - $j);
                $hrefurl = $this->get_attr($strhref, "href");
                if (!$hrefurl) {
                    break;
                }
                $m = strpos($hrefurl, "_planetestreamiframe_");
                if ($m > 0) {
                    $hrefurl = substr($hrefurl, $m, strlen($hrefurl) - $m);
                }
                $hrefurl = str_replace("_planetestreamiframe_", $url, $hrefurl);
                $width  = 640;
                $height = 480;
                $hrefwidth = $this->get_attr(str_replace("&amp;", " \"", $hrefurl), "w");
                $hrefheight = $this->get_attr(str_replace("&amp;", " \"", $hrefurl), "h");
                if ((is_numeric($hrefwidth)) && (is_numeric($hrefheight))) {
                    $width = $hrefwidth;
                    $height = $hrefheight;
                }
                $strnew = "<iframe title=\"Planet eStream\" width=\"{$width}\" height=\"{$height}\" ";
                $strnew .= "src=\"{$hrefurl}\" frameborder=\"0\" allowfullscreen=\"1\"></iframe>";
                $html = str_replace($strhref, $strnew, $html);
                $i = stripos($html, $strnew);
                if ($i === false) {
                    break;
                }
            } while (1);
        }
        $i = 0;
        do {
            $i = stripos($html, "/VLE/Moodle/Video", $i);
            if ($i === false) {
                break;
            }
            $j = strrpos($html, "<span class=\"mediaplugin mediaplugin_swf", ($i - strlen($html)));
            if ($j === false) {
                break;
            }
            $k = stripos($html, "</span>", $j);
            if (($k === false) | ($k - $j > 1600)) {
                break;
            }
            $k += 7;
            $strswf = substr($html, $j, $k - $j);
            $swfurl = $this->get_attr($strswf, "data");
            if (!$swfurl) {
                break;
            }
            $width  = 640;
            $height = 480;
            $swfwidth = $this->get_attr($strswf, "width");
            $swfheight = $this->get_attr($strswf, "height");
            if ((is_numeric($swfwidth)) && (is_numeric($swfheight))) {
                $width = $swfwidth;
                $height = $swfheight;
            }
            $ps = "?";
            if (stripos($swfurl, "?") !== false) {
                $ps = "&";
            }
            $strnew = "<iframe title=\"Planet eStream\" width=\"{$width}\" height=\"{$height}\" ";
            $strnew .= "src=\"{$swfurl}{$ps}iframe=true\" frameborder=\"0\" allowfullscreen=\"1\"></iframe>";
            $html = str_replace($strswf, $strnew, $html);
            $i = stripos($html, $strnew);
            if ($i === false) {
                break;
            }
            $i += strlen($strnew);
        } while (1);
        return $html;
    }
    /**
     * Moodle get_rank
     *
     * @return int
     */
    public function get_rank() {
        return 1020;
    }
}
