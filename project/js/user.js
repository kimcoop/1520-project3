var AC_User = {

    user: undefined,

    get: function() {
      if ( !!AC_User.user ) return AC_User.user;

      xmlHttp.get({
        async: false,
        url: Config.url + 'routes.php?action=get_current_user',
        callback: function( data ) {
          AC_User.set( data );
          return data;
        }
      });
    },

    set: function( userData ) {
      AC_User.user = userData;
    }
    
}