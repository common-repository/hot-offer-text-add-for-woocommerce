<?php

/* 
 * Plugin Name:  Show Ads in  woocommerce
 * Plugin URI: http://www.fb.com/mdarifabc
 * Description: By using "Show Ads in  woocommerce", You will be able to add Ads to various positions in Woocommerce single product page. 
 * Version: 1.0.0
 * Author: Arif
 * Author URI: http://fb.com/mdarifabc
 * Requires at least: 4.0
 * Tested up to: 4.7
 * Stable tag: 4.7
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

define('ABAA_WHOTA_PATH', trailingslashit( plugin_dir_path(__FILE__)));
define('ABAA_WHOTA_URL', trailingslashit(plugin_dir_url(__FILE__)));

class woocommerce_hot_offer_text_add {

    
        private $abaa_offer_text_hook_arry=[
            'before_title'=>array('woocommerce_single_product_summary',4),
            'after_title'=>array('woocommerce_single_product_summary',6),

            'after_price'=>array('woocommerce_single_product_summary',11),

            'before_excerpt'=>array('woocommerce_single_product_summary',19),
            'after_excerpt'=>array('woocommerce_single_product_summary',21),

            'before_meta'=>array('woocommerce_single_product_summary',39),
            'after_meta'=>array('woocommerce_single_product_summary',41),

            'before_sharing'=>array('woocommerce_single_product_summary',49),
            'after_sharing'=>array('woocommerce_single_product_summary',51),


        // woocommerce_after_single_product_summary

            'before_tabs'=>array('woocommerce_after_single_product_summary',9),
            'after_tabs'=>array('woocommerce_after_single_product_summary',11),

            'before_upsell_display'=>array('woocommerce_after_single_product_summary',14),
            'after_upsell_display'=>array('woocommerce_after_single_product_summary',16),

            'before_output_related_products'=>array('woocommerce_after_single_product_summary',19),
            'after_output_related_products'=>array('woocommerce_after_single_product_summary',21),

        ];
        
    function __construct() {
        
    }
    
    public function get_call(){
            
        $opt=get_option('offertext_basics');

        if( ! isset($opt['active_offer']) || 'off' == $opt['active_offer']) {
            return;
        }     
        

        $action_name = $this->abaa_offer_text_hook_arry[$opt['position']][0];
        $action_priority = $this->abaa_offer_text_hook_arry[$opt['position']][1];
       
        add_action( $action_name, 
                    function(){
           
                            global $wp_query;
                       
                            if( trim(get_option('offertext_basics')['exclude_id']) ) {
                                $ids=explode(',', get_option('offertext_basics')['exclude_id']);
                             
//                                 if (in_array($wp_query->post->ID, $ids)) {
                                 if (in_array(get_the_ID(), $ids)) {
                                    return;
                                }
                            }

                            $settings=get_option('offertext_basics');

                            //
                            //  Print OUTPUT
                            //
                            echo "<div style='display:block; padding:".$settings['padding']."px;'>";
                            echo "<div class='whot' >". $settings['offer_text']."</div>";
                            echo "</div>";
                            

                    }, 
                    $action_priority 
        );
       
        
    }
    
    public function add_page(){
//        delete_option('offertext_basics');
        
         require_once( ABAA_WHOTA_PATH.'class/class.settings-api.php');
         require_once (ABAA_WHOTA_PATH.'options.php');

        $settings_api= new ABAA_Settings_API_APPLY();
        $settings_api->admin_menu();        
    }
    
    

}


add_action('plugins_loaded', array(new woocommerce_hot_offer_text_add,'get_call'));

add_action( 'admin_menu', array(new woocommerce_hot_offer_text_add,'add_page' ));




function theme_prefix_enqueue_script() {
   if ( ! wp_script_is( 'jquery', 'done' ) ) {
     wp_enqueue_script( 'jquery' );
   }
   wp_enqueue_script("mytinymce","//cdn.tinymce.com/4/tinymce.min.js" );
   wp_add_inline_script( 'jquery-migrate', "jQuery(document).ready(function(){
    tinymce.init({ selector:'[id*=offer_text]' ,

    height: 300,
    width:600,
  menubar: false,
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]



});
   });" );
}
add_action( 'admin_enqueue_scripts', 'theme_prefix_enqueue_script' );


// change this value according to your HTML
              // auto_focus: 'element1'

//offertext_basics[offer_text]