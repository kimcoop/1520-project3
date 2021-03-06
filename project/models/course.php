<?php

  class Course extends Model {

    public $id, $department, $course_number;
    public $user_courses;

    function __construct() {
      parent::__construct();
    }

    function to_json( $data ) {
      $json = $data;
      $json[ 'full_name' ] = $this->full_name();
      $json[ 'average_gpa' ] = $this->get_average_gpa();
      $json[ 'total_students' ] = $this->get_total_students();

      $json[ 'user_courses' ] = $this->get_user_courses_json();
      return json_encode( $json );
    }

    function get_user_courses_json() {

      $user_courses_json = array();

      $user_courses = $this->user_courses();
      usort( $user_courses, 'sort_by_term' );

      foreach( $user_courses as $user_course ) {
        $user_courses_json[] = array( "term" => $user_course->term,
                                    "psid" =>$user_course->psid,
                                    "grade" =>$user_course->grade,
                                    "user_id" => ( $user_course->user() ? $user_course->user()->get_user_id() : "User not in system" ));
      }

      return $user_courses_json;
    }

    public function get_values() {
      return array( $this->department, $this->course_number );
    }

    public function __toString() {
      return "$this->department $this->course_number";
    }

    public function full_name() {
     return "$this->department $this->course_number";
    }

    public function set_all( $id, $department, $course_number ) {
      $this->id = $id;
      $this->department = $department;
      $this->course_number = $course_number;
    }

    public function get_total_students() {
      return count( $this->user_courses() );
    }

    public function user_courses() {
      if ( !$this->user_courses ) 
        $this->user_courses = UserCourse::find_all_by_course_id( $this->id );
      return $this->user_courses;
    }

    public function get_average_gpa() {
      $user_courses = $this->user_courses();
      $total_user_courses = count($user_courses);
      if ( $total_user_courses == 0 ) return 0;

      $total_points = 0;
      foreach( $user_courses as $user_course )
        $total_points += parent::grade_points( $user_course->grade );

      return round($total_points / $total_user_courses, 2);
    }

    /*
    *
    * CLASS METHODS
    *
    */

    public static function find_by_department_and_course_number( $department, $course_number ) {
      return parent::where_one( 'courses', "department='$department' AND course_number='$course_number'" );
    }

    public static function find_by_id( $id ) {
      return parent::where_one( 'courses', "id='$id'" );
    }

    public static function where_one( $conditions ) {
      return parent::where_one( 'courses', $conditions );
    }

    public static function where_many( $conditions ) {
     return parent::where_many( 'courses', $conditions ); 
    }

    public static function get_properties() {
      return "department, course_number";
    }

    public static function load_record( $record ) {
      $course = new Course();
      $course->set_all( $record['id'], $record[ "department" ], $record[ "course_number" ] );
      return $course;
    }

    public static function handle_upload( $file ) {
      $objects = file( $file );
      return $objects;
      $additions = 0;
      foreach( $objects as $line ) {
        $object = Course::load_from_file( $line );
        if ( DB::insert( 'courses', $object ))
          $additions += 1;
      }
      return $additions;
    }

    public static function load_from_file( $line ) {
      $pieces = explode( ":", $line );
      $course = new Course();
      $course->set_all( -1, $pieces[0], $pieces[1] ); // new entities have no ID
      return $course;
    }

    public static function get_courses_for_user( $psid ) {
      // collect which courses map to the passed-in psid
      $courses = parent::find_all( 'courses' );

      $user_courses = array();

      foreach( $courses as $course ) {
        if ( $course->psid == $psid ) {
          $user_courses[] = $course;
        }
      }
      
      return $user_courses;
    }

    public static function get_courses_by( $grouping, $psid ) {
      $all_courses = parent::find_all( 'courses' );
      $courses = array();
      foreach( $all_courses as $course ) {
        if ( $course->psid == $psid ) {
          if ( $grouping == 'term' )
            $courses[ $course->term ][] = $course; // TODO - better?
          else
            $courses[ $course->department ][] = $course;
        }
      }
      return $courses;
    }
  }


?>