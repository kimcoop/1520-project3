var tabs = {

  init: function() {
    var navTabContainer = document.getElementsByClassName( 'nav-tabs' )[ 0 ];

    if ( !navTabContainer )
      return;

    var navTabs = navTabContainer.children;
    var tabPanes = document.getElementsByClassName( 'tab-pane' );

    for ( var i=0; i < navTabs.length; i++ ) {
      var tab = navTabs[ i ];

      tab.children[ 0 ].onclick = function( event ) { // anchor tag
        event.preventDefault();
      }
      tab.onclick = function( event ) {
        var link = this.children[ 0 ];
        var href = link.href.split( "#" ).pop(),
          tabPane = document.getElementById( href );

        // deactive all tabs, skipping current tab
        for ( var j=0; j < navTabs.length && j != i; j++ ) {
          navTabs[ j ].className = navTabs[ j ].className.replace( "active", "" );
          tabPanes[ j ].className = tabPanes[ j ].className.replace( "active", "" );
        }

        if ( this.className.indexOf( "active" ) == -1 ) {
          this.className += " active";
          tabPane.className += " active";
        } else {
          this.className = this.className.replace( "active", "" ); 
          tabPane.className = tabPane.className.replace( "active", "" ); 
        }
      };
    }

  }
   
}