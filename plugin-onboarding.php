<?php
/**
 * Plugin Name: Onboarding ISCEB
 */

function afunction(){
    add_menu_page( 
        __( 'Custom Menu Title', 'textdomain' ),
     "Onboarding", 
     "manage_options",
    "plugin-onboarding/dashboard.php",
    
    );
}

add_action( 'admin_menu', 'afunction' );

// add_action('admin_init', 'myplugin_admin_init');

function add_my_plugin_stylesheet() {
    // wp_register_style('mypluginstylesheet', '/wp-content/plugins/plugin-onboarding/onboarding.css');
    // wp_enqueue_style('mypluginstylesheet');
    wp_register_style( 'namespace', '/wp-content/plugins/plugin-onboarding/onboarding.css' );
    wp_enqueue_style( 'namespace' );
    wp_register_style( 'namespace', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' );
    wp_enqueue_style( 'namespace' );
}

add_action('wp_enqueue_scripts', 'add_my_plugin_stylesheet' );




function wporg_custom_post_type() {
    register_post_type('wp_stages',
        array(
            'labels'      => array(
                'name'          => __('Stages', 'textdomain'),
                'singular_name' => __('Stage', 'textdomain'),
            ),
                'public'      => true,
                'has_archive' => true,
                'show_ui' => true
        )
    );

    
}
add_action('init', 'wporg_custom_post_type');

function wpdocs_create_new_taxonomy() {
    $labels = array(
        'name'          => _x('Onboarding flows','taxonomy general name' ,'textdomain'),
        'singular_name' => _x('Onboarding flow','taxonomy singular name', 'textdomain'),
        'add_new_item'               => __( 'Add New Flow', 'textdomain' ),
    );
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
    );
    register_taxonomy('flow_taxonomy', array('wp_stages'), $args);
}
add_action('init','wpdocs_create_new_taxonomy', 0);


add_shortcode('flow', 'flow_function');
function flow_function($atts) {
    $args = array(
        'post_type' => 'wp_stages',
        'tax_query' => array(
            array(
                'taxonomy' => 'flow_taxonomy',
                'field'    => 'name',
                'terms'    => $atts['name'],
            ),
        ),
        'orderby' => 'CAST(title as CHAR)',
        'order' => 'ASC',
        // array('title' => 'DSC'),
    );
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) {
        echo "<div class='onboarding_list' id='onboarding_list_{$atts['name']}'>";
            echo'<div class="row">
                    <div class="col_md_12">
                        <div class="main_timeline">';
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            echo '
                            <div class="timeline" id="stage1">
                                <div class="timeline_content">
                                    <span class="timeline_stage">'. get_post_meta( get_the_ID() , 'subtitle', true ) .' </span>
                                        <div class="timeline_icon">
                                            <i class="fa fa-rocket"></i>
                                        </div>
                                    <div class="content">
                                        <a href=" "> <h3 class="title">' . get_the_title() . '</h3> </a>
                                        <p class="description">
                                            
                                in this website design tutorial i will guide you that how to create the amazing timeline design using the modern technologies cush as html 5 css 3 and no JavaScript. After
                                Completing this website design tutorial you will be having all the great skills for website design in no time. Hope this website design and web development tutorial will
                                
                                        
                                        </p>
                                    </div>
                                </div>
                            </div>
                              
                      
        ';
        }
        echo '          </div>       
                    </div>    
                </div>  ';
        echo '</div>';
    } else {
        // no posts found
        echo "<h1>No Flows</h1>";
    }
    /* Restore original Post Data */
    wp_reset_postdata();
}

/* Leave open*/
