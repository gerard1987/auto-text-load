<?php
class location_number
{
    /**
     * Get page name, set variables and perform regex
     * to get the formatted location number out of the page url
     */    
    public function dynamic_number( $atts ){
        
        //Instances
        $location_number = new location_number();

        // Set Variables
        $preg_result = [];
        $loc_name;
        $loc_var;
        $fallback_number;
        $tel_number;
        $current_page_name = $_SERVER['REQUEST_URI'];
        
        // Get location name out of url
        $current_page = preg_replace("/\//", "", $current_page_name); 
        $temp = preg_match('/-(.*)/', $current_page_name, $preg_result);
        if ($preg_result) {
            $loc_name = (string)$preg_result[0];
        }
        $current_page_name = preg_replace("/[\W\-]/", ' ', $loc_name);

        // Set formatted page name
        $page_name = strval(ucwords($current_page_name));
        
        // Get the Csv file and turn it into a array
        $currentDirectory = getcwd();
        $file = $currentDirectory . '/teksten/nummers.csv';
        $csv = array_map('str_getcsv', file($file));

        $loc_var = trim($page_name);
        $fallback_number = $csv[0][1];
        $fallback_number = preg_replace('/[;]/', '', $fallback_number);

        /**
         *  Loop through the csv, if it matches get the second array item and return it to the shortcode
         *  In the case the array item doesnt have a number, it returns a fallback number.
         */    

        if (!empty($loc_var)) {
            foreach ($csv as $item){
                $newitem = trim(strval($item[0]));
                $newNumb = trim(strval($item[1]));
                    // replace clutter
                    $newNumb = preg_replace('/[;]/', '', $newNumb);
                    $newitem = preg_replace('/[,]/', '', $newitem);

                    $newitem = strtolower($newitem);
                    $newitem = preg_replace("/[\W\-]/", ' ', $newitem);
                    $loc_var = strtolower($loc_var);

                    if (strpos($newitem, $loc_var) !== FALSE && !empty($loc_var)) {
                        if ($newNumb && $newitem === $loc_var){
                            $tel_number = $newNumb;
                            $newNumb = preg_replace("/[\W\-]/", '', $newNumb);
                            $link_tel_number = 'tel:' . str_replace(" ", "", $newNumb);
                        }
                    } else if (strpos($newitem, $loc_var) !== TRUE || empty($loc_var)) {
                        if (empty($tel_number) && empty($newNumb) ){
                            $tel_number = $fallback_number;
                            $link_tel_number = preg_replace("/[\W\-]/", '', $tel_number);
                            $link_tel_number = 'tel:' . str_replace(" ", "", $link_tel_number);
                        }
                    }
            }
        }
        elseif (empty($loc_var)) {
            $tel_number = $fallback_number;
            $link_tel_number = preg_replace("/[\W\-]/", '', $tel_number);
            $link_tel_number = 'tel:' . str_replace(" ", "", $link_tel_number);
        }

          // Check for shortcode attribute used, retrieve according number format
          extract( shortcode_atts( array(
            'type' => 'myvalue'

        ), $atts ) );

        switch ($type){
            case 'telnr': 
                $output = $tel_number;
                break;
            case 'link_tel_number':
                $output = $link_tel_number;
                break;
            default :
                $output = $tel_number;
        }
        return $output;
    }
} // end of class