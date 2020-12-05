<?php
/**
 * Plugin Name: Onboarding ISCEB
 */

include 'ajaxHandler.php';

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
    
    // wp_register_style( 'namespace1', '/wp-content/plugins/plugin-onboarding/onboarding.css' );
    // wp_enqueue_style( 'namespace1' );

    wp_register_style( 'namespace2', '/wp-content/plugins/plugin-onboarding/interactive_timeline.css' );
    wp_enqueue_style( 'namespace2' );

    wp_register_style( 'namespace', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' );
    wp_enqueue_style( 'namespace' );

    wp_register_script( 'my_script', '/wp-content/plugins/plugin-onboarding/interactive_timeline.js',array ('jquery'), time());

    wp_enqueue_script(
        'my_script',
        plugins_url( 'interactive_timeline.js', __FILE__ ),
        array( 'jquery' ),
        time()
    );


    wp_localize_script( 'my_script', 'my_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )) ;

    
}


add_action('wp_enqueue_scripts', 'add_my_plugin_stylesheet');

add_action( 'wp_ajax_stagetest', 'my_ajax_handler' );

// MBA_STAGE1_METADTA = true
// MBA_STAGE2_METADTA = false
// ....

// MBA_STAGES = [stage1:true,...]


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
    if (is_user_logged_in ()) {
        $stageStatus = get_user_meta(get_current_user_id(), 'stage 1', true);
        if ($stageStatus == "true"){
            echo '<input type="checkbox" id="chkbx" checked/> <textarea id="textbox1"></textarea>';
        }
        else{
            echo '<input type="checkbox" id="chkbx"/> <textarea id="textbox1"></textarea>';
        }
       
        echo '<p>'. get_user_meta(get_current_user_id(), 'stage 1', true). '</p>';
        add_user_meta (get_current_user_id(), 'stage 1', true, true);
        

        // update_user_meta(get_current_user_id(), 'stage 1', 'stage 1');
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
            switch ($atts['name']) {
                /* BBA!!!!!*/
                case 'BBA':
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
                break;
                case 'MBA':
                default:
                add_user_meta (get_current_user_id(), 'stages_MBA', true, true);
                echo
                '<section class="timeline">
                <div class="container">' ;
                while ($the_query->have_posts() ) {
                    $the_query->the_post();
    
                    echo '<div class="timeline-item">
                        <div class="timeline-img"></div>
              
                    <div class="timeline-content js--fadeInLeft">
                      <h2>'. get_the_title() .'</h2>
                      <div class="date">'. get_the_date() .
                    '<input type="checkbox" id="chkbx_'.get_the_ID().'" '
                    .($stageStatus == "true" ? 'checked': '').
                    '/></div>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime ipsa ratione omnis alias cupiditate saepe atque totam aperiam sed nulla voluptatem recusandae dolor, nostrum excepturi amet in dolores. Alias, ullam.</p>
                      <a class="bnt-more" href="javascript:void(0)">More</a>
                    </div>
                  </div>
                  ';
                }
                echo '    </div>
                </section>';
    
                    break;
            }
        } else {
            // no posts found
            echo "<h1>No Flows</h1>";
        }
        /* Restore original Post Data */
        wp_reset_postdata();
    } else { 
        echo '<a href="/wp-login.php"> Login </a>';
    }

}


function wporg_usermeta_form_field_birthday( $user )
{
    ?>
    <h3>It's Your Birthday</h3>
    <table class="form-table">
        <tr>
            <th>
                <label for="birthday">Birthday</label>
            </th>
            <td>
                <input type="text"
                       class="regular-text ltr"
                       id="birthday"
                       name="birthday"
                       value="<?= esc_attr( get_user_meta( $user->ID, 'stage 1', true ) ) ?>"
                       title="Some data"
                       
                       required>
                <p class="description">
                    Please enter your birthday date.
                </p>
            </td>
        </tr>
    </table>
    <?php
}

// /**
//  * The save action.
//  *
//  * @param $user_id int the ID of the current user.
//  *
//  * @return bool Meta ID if the key didn't exist, true on successful update, false on failure.
//  */
// function wporg_usermeta_form_field_birthday_update( $user_id )
// {
//     // check that the current user have the capability to edit the $user_id
//     if ( ! current_user_can( 'edit_user', $user_id ) ) {
//         return false;
//     }
  
//     // create/update user meta for the $user_id
//     return update_user_meta(
//         $user_id,
//         'status',
//         $_POST['status']
//     );
// }
  
// // Add the field to user's own profile editing screen.
// add_action(
//     'show_user_profile',
//     'wporg_usermeta_form_field_birthday'
// );
// /* Leave open*/
