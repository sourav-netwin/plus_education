<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Export{

    function to_excel($array, $filename ) {

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$filename.'.xls');
        header("Pragma: no-cache");
        header("Expires: 0");
         //Filter all keys, they'll be table headers
        $h = array();
        foreach($array as $row){
            foreach($row as $key=>$val){
                if(!in_array($key, $h)){
                 $h[] = $key;
                }
                }
                }
                //echo the entire table headers
                echo '<table><tr>';
                foreach($h as $key) {
                    $key = ucwords($key);
                    echo '<th width="250">'.$key.'</th>';
                }
                echo '</tr>';

                foreach($array as $row){
                  echo '<tr>';
                  foreach($row as $key => $val)
                  {
                    $green_color = ( $key == 'Balance' && $val <= 2 ) ? 1 : 0;
                    $this->writeRow($val, $green_color);
                  }
                }
                echo '</tr>';
                echo '</table>';

        }
    function writeRow($val, $green_color) {
      if( $green_color == 1 )
        echo "<td width='350' style='background-color: #9c9;'>".utf8_decode($val).'</td>';
      else
        echo "<td width='350'>".utf8_decode($val).'</td>';
    }
}


