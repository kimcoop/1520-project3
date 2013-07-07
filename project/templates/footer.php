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

      MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

      var observer = new MutationObserver(function(mutations, observer) {
          // fired when a mutation occurs
          console.log(mutations, observer);
          initInteractions(); // need to handle for every view "load"
      });

      // define what element should be observed by the observer
      // and what types of mutations trigger the callback
      observer.observe(document, {
        subtree: true,
        attributes: true
        //...
      });

      function applyView( viewData ) {
        var container = document.getElementById( 'main' );
        console.log('getting container');
        container.innerHTML = viewData;
      }

      function submitForm( form, event ) {
        console.log('SUBMIT FORM!!!');
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
            applyView( data );
          });
        } else {
          xmlHttp.get( url, function( data ) {
            applyView( data );
          });
        }
      }

      function initInteractions() {
        console.log('initInteractions');
        var forms = document.getElementsByTagName( "form" );
        for ( var i=0; i < forms.length; i++ ) {
          forms[ i ].onsubmit = function( event ) {
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
