var links = {
  init: function() {
    var main = document.getElementById( 'main' );
    var links = main.getElementsByTagName( "a" );
    for ( var i=0; i < links.length; i++ ) {
      if ( links[ i ].className.indexOf( "no-link" ) > -1 || links[i].className.indexOf( "normal-link" ) > -1 ) {
        return;
      }
      links[ i ].onclick = function( event ) {
        var e = event || window.event;
        e.preventDefault();
        var url = this.href, data = {};
        if ( url.indexOf( "?" ) > -1 )
          url = url.split( "/" ).pop();
        xmlHttp.get({
          url: url,
          callback: function( data ) {
            console.log( 'jsut got data from a normal link at URL ', url);
            applyView( data.template, data );
          }
        });
      };
    }
    var homeLinks = document.getElementsByClassName( 'link-home' );
  
    for ( var i=0; i < homeLinks.length; i++ ) {
      homeLinks[ i ].onclick = function( event ) {
        var e = event || window.event;
        e.preventDefault();
        var template = window.currentUser.role == "Student" ? "student_dashboard_tmpl" : "advisor_dashboard_tmpl";
        applyView( template, window.currentUser );
      }
    }
  }
  
}
