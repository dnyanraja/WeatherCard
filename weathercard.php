<?php 
/**
 * Plugin Name: WhetherCard
 * Plugin URI: http://webandseoguide.tk
 * Description: Get live details about the all the countries Names, Capital and population
 * Version: 1.0.0
 * Author: Ganesh Veer
 * Author URI: 
 * License: GPL2
 **/

function whether_scripts(){
    ?>
        <script src="https://use.fontawesome.com/ed2a93fc56.js"></script>
        <style>
        .weather{max-width:250px;background-color: rgba(0,0,0,.54);padding:10px;color:#fff;}
        .weather .fa-cloud{float:right;}
        .weather h3{margin-bottom:5px;border-bottom:1px solid #fff;font-size:20px;}
        </style>
    <?php
}
add_action('wp_head', 'whether_scripts');

function get_whethercard( $atts ){
         $w = shortcode_atts( array(
            'city' => 'London',   
          ), $atts );

          $jsonurl = 'http://api.openweathermap.org/data/2.5/weather?q='. $w['city'] .'&APPID=d104462c5d786c45def8960ff9c9b5c4';  
          $response = wp_remote_get($jsonurl);
 
          $posts = json_decode(wp_remote_retrieve_body($response));

                if(empty($posts)){
                    echo 'error post empty';
                    return;
                }
              
                if(!empty($posts)){
                    echo "<div class='weather'><h3>Today's Weather <i class='fa fa-cloud' aria-hidden='true'></i></h3>";
                    echo "<span>City: ".$w['city']."</span><br/>";
                    foreach($posts->weather as $weathe )
                    {
                        echo "Report: {$weathe->main},";
                        echo " {$weathe->description}<br/>";
                    }
                    foreach($posts as $post)
                    {   
                        if($post->humidity){
                            echo '<span>Humidity: </span>'.$post->humidity.'%';
                        }
                        if($post->speed){
                            echo '<br/><span>Wind Speed: </span>'.$post->speed;
                        }
                    }
                    echo "</div>";
                }
}
add_shortcode( 'whethercard', 'get_whethercard' );

?>
