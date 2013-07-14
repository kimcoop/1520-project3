<?php require_once( 'functions.php' ); ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Advisor Cloud 3.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans|Source+Sans+Pro:300,900|Lobster' rel='stylesheet' type='text/css'>
    <link href="css/style.css" rel="stylesheet">
    
  </head>
  
  <body>

  <?php if ( is_logged_in() ): ?>
      
    <div id="header">
      <header>
        <div class="container nav-container">
          <ul class="nav nav-pills pull-right" id="nav">
            <li class="">
              <a href="<?php echo get_root_url() ?>">Welcome, <?php echo current_user()->get_full_name() ?></a>
            </li>
            
            <?php if ( current_user()->is_student() ) { ?>
              <li>
                <a href="review.php">Reviews</a>
              </li>
            <?php } ?>

            <?php if ( current_user()->is_admin() ) { ?>
              <li>
                <a href="admin.php">Admin</a>
              </li>
            <?php } ?>
            
            <li>
              <a href="settings.php">Settings</a>
            </li>

            <li>
              <a href="routes.php?action=logout" id="link-logout">Logout</a>
            </li>

          </ul>
          <h3 class="title muted">
            <a href="<?php echo get_root_url() ?>" class="link-home">Advisor Cloud 3.0</a>
          </h3>
        </div><!-- .container -->
      </header>
    </div>

  <?php endif ?>
  
    <div class="container main">
      <div id="notice"></div>
      <div id="main">