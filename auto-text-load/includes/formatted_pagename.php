<?php
class formatted_pagename
{
   /**
     * Add second shortcode for placing the location name
     * [pagename] for basename
     * [pagename type="location"] for stripped location name
     */
    public function dynamic_pagename( $atts ){
        // Retrieve the file location from site directory with same name as the page slug.
        $current_page_name = $_SERVER['REQUEST_URI'];
        $page_no_slash = str_replace('/', '', $current_page_name);
        $current_page_name = preg_replace("/[\W\-]/", ' ', $current_page_name);
        $page_name = strval(ucwords($current_page_name));
        
        $page_name_only = strval(ucwords(explode('-', $page_no_slash, 2)[1]));
        
        
        // Check for shortcode attribute used, retrieve according text
        extract( shortcode_atts( array(
            'type' => 'myvalue'

        ), $atts ) );

        switch( $type ){
            case 'location': 
                $output =  $page_name_only;
                break;                                       
            default:
                $output = $page_name;
                break;
        }
        return $output;
    }
} // end of class