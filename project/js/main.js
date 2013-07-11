
window.Config = {
  url: 'http://localhost:8888/1520-project3/project/'
}
window.currentUser = {};

function showNotice( message, type ) {
  applyView( 'notice_tmpl', { message: message, type: type } );
}

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