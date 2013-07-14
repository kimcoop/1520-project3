<?php 

  include( 'templates/header.php' ); 
  if ( is_logged_in() ):

?>

<div class="hgroup">
  <h2>
    <?php echo current_user()->get_first_name() ?>'s
    <span class="light">Student Dashboard</span>
  </h2>

  <p>
    Welcome to your student dashboard. Here you'll find records of courses you've taken.
  </p>
</div><!-- .hgroup -->

<ul class="nav nav-tabs">
  <li class='active'><a href="#courses_by_term" data-toggle="tab">Courses by term</a></li>
  <li><a href="#courses_by_department" data-toggle="tab">Courses by department</a></li>
  <li><a href="#grad_requirements" data-toggle="tab">Graduation requirements</a></li>
</ul>

<div class="tab-content">
  <div class="tab-pane active" id="courses_by_term">
   <table class="table table-hover">
      <?php

        $courses_per_term = UserCourse::find_by( 'term', current_user()->get_psid() );

        if ( !empty($courses_per_term) ) {
          ksort( $courses_per_term );
          foreach( $courses_per_term as $term => $courses ) {
          ?>
            <tr>
              <td><?php echo $term; ?></td>
              <td><?php foreach( $courses as $course ) echo "$course<br>" ?></td>
            </tr>
          <?php
            } // foreach $courses_per_term
          } else {
            echo "No courses taken.";
          }
        ?>
    </table>
  </div><!-- #courses_by_term -->

  <div class="tab-pane" id="courses_by_department">
    <table class="table table-hover">
      <?php
        $courses_by_department = UserCourse::find_by( 'department', current_user()->get_psid() );

        if ( !empty($courses_by_department) ):
          foreach( $courses_by_department as $department => $courses ): ?>
            <tr>
              <td><?php echo $department; ?></td>
              <td><?php foreach( $courses as $course ) echo "$course<br>" ?></td>
            </tr>
        <?php
          endforeach;
        else:
          echo "No courses taken.";
        endif;
      ?>
    </table>
  </div><!-- #courses_by_department -->

  <div class="tab-pane" id="grad_requirements">
    <table class="table table-hover">

    <?php
      
        $reqs = Requirement::find_all();

        ksort( $reqs );
        foreach( $reqs as $index => $req ) {
        ?>
          <tr>  
            <td class="muted"><?php echo $index + 1?></td>
            <td><strong><?php echo $req->title; ?></strong></td>
            <td>
              <?php if ( $course = $req->get_satisfying_course( current_user()->get_psid() ) ) { ?>
                <span class='text-success'>
                  <i class="icon icon-check"></i>
                </span>
              <?php
                } else { 
              ?>
                <span class='text-error'>
                  <i class="icon icon-check-empty"></i>k
                </span>
              <?php } ?>
            </td>
            <td>
          
            <?php
            
              if ( $course ) {
                echo $course;
              } else {
                echo "<span class='muted'>Requirement not satisfied. Course options: ";
                echo $req->get_requirements();
                echo "</span>";
              }
            ?>

            </td>
          </tr>

          
          <?php
          
          } // foreach $reqs

        ?>
    </table>
  </div><!-- #grad_requirements -->
</div><!-- .tab-content -->

<?php 
  endif;
  include( 'templates/footer.php' ); 
?>