<?php

/**
 * WordPress settings API  class
 *
 * @author Md. Arif Bin A. Aziz
 */
if ( !class_exists('ABAA_Settings_API_APPLY' ) ):
class ABAA_Settings_API_APPLY {


        private $abaa_offer_text_hook_lable_key=[
            'before_title'=>'Before Title',
            'after_title'=>'After Title',

            'before_excerpt'=>'Before Excerpt',
            'after_excerpt'=>'After Excerpt',

            'before_meta'=>'Before Meta',
            'after_meta'=>'After Meta',

            'before_sharing'=>'Before Sharing',
            'after_sharing'=>'After Sharing',


        // woocommerce_after_single_product_summary

            'before_tabs'=>'Before Product Summery Tab',
            'after_tabs'=>'After Product Summery Tab',

            'before_upsell_display'=>'Before Upsell Display',
            'after_upsell_display'=>'After Upsell Display',

            'before_output_related_products'=>'Before Related Products',
            'after_output_related_products'=>'After Related Products',

        ];


    private $settings_api;

    function __construct() {
        $this->settings_api = new ABAA_Settings_API();

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
       
            add_menu_page( 'Woocommerce Ads', 'Woocommerce Ads', 'administrator', 'offertextsetting', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'offertext_basics',
                'title' => __( 'Woocommerce Ads Settings', 'offertext' )
            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'offertext_basics' => array(
                array(
                    'name'        => 'offer_text',
                    'label'       => __( 'Your Ads', 'offertext' ),
                    'desc'        => __( 'Can be Plain Text or HTML ', 'offertext' ),
                    'placeholder' => __( 'Your Ads Here ', 'offertext' ),
                    'type'        => 'textarea'
                ),

                array(
                    'name'        => 'exclude_id',
                    'label'       => __( 'Exclude Product ID\'s', 'offertext' ),
                    'desc'        => __( 'Product ID that will not show Ads', 'offertext' ),
                    'placeholder' => __( 'ID must be separated with comma(,)', 'offertext' ),
                    'type'        => 'textarea'
                ),

                array(
                    'name'  => 'active_offer',
                    'label' => __( 'Tick for Active Ads', 'offertext' ),
                    'desc'  => __( 'Active/Inactive', 'offertext' ),
                    'type'  => 'checkbox'
                ),
                array(
                    'name'    => 'position',
                    'label'   => __( 'Select Position of Ads', 'offertext' ),
                    'desc'    => __( 'Position where you want to display Ads', 'offertext' ),
                    'type'    => 'select',
                    'options' => $this->abaa_offer_text_hook_lable_key,
                ),
                // array(
                //     'name'    => 'font_style',
                //     'label'   => __( 'Select Text Style', 'offertext' ),
                //     'desc'    => __( 'Style for text', 'offertext' ),
                //     'type'    => 'select',
                //     'options' => array(
                //                         'Bold'      =>  'Bold',
                //                         'Bolder'    =>  'Bolder',
                //                         'Normal'    =>  'Normal'
                //                         )
                // ),
                // array(
                //     'name'    => 'font_alignment',
                //     'label'   => __( 'Select Text Alignment', 'offertext' ),
                //     'desc'    => __( 'Alignment for text', 'offertext' ),
                //     'type'    => 'select',
                //     'options' => array(
                //                 'Center'=>'Center',
                //                 'Justify'=>'Justify',
                //                 'Right'=>'Right',
                //                 'Left'=>'Left'
                //                 )
                // ),
                array(
                    'name'    => 'padding',
                    'label'   => __( 'Select Padding', 'offertext' ),
                    'desc'    => __( 'Padding for Ads', 'offertext' ),
                    'type'    => 'select',
                    'options' => array('0'=>'0','5'=>'5','10'=>'10','15'=>'15','20'=>'20')
                ),

               array(            
                   'name'        => 'extra_class',
                   'label'       => 'Extra Class',
                   'desc'        => __( 'We are Offering a extra class <b> whot </b>', 'offertext' ),
                   'type'        => 'html'
               ),

            ),
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        

        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;
