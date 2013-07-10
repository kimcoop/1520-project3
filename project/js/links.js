var links = {
  init: function() {
    var main = document.getElementById( 'main' );
    var links = main.getElementsByTagName( "a" );
    for ( var i=0; i < links.length; i++ ) {
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
      console.log( 'homeLinks');
      homeLinks[ i ].onclick = function( event ) {
        var e = event || window.event;
        e.preventDefault();
        var template = window.currentUser.role == "Student" ? "student_dashboard_tmpl" : "advisor_dashboard_tmpl";
        applyView( template, window.currentUser );
      }
    }
  },

  initHeader: function() {

    var header = document.getElementById( 'header' ),
        html = tmpl( 'header_tmpl', window.currentUser );
      header.innerHTML = html;

    var settingsLink = document.getElementById( 'link-settings' ),
      logoutLink = document.getElementById( 'link-logout' );

    if ( window.currentUser.is_admin ) {
      var adminLink = document.getElementById( 'link-admin' );
      adminLink.onclick = function( event ) {
        var e = event || window.event;
        e.preventDefault();
        xmlHttp.get({
          url: Config.url + 'routes.php?action=get_users',
          callback: function( data ) {
            applyView( 'admin_tmpl', { users: data } );
          }
        });
      }
    }
      
    settingsLink.onclick = function( event ) {
      var e = event || window.event;
      e.preventDefault();
      applyView( 'settings_tmpl', window.currentUser );
    }
  }
  
}
