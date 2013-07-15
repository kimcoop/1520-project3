
window.Config = {
  url: 'http://localhost:8888/1520-project3/project/'
  // url: 'http://cs1520.cs.pitt.edu/~kac162/assig3/'
}
window.onload = function() {
  initInteractions();
}

function showNotice( message, type ) {
  applyView( 'notice_tmpl', { message: message, type: type } );
}

function applyView( template, data ) {
  if ( template && data ) {
    var containerId = 'main';
    if ( data.containerId )
      containerId = data.containerId;
    if ( template == 'notice_tmpl' )
      containerId = 'notice';
    var container = document.getElementById( containerId ), 
      html = tmpl( template, data );

    container.innerHTML = html;
    initInteractions();
  }
}

function getReviewsForUser() {
  xmlHttp.get({
    url: Config.url + 'routes.php?action=get_user_course_reviews',
    callback: function( reviewsResponse ) {
      var data = { 
        user_reviews: reviewsResponse,
        containerId: 'my_reviews'
      }
      applyView( 'review_table_tmpl', data );
    }
  });  
}

function getAllUsersForSelect( selectId ) {
  xmlHttp.get({
    url: Config.url + 'routes.php?action=get_users',
    callback: function( usersResponse ) {
      var el = document.getElementById( selectId );
      var output = "<select name='psid'>";
      for ( var i = 0; i < usersResponse.length; i++ ) {
        var user = usersResponse[ i ],
          str = "<option value='" +user.psid+ "'>" +user.last_name+ ", " +user.first_name+ "</option>";
        output += str;
      }
      output += "</select>";
      el.innerHTML = output;
    }
  });  
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

  AC_Links.init();
  AC_Tabs.init(); // must overwrite some links
  AC_Forms.init();
  
  if ( !!document.getElementById( 'my_reviews' ) && document.getElementById( 'my_reviews' ).innerHTML.trim().length == 0 )
    getReviewsForUser();

  var closeButtons = document.getElementsByClassName( 'close' );
  if ( closeButtons ) {
    for ( var i=0; i < closeButtons.length; i++ ) {
      closeButtons[ i ].onclick = function( event ) {
        event.target.parentNode.className += " hidden";
      };
    }
  }

} // initInteractions