//Code written with help of Morgan 
add_filter( 'badgeos_step_title_display', 'jami_display_activity_description', 10, 3 );
function jami_display_activity_description( $title, $step ) {
	 // wp_die( '<pre>' . print_r( $step, true ) . '</pre>' );
	$activities = badgeos_get_step_requirements($step->ID);
	// echo $activities;
	$activity_id = $activities["achievement_post"];	
	// $activity_title = $title ;
	$activity_points = get_post_meta($activity_id, '_badgeos_points');
	$post = get_post($activity_id);
	$activity_content = $post -> post_content;
	$activity_title = $post -> post_title;
    // wp_die( '<pre>' . var_export( $post, true ) . '</pre>' );
	$activity_earned_by = get_post_meta(  $activity_id, '_badgeos_earned_by', true );
    $activty_submission = "";
	// foreach ($activity_points as $key => $value)
	// {
		// echo "<p>" . $key . " => " . $value . "</p>";
	// }
	// Code to display submissions:
	//echo "<p>" .$activity_earned_by . "</p>";
    if ( $activity_earned_by == 'submission' ||  $activity_earned_by == 'submission_auto') {
        $activty_submission = badgeos_submission_form( array( 'achievement_id' => $activity_id ) );
            if(isset($_POST['badgeos_submission_submit'])){
                $activty_submission = "";
                echo "<script type='text/javascript'>
                        currenturl = window.location.href;
                        window.location.href = currenturl;
                     </script>";
            }
	}
    else if ($activity_earned_by == 'activity_code'){
            $activty_submission = badgeos_activity_render_input_form( array( 'input_text' => __( 'Code Trigger'), 'submit_text' => __( 'Claim it!'  ), 'context' => "activity-input-{$activity_id}" ) );
	}
	else if ($activity_earned_by == 'referring_link') {
            $activty_submission = badgeos_rlt_render_outbound_link( $activity_id );
    }
    
	//echo "<p>" .$activty_submission . "</p>";
	$activity = "<div class='one_activity' width='100%' style='padding:25px 0%;'><h3><span class='activity_title'> " . $activity_title . "</span><span class='activity_points'>" . $activity_points[0] . "</span></h3> <div class='activity_desc'> " . $activity_content . " </div><div class='activity_sub' width='300px'> " . $activty_submission . " </p></div></div>";
    return $activity;
}
