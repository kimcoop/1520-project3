window.User = {
  currentUser: undefined,
  
  getCurrentUser: function() {
    if ( !this.currentUser ) {
      this.currentUser = xmlHttp.get({
        async: false,
        url: Config.url + 'routes.php?action=get_current_current_user',
        callback: function( data ) {
          console.log( 'recvd currentUser: ');
          currentUser = data;
          console.debug( currentUser );
          return currentUser;
        }
      });
    }
    return this.currentUser;
  },

  setCurrentUser: function( currentUser ) {
    this.currentUser = currentUser;
  }

}