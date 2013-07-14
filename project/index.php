<?php include( 'templates/header.php' ) ?>

          <form id="signin_form" class="form-signin" action="routes.php" name="signin_form" method="post">


            <br>
            <br>
            <h1 class="text-center muted">Welcome to</h1>
            <h1 class="text-center text-primary">Advisor Cloud</h1>
            <br>

            <?php if (isset($_COOKIE['user_id'])): ?>

            <input type="text" class="input-block-level" placeholder="User ID" name="user_id" value="<?php echo $_COOKIE['user_id']; ?>" />
            <input autofocus type="password" class="input-block-level" placeholder="Password" name="password" />

            <?php else: ?>

            <input autofocus type="text" class="input-block-level" placeholder="User ID" name="user_id" />
            <input type="password" class="input-block-level" placeholder="Password" name="password" />

            <?php endif; ?>

            <button type="submit" class="btn btn-block btn-large btn-primary" name="signin_form_submit">Sign in</button>

            <br>
            <br>

            <span class="pull-right">
              <a class="normal-link" href="forgot_password.php?step=user_id">Forgot password?</a>
            </span>
            
          </form>

<?php include( 'templates/footer.php' ) ?>