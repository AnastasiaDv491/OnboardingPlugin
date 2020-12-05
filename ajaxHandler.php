<?php
function my_ajax_handler() {
    // wp_send_json_success( 'It works' );

    $statusUpdate = update_user_meta(get_current_user_id(), 'stage 1', $_POST['status']);
    if($statusUpdate == true){
        // wp_send_json_success($_POST);
        wp_send_json_success("true".$statusUpdate.$_POST['status']);

    }
    else{
        wp_send_json_error( "false".$statusUpdate.$_POST['status']);
    }
    

}

function ajaxStageStorage(){
    $stages = 
}

