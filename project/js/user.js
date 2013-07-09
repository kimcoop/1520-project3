(function() {
  var user = undefined;

  this.getCurrentUser = function() {
    if ( user ) return user;

    user = xmlHttp.get({
      async: false,
      url: Config.url + 'routes.php?action=get_current_user',
      callback: function( data ) {
        setCurrentUser( data );
        console.log( 'recvd user: ');
        console.debug( data );
        return user;
      }
    });
  };

  this.setCurrentUser = function( userData ) {
    user = userData;
  }

})();