<?php
/*
Plugin Name:  Auto text load
Plugin URI:   https://github.com/gerard1987/auto-text-load
Description:  Retrieves file with same page slug as the url, gets the content from within a .docx file.
Version:      0.1
Author:       Gerard de Way
Author URI:   https://github.com/gerard1987
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wporg
Domain Path:  /languages
Shortcode Syntax: Default:[textload] || [textload type="text-one"] || [textload type="text-two"]... || [telnr] || [telnr type='link_tel_number'] || [pagename] [pagename type="location"]
*/

// Plugin updater
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/gerard1987/auto-text-load/blob/master/auto-text-load/auto-text-load.json',
	__FILE__,
	'auto-text-load_updater'
);

// Plugin registration
register_activation_hook( __FILE__, array( 'dynamic_input', 'install' ) );

// Define global constants
$plugin_dir = plugin_dir_path( __FILE__ );

// Includes
include_once $plugin_dir . 'includes/document_extension.php';
include_once $plugin_dir . 'includes/formatted_pagename.php';
include_once $plugin_dir . 'includes/location_number.php';

/**
 * Retrieve a .docx file from the server, with the same name as the page name.
 * Splits up the .docx file with placeholder, and writes to the area's with the shortcode.
 */
class dynamic_input
{
    // Plugin install
    static function install() {
        // do not generate any output here
    }
    
    /**
     * Get current page, convert the .docx file and explode the content, return the text section to the shortcode.
     */
    public function auto_text_load( $atts ){

        // Global variables
        $currentExtension = ".docx";
        $currentFolder = "/teksten";

        // Set page and replace slashes for permalink compatibility
        $currentDirectory = getcwd();
        $currentPage = $_SERVER['REQUEST_URI'];
        $currentPage = '/' . preg_replace("/\//", "", $currentPage);

        // Set file and url
        $file = $currentDirectory . $currentFolder . $currentPage . $currentExtension;
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

        // Convert the document to useable html text. 
        $class_ref = new document_extension;
        $converted_document = &$class_ref->readDocx($file);
        $html_document = html_entity_decode ($converted_document);
        // Add delimeters for preg_match
        $dirString = strval($currentPage) . '/';

        // Check if the current pagename slug exists in the url
        if (preg_match($dirString, $url)) {
            // Split up the content on the shortcode
            $text = explode('[auto_text_load]', $html_document);
        } else {
            echo "Pagename and url dont match". "<br>";
            $text = the_post();
        }
        // Check for shortcode attribute used, retrieve according text
        extract( shortcode_atts( array(
            'type' => 'myvalue'

        ), $atts ) );

        switch( $type ){
            case 'text-one': 
                $output = $text[1];
                break;
            case 'text-two': 
                $output = $text[2];
                break;
            case 'text-three': 
                $output = $text[3];
                break;
            case 'text-four': 
                $output = $text[4];
                break;
            case 'text-five': 
                $output = $text[5];
                break;
            case 'text-six': 
                $output = $text[6];
                break;
            case 'text-seven': 
                $output = $text[7];
                break;
            case 'text-eight': 
                $output = $text[8];
                break;
            case 'text-nine': 
                $output = $text[9];
                break;
            case 'text-ten': 
                $output = $text[10];
                break;
            case 'text-eleven': 
                $output = $text[11];
                break;  
            case 'text-twelve': 
                $output = $text[12];
                break;   
            case 'text-thirteen': 
                $output = $text[13];
                break;          
            case 'text-fourteen': 
                $output = $text[14];
                break;   
            case 'text-fifteen': 
                $output = $text[15];
                break;   
            case 'text-sixteen': 
                $output = $text[16];
                break;                                         
            default:
                $output = $text[0];
                break;
        }
        return $output;
    }
} // end of class

// create Instance's for static shortcode
$dynamic_input = new dynamic_input();
$formatted_pagename = new formatted_pagename();
$location_number = new location_number();

// Add Shortcode's
add_shortcode( 'textload', array( $dynamic_input, 'auto_text_load' ));
add_shortcode( 'pagename', array( $formatted_pagename, 'dynamic_pagename' ));
add_shortcode('telnr', array( $location_number, 'dynamic_number' ));

// Widget enable shortcode
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter( 'widget_text', 'do_shortcode' );

?>