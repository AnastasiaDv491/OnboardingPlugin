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
    );
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) {
        echo "<ul class='onboarding_list' id='onboarding_list_{$atts['name']}'>";
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            echo '<li>' . get_the_title() . '</li>';
        }
        echo '</ul>';
    } else {
        // no posts found
        echo "<h1>No Flows</h1>";
    }
    /* Restore original Post Data */
    wp_reset_postdata();
}


?>


