<?php

/**
 * Planet eStream Filter Plugin
 *
 * @package    filter_planetestream
 * @copyright  Planet eStream
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

global $CFG;
require_once $CFG->libdir . '/filelib.php';
defined('MOODLE_INTERNAL') || die();

class filter_planetestream extends moodle_text_filter
{
    
    private function getAttr($tag, $attr)
    {
        $regEx = '/' . preg_quote($attr) . '=([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/is';
        if (preg_match($regEx, $tag, $match)) {
            return $match[2];
        }
        return false;
    }
    
    public function filter($html, array $options = array())
    {
        
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
            
            $strSWF = substr($html, $j, $k - $j);
            
            $SWFurl = $this->getAttr($strSWF, "data");
            
            if (!$SWFurl) {
                
                break;
                
            }
            
            $width  = 640;
            $height = 480;
            
            $SWFwidth = $this->getAttr($strSWF, "width");
            
            if ($SWFwidth) {
                $width = $SWFwidth;
            }
            
            $SWFheight = $this->getAttr($strSWF, "height");
            
            if ($SWFheight) {
                $height = $SWFheight;
            }
            
            $ps = "?";
            
            if (stripos($SWFurl, "?") === true) {
                $ps = "&";
            }
            
            $strNew = "<iframe title=\"Planet eStream\" width=\"{$width}\" height=\"{$height}\" src=\"{$SWFurl}{$ps}iframe=true\" frameborder=\"0\" allowfullscreen=\"1\"></iframe>";
            
            $html = str_replace($strSWF, $strNew, $html);
            
            $i = stripos($html, $strNew);
            
            if ($i === false) {
                break;
            }
            
            $i += strlen($strNew);
            
        } while (1);
        
        return $html;
        
    }
    
    public function get_rank()
    {
        return 1020;
    }
    
}