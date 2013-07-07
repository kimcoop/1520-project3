<?php require_once('functions.php'); ?>

<?php if ( is_logged_in() ): ?>

    <header>
      <div class="container nav-container">
        <ul class="nav nav-pills pull-right">
          <li class="<?php if ( is_active_nav('home') ) echo 'active' ?>">
            <a href="<?php echo get_root_url(); ?>">
              <i class="icon icon-home"></i>&nbsp;
              Welcome, <?php echo current_user()->get_first_name(); ?>
            </a>
          </li>
          <?php if (current_user()->is_admin()) : ?>
          <li class="<?php if ( is_active_nav('admin') ) echo 'active' ?>">
            <a href="admin.php">
              <i class="icon icon-key"></i>&nbsp;
              Admin
            </a>
          </li>  
          <?php endif; ?>
          <li class="<?php if ( is_active_nav('settings') ) echo 'active' ?>">
            <a href="settings.php">
              <i class="icon icon-cog"></i>&nbsp;
              Settings
            </a>
          </li>
          <li>
            <a href="routes.php?action=logout">
              <i class="icon icon-signout"></i>&nbsp;
              Logout
            </a>
          </li>
        </ul>
        <h3 class="title muted">
          <a href="<?php echo get_root_url(); ?>">
          Advisor Cloud 3.0
          </a>
        </h3>
      </div><!-- .container -->
    </header>

<?php endif; ?>

<div class="container main">