<?php

session_start();

function __autoload($class) {
  $class = strtolower($class);
  if ( $class == 'usercourse' ) 
    $class = 'user_course';
  elseif ( $class == 'requirementcourse' ) 
    $class = 'requirement_course';
  
  $file = 'models/' . $class . '.php';
  if ( file_exists( $file ))
    include $file;
  elseif ( file_exists( 'libs/'. $class . '.php' ))
    include 'libs/'. $class . '.php';
}

date_default_timezone_set( 'America/New_York' );

define( "MAILER_SUBJECT", "Your AdvisorCloud Credentials" );
define( "MAILER_SENDER", "kac162@pitt.edu" );

function display_notice( $message, $type ) {
  // used to display a message onscreen if there is a notice for the
  $data = array();
  $data[ 'type' ] = $type;
  $data[ 'message' ] = $message;
  $data[ 'template' ] = NOTICE_TMPL;
  echo json_encode( $data );
  exit();
}

function was_posted( $name ) {
  return isset( $_POST[$name] );
}

function clear_browsing_session() {
  unset( $_SESSION['viewing_psid'] );
  unset( $_SESSION['viewing_user_id'] );
  current_user()->set_is_logging_session( FALSE );
}

function current_user() {
  return $_SESSION['user'];
}

function is_logged_in() {
  return isset( $_SESSION['user'] );
}

function is_student() {
  return current_user()->is_student();
}

function is_advisor() { // Admins have advisor privileges and more
  return current_user()->is_advisor() || current_user()->is_admin();
}

function is_admin() {
  return current_user()->is_admin();
}

function get_root_view() {
  if ( is_student() ) 
    return 'student_dashboard_tmpl'; 
  else
    return 'advisor_dashboard_tmpl';
}

function get_root_url() {
  // used in the nav bar, to correctly link the brand href
  if ( is_student() ) 
    return 'student_dashboard.php'; 
  else
    return 'advisor.php';
}

function sort_by_last_name( $a, $b ) {
  if ( $a->get_last_name() == $b->get_last_name() )
    return 0;
  else
    return ( $a->get_last_name() < $b->get_last_name() ? -1 : 1 );
}

function sort_by_term( $a, $b ) {
  if ( $a->term == $b->term )
    return 0;
  else
    return ( $a->term < $b->term ? -1 : 1 );
}

  /* 
  *

  ADVISOR FUNCTIONS 

  *
  */

  function set_viewing_student( $student_user ) {
    $_SESSION['viewing_psid'] = $student_user->get_psid();
    $_SESSION['viewing_user_id'] = $student_user->get_user_id();
  }


?>