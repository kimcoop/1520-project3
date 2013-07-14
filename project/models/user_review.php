<?php

  class UserReview extends Model {

    public $id, $course_id, $psid, $grade, $would_recommend, $review;

    public function set_all( $id, $course_id, $psid, $grade, $would_recommend, $review ) {
      $this->id = $id;
      $this->course_id = $course_id;
      $this->psid = $psid;
      $this->grade = $grade;
      $this->would_recommend = $would_recommend;
      $this->review = $review;
    }

    public function get_values() {
      return array( $this->course_id, $this->psid, $this->grade, $this->would_recommend, $this->review );
    }

    public function course() {
      return Course::find_by_id( $this->course_id );
    }


    /*
    *
    * CLASS METHODS
    *
    */
    public static function create( $psid, $course_id, $grade, $would_recommend, $review ) {
      $user_review = new UserReview();
      $user_review->set_all( 
        -1, // no ID for now
        addslashes( $course_id ),
        addslashes( $psid ),
        addslashes( $grade ),
        addslashes( $would_recommend ),
        addslashes( $review )
      );
      return DB::insert( 'user_reviews', $user_review );
    }

    public static function find_all_by_course_id( $course_id ) {
      return parent::where_many( 'user_reviews', "course_id='$course_id'" );
    }

    public static function get_properties() {
      return "course_id, psid, grade, would_recommend, review";
    }

    public static function load_record( $record ) {
      $user_review = new UserReview();
      $user_review->set_all( $record['id'], $record['course_id'], $record['psid'], $record['grade'], $record['would_recommend'], $record['review'] );
      return $user_review;
    }

    public static function where_one( $conditions ) {
      return parent::where_one( 'user_reviews', $conditions );
    }

    public static function where_many( $conditions ) {
     return parent::where_many( 'user_reviews', $conditions ); 
    }

    public static function find_all_by_psid( $psid ) {
      return parent::where_many( 'user_reviews', "psid='$psid'" );
    }

  }

?>