<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Advisor Cloud 3.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans|Source+Sans+Pro:300,900' rel='stylesheet' type='text/css'>
    <link href="css/style.css" rel="stylesheet">
    
  </head>
  
  <body>
      <div id="header"></div>
      <div class="container main">
        <div id="notice"></div>
        <div id="main">

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
              <a href="forgot_password.php?step=user_id">Forgot password?</a>
            </span>
            
          </form>

        </div> <!-- #main -->
      <div class="push"></div>
  </div><!-- .container.main -->

  <footer>
    <div class="container">
      <p class="text-center">
        <?php
          $format = '%1$s %2$s %3$s. All Rights Reserved.';
          echo sprintf( $format, '&copy;', date('Y'), 'AdvisorCloud' );
        ?>
      </p>
    </div>
  </footer>

  <script src="js/xmlHttpHandler.js"></script>
  <script src="js/simpleTemplate.js"></script>
  <script src="js/tabs.js"></script>
  <script src="js/user.js"></script>
  <script src="js/links.js"></script>
  <script src="js/forms.js"></script>
  <script type="text/javascript">

    window.Config = {
      url: 'http://localhost:8888/1520-project3/project/'
    }
    window.currentUser = {};

    function applyView( template, data ) {
      console.log('applyView. ');
      console.debug( arguments );
      if ( template && data ) {
        var container = template !== 'notice_tmpl' ? document.getElementById( 'main' ) : document.getElementById( 'notice' ), 
          html = tmpl( template, data );

        container.innerHTML = html;
        initInteractions();
      }
    }

    function showHeader( userData ) {
      window.currentUser = userData;
      links.initHeader();
    }

    function refreshCurrentStudent() {
      xmlHttp.get({
        url: Config.url + 'routes.php?action=get_current_student',
        callback: function( data ) { applyView( data.template, data ); }
      });
    }

    function toggleNote( noteId ) {
      var note = document.getElementById( noteId );
      if ( !note ) return false;

      var showing = note.className.indexOf( "hidden" ) != -1 ;
      if ( showing ) {
        // this.innerHTML = "Hide note";
        note.className = note.className.replace( "hidden", "" );
      } else {
        // this.innerHTML = "View note";
        note.className += " hidden";
      }
      return false;
    }

    function initInteractions() {
      if ( window.currentUser ) {
        links.init();
        tabs.init(); // must overwrite some links
      }

      forms.init();

      var closeButtons = document.getElementsByClassName( 'close' );
      if ( closeButtons ) {
        for ( var i=0; i < closeButtons.length; i++ ) {
          closeButtons[ i ].onclick = function( event ) {
            event.target.parentNode.className += " hidden";
          };
        }
      }

    } // initInteractions

    initInteractions();

  </script>
  <script type="text/html" id="advisor_dashboard_tmpl"><?php include( 'templates/advisor_dashboard.html'); ?></script>
  <script type="text/html" id="student_dashboard_tmpl"><?php include( 'templates/student_dashboard.html'); ?></script>
  <script type="text/html" id="course_tmpl"><?php include( 'templates/course.html'); ?></script>
  <script type="text/html" id="student_tmpl"><?php include( 'templates/student.html'); ?></script>
  <script type="text/html" id="notice_tmpl"><?php include( 'templates/notice.html'); ?></script>
  <script type="text/html" id="header_tmpl"><?php include( 'templates/header.html'); ?></script>
  <script type="text/html" id="settings_tmpl"><?php include( 'templates/settings.html'); ?></script>
  <script type="text/html" id="admin_tmpl"><?php include( 'templates/admin.html'); ?></script>

  </body>
</html>





