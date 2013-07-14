<?php 

  include('templates/header.php');
  if ( !is_logged_in() ):

?>

  <h2 class="text-center">Password Retrieval</h2>

  <br>
  <br>

  <?php if ( $_GET['step'] == 'user_id' ): ?>
    <form class="form-signin normal-form" action="routes.php" name="forgot_password_step_1" method="post">

      <div id="notice"></div>

      <h3>Step 1. <span class="muted">Provide your user ID</span></h3>
      <p>Once you answer your secret question (if you've provided one), an email will be sent to the email associated with this account.</p>

      <input autofocus type="text" class="input-block-level" placeholder="User ID" name="user_id" />

      <br>
      <br>

      <button id="forgot_password_step_1_submit" type="submit" class="btn pull-right btn-large btn-primary" name="forgot_password_step_1_submit">Continue</button>
    </form>

  <?php elseif ( $_GET['step'] == 'secret_question' ):
      $user_id = $_GET['user_id'];
      $user = User::find_by_user_id( $user_id );
      $secret_question = $user->get_secret_question(); 
    ?>

    <form class="form-signin normal-form" action="routes.php" name="forgot_password_step_2" method="post">
      <div id="notice"></div>

      <input type="hidden" value="<?php echo $user_id ?>" name="user_id" />

      <h3>Step 2. <span class="muted">Answer your secret question</span></h3>
      <p>Answer the following question to receive your reset password via email.</p>
      <h3><?php echo $secret_question ?></h3>

      <label>Secret answer</label>
      <input autofocus type="text" class="input-block-level" placeholder="Answer" name="secret_answer" />

      <br>

      <button type="submit" class="btn pull-right btn-large btn-primary" name="forgot_password_step_2_submit">Submit</button>
      <a href="index.php" class="normal-link btn pull-right btn-large">Back</a>

      <br>
      <br>
    </form>

  <?php elseif ( $_GET['step'] == 'emailed' ): ?>

    <form class="form-signin">
      <h3 class="text-success">Success!</h3>
      <p>A new password has been emailed to you.</p>
      <a href="index.php" class="normal-link btn btn-large btn-primary">Back</a>
    </form>

  <?php endif;
  endif; 


include( 'templates/footer.php' ); ?>

