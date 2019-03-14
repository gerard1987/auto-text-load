<?php
/*
Plugin Name:  Auto text load
Plugin URI:   https://github.com/gerard1987/auto-text-load
Description:  Retrieves file with same page slug as the url, gets the content from within a .docx file.
Version:      1.3
Author:       Gerard de Way
Author URI:   https://github.com/gerard1987
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wporg
Domain Path:  /languages
Shortcode Syntax: Default:[textload] || [textload type="textone"] || [textload type="texttwo"] || [telnr] || [telnr type='link_tel_number'] || [pagename] [pagename type="location"]
*/

// Plugin updater

require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/gerard1987/auto-text-load.json',
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
 * Retrieve the matched file and convert it in the readDocx function
 * Explode the file, and return in a array, define wich textarea should be retrieved.
 * based on what shortcode attribute has been used
 * Shortcode Syntax: Default:[textload] || [textload type="textone"] || [textload type="texttwo"] || [textload type="textthree..."]
 */
class dynamic_input
{
    // Plugin install
    static function install() {
        // do not generate any output here
    }
    /**
     * Retrieve a .docx file from the server, with the same name as the page name.
     * explode thrue the .docx file, with placholders and write the area's to the page with shortcode
     */    
    public function auto_text_load( $atts ){

        // Global variables
        $currentExtension = ".docx";
        $currentFolder = "/teksten";

        // File location
        $currentDirectory = getcwd();
        $currentPage = $_SERVER['REQUEST_URI'];
        // Replace slashes for permalink compatibility
        $currentPage = '/' . preg_replace("/\//", "", $currentPage); 
        $file = $currentDirectory . $currentFolder . $currentPage . $currentExtension;
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

        // Convert the document to text, and to html after that. 
        $class_ref = new document_extension;
        $converted_document = &$class_ref->readDocx($file);
        $html_document = html_entity_decode ($converted_document);
        // Add delimeters for preg_match
        $dirString = strval($currentPage) . '/';

        // Check if the current pagename slug exists in the url
        if (preg_match($dirString, $url)) {
            // Retrieve the content and explode the array
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
            case 'textone': 
                $output = $text[1];
                break;
            case 'texttwo': 
                $output = $text[2];
                break;
            case 'textthree': 
                $output = $text[3];
                break;
            case 'textfour': 
                $output = $text[4];
                break;
            case 'textfive': 
                $output = $text[5];
                break;
            case 'textsix': 
                $output = $text[6];
                break;
            case 'textseven': 
                $output = $text[7];
                break;
            case 'texteight': 
                $output = $text[8];
                break;
            case 'textnine': 
                $output = $text[9];
                break;
            case 'textten': 
                $output = $text[10];
                break;
            case 'texteleven': 
                $output = $text[11];
                break;  
            case 'texttwelve': 
                $output = $text[12];
                break;   
            case 'textthirteen': 
                $output = $text[13];
                break;          
            case 'textfourteen': 
                $output = $text[14];
                break;   
            case 'textfifteen': 
                $output = $text[15];
                break;   
            case 'textsixteen': 
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