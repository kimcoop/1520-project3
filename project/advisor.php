
<code>
  include( 'templates/header.php' );<br>
  if ( is_logged_in() && is_advisor() ):<br>
    clear_browsing_session();<br>
<code>



  <div class="row">
    <div class="main-content span10">
      <div class="hgroup">
        <h2>
          <i class="icon-dashboard"></i>&nbsp;
          { role } Dashboard
        </h2>
        <code> include('templates/notice.php') </code>
      </div><!-- .hgroup -->

      <p>Welcome to your { role } dashboard! Use the inputs below to look up a student or course.</p>

      <br>
      <div class="row row-search">
        <div class="span5 search-student well well-padded text-center">
          <h2>
            <span class="icon-stack">
              <i class="icon-circle icon-stack-base"></i>
              <i class="icon-user icon-light"></i>
            </span>
          </h2>
          <h3>Search for a Student</h3>
          <form action="routes.php" method="get" name="search_student_form">
            <input class="input-block-level" autofocus placeholder="<PeopleSoft #> or <FirstName LastName>" type="text" name="student_search_term">
            <button type="submit" class="btn-block btn-large btn-primary btn" name="search_student_form_submit">
              <i class="icon-search"></i>&nbsp;
              Search students
            </button>
            <br>
          </form>
        </div><!-- .search-student -->

        <div class="span5 search-course well well-padded text-center">
          <h2>
            <span class="icon-stack">
              <i class="icon-circle icon-stack-base"></i>
              <i class="icon-pencil icon-light"></i>
            </span>
          </h2>
          <h3>Search for a Course</h3>
          <form action="routes.php" method="post" name="search_course_form">
            <input class="input-small" placeholder="Department" type="text" name="department">
            <input placeholder="Course number" type="text" name="course_number">
            <button value="true" type="submit" class="btn-block btn-large btn-primary btn" name="search_course_form_submit">
              <i class="icon-search"></i>&nbsp;
              Search courses
            </button>
            <br>
          </form>
        </div><!-- .search-course -->
      

    </div><!-- .row-search -->
  </div><!-- .main-content-->

</div><!-- .row -->

<code>
include('templates/footer.php')
</code>