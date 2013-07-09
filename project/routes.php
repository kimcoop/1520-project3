<?php
  
  require_once('functions.php'); // includes session_start()

  define( "COURSE_TMPL", 'course_tmpl' ); // the ID of the script
  define( "STUDENT_TMPL", 'student_tmpl' );
  define( "CURRENT_USER_TMPL", 'student_tmpl' );
  define( "NOTICE_TMPL", 'notice_tmpl' );


  if ( isset($_POST['signin_form_submit']) ) {

    $user = User::signin( $_POST['user_id'], $_POST['password'] );
        
    if ( is_logged_in() ) {
      $data = array();
      $data[ 'template' ] = get_root_view();
      echo current_user()->to_json( $data );
    } else {
      // display_notice( 'Error logging in.', 'error' );
      // header( 'Location: index.php' );
    }
    exit();
  }


  if ( was_posted('forgot_password_step_1_submit') ) {
    if ( isset( $_POST['user_id'] ))
      $user_id = addslashes( $_POST['user_id'] );
    if ( $user_id ) {
      $user = User::find_by_user_id( $user_id );
      if ( $user ) {
        $secret_question = $user->get_secret_question();
        $location = "forgot_password.php?user_id=$user_id&step=secret_question";

        if ( !$secret_question ) { // if no secret question was provided, send user through
          User::reset_and_send_password( $user_id );
          $location = "forgot_password.php?step=emailed";
          exit();
        }

      } else {
        display_notice( "User ID not recognized.", 'error' );
      }
    
    } else {
      display_notice( "Please provide your user ID.", 'error' );
    }

    if ( !$location )
      $location = "forgot_password.php?step=user_id";
    header( "Location: $location" );
    exit();
  }

  if ( was_posted( 'forgot_password_step_2_submit' ) ) {
    $answer = $_POST[ 'secret_answer' ];
    if ( $answer ) {
      $user_id = $_POST['user_id'];
      $user = User::find_by_user_id( $user_id );
      if ( $user ) {
        if ( $user->get_secret_answer() == hash( 'sha256', $answer ) ) {
          User::reset_and_send_password( $user_id );
          $location = "forgot_password.php?step=emailed";
        } else {
          display_notice( "Incorrect secret answer. Please try again.", 'error' );
          $user_id = $_POST['user_id'];
          $location = "forgot_password.php?user_id=$user_id&step=secret_question";
        }
      } else {
        display_notice( "User ID not recognized.", 'error' );
      }
    }

    if ( !$location ) {
      $user_id = $_POST['user_id'];
      $location = "forgot_password.php?user_id=$user_id&step=secret_question";
    }
    header( "Location: $location" );
    exit();

  }

  if ( was_posted('add_user_form_submit')) {
    $full_name = $_POST['first_name'] . " " . $_POST['last_name'];
    if ( User::create( $_POST['access_level'], $_POST['email'], $_POST['first_name'], $_POST['last_name'], $_POST['password'], $_POST['psid'], $_POST['user_id'] ))
      display_notice( "User <strong>$full_name</strong> created.", 'success' );
    else
      display_notice( "Error creating user <strong>$full_name.</strong>", 'error' );
  }
  
  if ( was_posted('delete_user_form_submit') ) {
    if ( User::delete_by_psid( $_POST['psid']))
      display_notice( 'User deleted.', 'success' );
    else
      display_notice( 'Error deleting user.', 'error' );
  }

  if ( was_posted('add_course_form_submit')) {
    $file = $_POST['filename'];
    if ( !$file ) {
      display_notice( "Filename must not be empty.", 'error' );
    }
    if ( !file_exists( $file )) {
      display_notice( "File <strong>$file</strong> not found.", 'error' );
    }
    $objects = file( $file );
    $additions = 0;
    foreach( $objects as $line ) {
      $object = Course::load_from_file( $line );
      if ( DB::insert( 'courses', $object ))
        $additions += 1;
    }
    $pluralizer = $additions == 1 ? "course" : "courses";
    display_notice( "$additions new $pluralizer added from file <strong>$file.</strong>", 'success' );
  }


  if ( was_posted('change_password_form_submit') ) {
    if ( current_user()->change_password( $_POST['old_password'], $_POST['new_password'], $_POST['new_password_confirm'] ))
      display_notice( 'Password changed.', 'success' );
    else
      display_notice( '<strong>Error changing password.</strong> Please ensure you\'ve properly entered your current password and that your new password and confirmation match.', 'error' );
  }

  if ( was_posted('secret_question_form_submit') ) {
    if ( current_user()->set_secret_question( $_POST['secret_question'], $_POST['secret_answer'] ))
      display_notice( 'Secret question saved.', 'success' );
    else
      display_notice( 'Error saving secret question.', 'error' );
  }

  if ( was_posted('log_advising_session_form_submit') ) {
    if ( $session_id = Session::log_advising_session( $_SESSION['viewing_psid'] )) {
      current_user()->set_is_logging_session( TRUE );
      current_user()->set_logging_session_id( $session_id );
      display_notice( 'Logging current advising session.', 'success' );
    } else {
      display_notice( 'Error logging advising session.', 'error' );
    }
  }

  if ( was_posted('advising_notes_form_submit') ) {
    if ( Note::add_note( $_SESSION['viewing_psid'], $_POST['note_content'], $_POST['session_id'] )) 
      display_notice( 'Note saved.', 'success' );
    else
      display_notice( 'Error saving note.', 'error' );
  }

  if ( $_GET['action'] == 'logout' ) {
    session_destroy();
    header('Location: index.php') ;
    exit();

  } elseif ( $_GET['action'] == 'get_current_student' ) {

    $data = array();
    $student = User::find_by_psid( $_SESSION['viewing_psid'] );
    $data[ 'current_user' ] = current_user();
    $data[ 'template' ] = STUDENT_TMPL;
    echo $student->to_json( $data );
    exit();

  } elseif ( isset($_GET['student_search_term']) ) {
    $search_term = $_GET['student_search_term'];
    if ( $user = User::find_by_psid_or_name( $search_term )) {
      $data = array();
      $data[ 'current_user' ] = current_user();
      $data[ 'template' ] = STUDENT_TMPL;
      echo $user->to_json( $data ); // be sure to pass down current_user details
      set_viewing_student( $user ); // store to session
    } else {
      display_notice( "User <strong> ". $_GET['student_search_term'] . "</strong> not found.", 'error' );
    }
    exit();

  } elseif ( $_GET['action'] == 'get_current_user' ) {
    echo current_user()->to_json( NULL );

  } elseif ( $_GET['action'] == 'end_session_log' ) {
    current_user()->set_is_logging_session( FALSE ); // hacky, but works for our purposes
    display_notice( 'Advising session ended.', 'success' );
    $user_id = $_SESSION['viewing_user_id'];
    header( "Location: student.php?user_id=$user_id" );
    exit();

  } elseif ( isset($_GET['search_course_form_submit']) ) {
    $department = strtoupper( $_GET['department'] );
    $course_number = $_GET['course_number'];
    if ( $course = Course::find_by_department_and_course_number($department, $course_number) ) {
      $data = array();
      $data[ 'current_user' ] = current_user();
      $data[ 'template' ] = COURSE_TMPL;
      echo $course->to_json( $data );
    } else {
      display_notice( "Course <strong>$department $course_number</strong> not found.", 'error' );
    }

  } else {
    $str = 'Route '. $_GET['action'] .' not recognized.';
    display_notice( $str, 'error' );
    header('Location: index.php') ;
    exit();

  }

?>