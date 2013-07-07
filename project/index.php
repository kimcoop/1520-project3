<?php /*require_once('functions.php'); */?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Advisor Cloud 3.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
    <link href="css/style.css" rel="stylesheet">
    
  </head>
  
  <body>
    <div id="main">
      <div class="container main">

        <form class="form-signin" action="routes.php" name="signin_form" method="post">

          <br>
          <br>

          <h2 class="text-center form-signin-heading">Welcome to Advisor Cloud</h2>

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

      <div class="push"></div>
    </div> <!-- .container.main -->

    <footer>
      <div class="container">
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p class="text-center">
          <?php
            $format = '%1$s %2$s %3$s. All Rights Reserved.';
            echo sprintf( $format, '&copy;', date('Y'), 'AdvisorCloud' );
          ?>
        </p>
      </div><!-- .container -->
    </footer>

    </div><!-- #main (replaceable content) -->

    <script src="js/xmlHttpHandler.js"></script>
    <script src="js/microtemplate.js"></script>
    <script type="text/javascript">

      window.onload = function() {
        console.log('onload');
      }

      /*
      *
      */

      function templatize( data, templateName ) {
        var tmpl = new microtemplate( 'templates/' + templateName ),
          html = tmpl.render({ full_name: data.full_name });
        return html;
      }

      function applyView( data ) {
        console.log('applyView');
        var container = document.getElementById( 'main' );

        container.innerHTML = templatize( data, 'course.html' );
        initInteractions();
      }

      function submitForm( form, event ) {
        var e = event || window.event;
        e.preventDefault();
        xmlHttp.postForm( form );
      }

      function clickLink( link, event ) {
        var e = event || window.event;
        e.preventDefault();
        var url = link.href;
        if ( url.indexOf( "?" ) > -1 ) { // then it's a GET request
          request = url.split( "/" ).pop();
          xmlHttp.get( request, function( data ) {
            console.debug( data );
            applyView( data );
          });
        } else {
          xmlHttp.get( url, function( data ) {
            console.debug( data );
            applyView( data );
          });
        }
      }

      function initInteractions() {
        var forms = document.getElementsByTagName( "form" );
        for ( var i=0; i < forms.length; i++ ) {
          forms[ i ].onsubmit = function( event ) {
            console.log("SUBMITTING");
            submitForm( this, event );
          };
        }

        var links = document.getElementsByTagName( "a" );
        for ( var i=0; i < links.length; i++ ) {
          links[ i ].onclick = function( event ) {
            clickLink( this, event );
          };
        }
      };

      initInteractions();



    </script>
  </body>
</html>