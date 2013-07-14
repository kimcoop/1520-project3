<?php

  include( 'libs/db.php' );
  include( 'libs/model.php' );

  include( 'models/user.php' );
  include( 'models/course.php' );
  include( 'models/note.php' );
  include( 'models/session.php' );
  include( 'models/requirement.php' );
  include( 'models/requirement_course.php' );
  include( 'models/user_course.php' );
  include( 'models/user_review.php' );
  
  define( "SAMPLE_FILE_ROOT", 'files/sample_' );
  define( "NO_INSERTION", FALSE );

  function clean() {
    echo "Cleaning out notes directory...<br/>";
    $notes = glob( 'files/notes/*' ); // get all file names
    if ( $notes ) {
      foreach( $notes as $note ){ // iterate files
        if ( is_file( $note ) )
          unlink( $note ); // delete file
      }
    }

    echo "Resetting tables in database...<br/>";

    DB::run( "DROP TABLE IF EXISTS users" );
    DB::run( "DROP TABLE IF EXISTS courses" );
    DB::run( "DROP TABLE IF EXISTS user_courses" );
    DB::run( "DROP TABLE IF EXISTS user_reviews" );
    DB::run( "DROP TABLE IF EXISTS requirements" );
    DB::run( "DROP TABLE IF EXISTS requirement_courses" );
    DB::run( "DROP TABLE IF EXISTS notes" );
    DB::run( "DROP TABLE IF EXISTS sessions" );
    
  }

  function create_tables() {

    $users_sql = "CREATE TABLE users(
      psid int PRIMARY KEY NOT NULL,
      access_level int(1) NOT NULL,
      user_id varchar(255) NOT NULL,
      email varchar(255) NOT NULL,
      first_name varchar(255) NOT NULL,
      last_name varchar(255) NOT NULL,
      password varchar(255) NOT NULL,
      secret_question varchar(255),
      secret_answer varchar(255)
      )";

    $courses_sql = "CREATE TABLE courses(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      department varchar(255) NOT NULL,
      course_number int NOT NULL,
      UNIQUE INDEX department_course_number( department, course_number )
      )";
  
    // NOTE: including department and course_number here is repetitive,
    // should be fixed long-term.
    $user_courses_sql = "CREATE TABLE user_courses(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      course_id int NOT NULL,
      psid int NOT NULL,
      department varchar(255) NOT NULL,
      course_number int NOT NULL,
      term varchar(255) NOT NULL,
      grade varchar(5) NOT NULL,
      UNIQUE INDEX course_psid_term( course_id, psid, term )
      )";

    $requirements_sql = "CREATE TABLE requirements(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      title varchar(255) NOT NULL,
      category varchar(255),
      UNIQUE INDEX uniq_title( title )
      )";
    
    $requirement_courses_sql = "CREATE TABLE requirement_courses(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      requirement_id int NOT NULL,
      course_id int NOT NULL,
      UNIQUE INDEX requirement_course( requirement_id, course_id )
      )";

    $notes_sql = "CREATE TABLE notes(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      psid varchar(255) NOT NULL,
      author_id varchar(255),
      session_id int,
      dashed_timestamp varchar(255) NOT NULL,
      UNIQUE INDEX psid_timestamp( psid, dashed_timestamp )
      )";
    
    $sessions_sql = "CREATE TABLE sessions(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      psid varchar(255) NOT NULL,
      author_id varchar(255),
      dashed_timestamp varchar(255) NOT NULL,
      UNIQUE INDEX psid_timestamp( psid, dashed_timestamp )
      )";

    $user_reviews_sql = "CREATE TABLE user_reviews(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      course_id int NOT NULL,
      psid int NOT NULL,
      grade varchar( 3 ) NOT NULL,
      would_recommend varchar( 3 ) NOT NULL,
      review varchar( 400 ),
      UNIQUE INDEX course_id_psid( course_id, psid )
      )";

    echo "<br>";
    echo "<strong>Creating tables...</strong><br/>";
    echo "<ul>";

    DB::run( $users_sql );
    echo "<li>users</li>";
    DB::run( $courses_sql );
    echo "<li>courses</li>";
    DB::run( $user_courses_sql );
    echo "<li>user_courses</li>";
    DB::run( $requirements_sql );
    echo "<li>requirements</li>";
    DB::run( $requirement_courses_sql );
    echo "<li>requirement_courses</li>";
    DB::run( $notes_sql );
    echo "<li>notes</li>";
    DB::run( $sessions_sql );
    echo "<li>sessions</li>";
    DB::run( $user_reviews_sql );
    echo "<li>user_reviews</li>";

    echo "</ul>";

  }

  function populate_table( $klass, $filename, $table=NULL, $do_insertion=TRUE ) {
    if ( $table == NULL ) 
      $table = $filename;
    $file = SAMPLE_FILE_ROOT . $filename . ".txt";
    if ( !file_exists( $file )) 
      return;
    echo "<li>$table ($filename.txt) </li>";
    $objects = file( $file );
    foreach( $objects as $line ) {
      $object = $klass::load_from_file( $line );
      if ( $do_insertion )
        DB::insert( $table, $object );
    }
  }

  function populate_tables() {

    echo "<strong>Populating tables from files...</strong><br/>";
    echo "<ul>";
    
    populate_table( "User", "users" );
    populate_table( "Course", "courses" );
    populate_table( "Requirement", "requirements" );
    populate_table( "UserCourse", "courses", "user_courses" );
    populate_table( "RequirementCourse", "requirements", "requirement_courses", NO_INSERTION );
    // My files - not provided, only used for debugging
    // populate_table( "Note", "notes" );
    // populate_table( "Session", "sessions" );

    echo "</ul>";
  }


  /*
  *
  * MAIN
  *
  */

  clean();
  create_tables();
  populate_tables();

  echo "<br><strong>Done!</strong>";


?>