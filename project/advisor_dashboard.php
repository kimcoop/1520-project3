<?php 

  include( 'templates/header.php' );
  if ( is_logged_in() && current_user()->is_advisor() ):
    clear_browsing_session();

?>

<div class="row">
    <div class="hgroup">
      <h2><?php current_user()->get_role() ?> Dashboard</h2>
      <p>Welcome to your <?php current_user()->get_role() ?> dashboard! Use the inputs below to look up a student or course.</p>
    </div><!-- .hgroup -->

    <div class="row row-search">
      <div class="search-student">
        <h3 class="label">Search for a Student</h3>
        <form action="routes.php" method="get" name="search_student_form" id="search_student_form" class="validate-psid">
          <input class="validate-psid-input input-large" autofocus placeholder="<PeopleSoft #> or <FirstName LastName>" type="text" name="student_search_term">
          <button type="submit" class="btn-primary btn" name="search_student_form_submit">
            Search students
          </button>
          <br>
        </form>
      </div><!-- .search-student -->

      <div class="search-course">
        <h3 class="label">Search for a Course</h3>
        <form action="routes.php" method="get" name="search_course_form">
          <input placeholder="Department" type="text" name="department">
          <input placeholder="Course number" type="text" name="course_number">
          <button value="true" type="submit" class="btn-primary btn" name="search_course_form_submit">
            Search courses
          </button>
          <br>
        </form>
      </div><!-- .search-course -->
    </div><!-- .row-search -->
    
</div><!-- .row -->

<?php 

  endif;
  include( 'templates/footer.php' ) 

?>