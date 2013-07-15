var AC_Links = {

  initHomeLinks: function() {
    var homeLinks = document.getElementsByClassName( 'link-home' );
    if ( !homeLinks ) return;
    for ( var i=0; i < homeLinks.length; i++ ) {
      homeLinks[ i ].onclick = function( event ) {
        var e = event || window.event;
        e.preventDefault();
        var isStudent = location.href.indexOf( "student_dashboard" ) != -1;
        location.href = isStudent ? "student_dashboard.php" : "advisor_dashboard.php";
      }
    }
  },

  prevent: function( event ) {
    var e = event || window.event;
    e.preventDefault();
  },

  init: function() {
    var main = document.getElementById( 'main' );
    var links = main.getElementsByTagName( "a" );
    for ( var i=0; i < links.length; i++ ) {
      if ( links[ i ].className.indexOf( "no-link" ) > -1 || links[i].className.indexOf( "normal-link" ) > -1 ) {
        return;
      }
      links[ i ].onclick = function( event ) {
        AC_Links.prevent( event );
        var url = this.href, data = {};
        if ( url.indexOf( "?" ) > -1 )
          url = url.split( "/" ).pop();
        xmlHttp.get({
          url: url,
          callback: function( data ) {
            applyView( data.template, data );
          }
        });
      };
    }
    AC_Links.initHomeLinks();
  }
  
}
