<?php 

  include( 'templates/header.php' );
  if ( is_logged_in() ): 

?>

<div class="hgroup">
  <h2>Course Reviews</h2>
  <p>Use this page to write a review for a course you've taken, or to view reviews you've already written.</p>
</div><!-- .hgroup -->

<div class="row">
  <div class="span12">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#my_reviews" data-toggle="tab">Reviews</a></li>
      <li><a href="#new_review" data-toggle="tab">New Review</a></li>
    </ul>
  </div>
</div>


<div class="tab-content">

  <div class="tab-pane active" id="my_reviews">
  </div><!-- #my_reviews -->

  <div class="tab-pane" id="new_review">

    <form class="validate-require-all" action="routes.php" method="post" name="review_course">
      <br>
      <?php $user_courses = UserCourse::find_all_by_psid( current_user()->get_psid() );
      if ( !!$user_courses ): ?>
        <div class="row" id="row-review">
          <div class="half-column well">
            <h3>Course Basics</h3>

            <fieldset>
              <label>What course are you reviewing?</label>
              <select name="course_id">
                <?php foreach ( $user_courses as $course ): ?>
                  <option value="<?php echo $course->course_id ?>"><?php echo $course->department . " " . $course->course_number ?></option>
                <?php endforeach; ?>
              </select>

              <label>What grade would you give this course?</label>
              <input type="radio" name="grade" value="A+"> A+&nbsp;&nbsp;
              <input type="radio" name="grade" value="A"> A&nbsp;&nbsp;
              <input type="radio" name="grade" value="A-"> A-&nbsp;&nbsp;
              <input type="radio" name="grade" value="B+"> B+&nbsp;&nbsp;
              <input type="radio" name="grade" value="B"> B&nbsp;&nbsp;
              <input type="radio" name="grade" value="B-"> B-&nbsp;&nbsp;
              <br>
              <input type="radio" name="grade" value="C+"> C+&nbsp;&nbsp;
              <input type="radio" name="grade" value="C" checked> C&nbsp;&nbsp;
              <input type="radio" name="grade" value="C-"> C-&nbsp;&nbsp;
              <input type="radio" name="grade" value="D+"> D+&nbsp;&nbsp;
              <input type="radio" name="grade" value="D"> D&nbsp;&nbsp;
              <input type="radio" name="grade" value="D-"> D-&nbsp;&nbsp;
              <input type="radio" name="grade" value="F"> F&nbsp;&nbsp;

              <label>Would you recommend this course to a friend?</label>
              <input type="radio" name="would_recommend" value="yes" checked> yes
              <input type="radio" name="would_recommend" value="no"> no        
              
              </fieldset>
          </div>
          <div class="half-column well">
              <h3>Your Review</h3>
              <br>
              <fieldset>
                <textarea name="review" placeholder="Your review here" rows="10" cols="50"></textarea>
              </fieldset>
          </div>
          <br>
        </div><!-- #row-review -->

        <button name="review_course_submit" type="submit" class="pull-right btn-large btn btn-primary">Submit Review</button>

    <?php else: ?>
    <p>Sorry, you must have taken at least one course in order to write a review.</p>
    <?php endif; ?>
    </form>
  </div><!-- #new_review -->
</div><!-- .tab-content -->

<?php
  
  endif;
  include( 'templates/footer.php' );

?>