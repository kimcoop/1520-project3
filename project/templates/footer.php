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


    <script src="js/XmlHttpHandler.js"></script>

    <script type="text/javascript">

      function submitForm( form, event ) {
        var e = event || window.event;
        e.preventDefault();
        xmlHttp.postForm( form );
      }

      var forms = document.getElementsByTagName( "form" );
      for ( var i=0; i < forms.length; i++ ) {
        forms[ i ].onsubmit = function( event ) {
          submitForm( this, event );
        };
      }
    </script>

  </body>
</html>
