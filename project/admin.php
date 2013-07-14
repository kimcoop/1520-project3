<?php 

  include( 'templates/header.php' );
  if ( is_logged_in() ): 

?>

<div class="hgroup">
  <h2>Admin</h2>
</div><!-- .hgroup -->

<div class="row">
  <div class="span12">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#users" data-toggle="tab">Users</a></li>
      <li><a href="#courses" data-toggle="tab">Courses</a></li>
    </ul>
  </div>
</div>

<div class="tab-content">
  <div class="tab-pane active" id="users">
    <div class="row row-admin">
      <div class="half-column well">
        <br>
        <h3>Add user</h3>
        <form class="validate-require-all" action="routes.php" method="post" name="add_user_form">
          <fieldset>
            <label>Email</label>
            <input type="text" class="input-block-level" placeholder="Email" name="email">
            <label>First name</label>
            <input type="text" class="input-block-level" placeholder="First name" name="first_name">
            <label>Last name</label>
            <input type="text" class="input-block-level" placeholder="Last name" name="last_name">
            <label>Password</label>
            <input type="text" class="input-block-level" placeholder="Password" name="password">
            <label>PeopleSoft #</label>
            <input type="text" class="input-block-level" placeholder="PeopleSoft #" name="psid">
            <label>User ID</label>
            <input type="text" class="input-block-level" placeholder="User ID" name="user_id">
            <label>Access level</label>
            <select class="input-block-level" name="access_level">
              <option value="0">0 - Student</option>
              <option value="1">1 - Advisor</option>
              <option value="2">2 - Admin</option>
            </select>
            <br>
            <br>
            <button name="add_user_form_submit" type="submit" class="btn btn-large btn-primary btn-block">Create user</button>
          </fieldset>
        </form>
      </div><!-- .span -->
      <div class="half-column well">
        <br>
        <h3>Delete user</h3>
        <form action="routes.php" method="post" name="delete_user_form" id="delete_user_form">

          <fieldset>
            <label>User (last name, first name)</label>
            <select class="input-block-level" name="psid" id="deleteUserSelect">
                <?php 
                  $users = User::find_all();
                  usort( $users, 'sort_by_last_name' );
                  foreach( $users as $user ): 
                ?>
                  <option value="<?php echo $user->get_psid()?>"><?php echo $user->get_last_name() .", ". $user->get_first_name() ?></option>
                <?php endforeach; ?>
              </select>
            <br>
            <br>
            <button name="delete_user_form_submit" type="submit" class="btn btn-large btn-primary btn-block">Delete user</button>
          </fieldset>
        </form>
      </div><!-- .span -->
    </div><!-- .row -->
  </div><!-- #users.tab-pane -->
  <div class="tab-pane" id="courses">
    <div class="row row-admin">
      <div class="span3 well">
        <br>
        <h3>Load courses from file</h3>
        <form class="normal-form" enctype="multipart/form-data" action="routes.php" method="post" name="add_course_form">
          <fieldset>
            <label>File to upload:</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
            <input name="uploaded_file_name" type="file" /><br />
            <br>
            <br>
            <button name="add_course_form_submit" type="submit" class="btn btn-large btn-primary btn-block">Submit file</button>
          </fieldset>
        </form>
      </div><!-- .span -->
    </div><!-- .row -->
  </div><!-- #courses.tab-pane -->
</div>


<?php 
  endif;
  include( 'templates/footer.php' );
?>