<?php

  class Uploader {

    public static function upload() {

      $target_path = "../files/uploads/";
      $target_path = "/";
      $basename = basename( $_FILES['uploaded_file_name']['name'] );
      $target_path = $target_path . $basename; 

      if ( move_uploaded_file( $_FILES['uploaded_file_name']['tmp_name'], $target_path ) )
        return $target_path;
      else
        return false;

    }
  }

?>