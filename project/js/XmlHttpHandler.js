var xmlHttp = {

  create: function() {
    return new XMLHttpRequest;
  },

  get: function( dataObj ) {
    var url = dataObj.url, 
        async = dataObj.async || true, 
        callback = dataObj.callback;

    var xmlHttp = this.create();

    xmlHttp.open( 'get', url, async );
    xmlHttp.send( null );
    xmlHttp.onreadystatechange = function() {
      if ( xmlHttp.readyState === 4 ) {
        if ( xmlHttp.status === 200 ) {
          var data = xmlHttp.responseText;
          try {
            data = JSON.parse( data );
          } catch ( error ) {
            alert( 'error parsing JSON data (see console)' );
            console.debug( data );
          }
          callback( data );
        } else {
          alert('Error: ' + xmlHttp.responseText);
        }
      } else {
        console.log( 'loading' );
      }
    };
  },

  post: function( dataObj ) {
    var url = dataObj.url, 
        data = dataObj.data,
        ecType = dataObj.ectype || "application/x-www-form-urlencoded",
        async = dataObj.async || true, 
        callback = dataObj.callback;

    var xmlHttp = this.create();
    xmlHttp.open( 'post', url, async );
    xmlHttp.setRequestHeader( "Content-Type", ecType );
    xmlHttp.send( data );
    xmlHttp.onreadystatechange = function() {
      if ( xmlHttp.readyState === 4 ) {
        if ( xmlHttp.status === 200 ) {
          var data = xmlHttp.responseText;
          try {
            data = JSON.parse( data );
          } catch ( error ) {
            alert( 'error parsing JSON data (see console)' );
            console.debug( data );
          }
          callback( data );
        } else {
          alert('Error: ' + xmlHttp.responseText);
        }
      } else {} // loading
    };
  },

  submitForm: function( data ) {
    var form = data.form;
    var callback = data.callback;
    
    var formAction = form.action, 
      formMethod = form.method,
      ectype = form.ectype;
    var dataArray = [], 
      dataString = '', 
      dataObj = {};
    
    for ( var i = 0; i < form.elements.length; i++ ) { // Loop to gather form data from all form inputs
      var el = form.elements[i];
      if ( el.type == 'fieldset' || (el.type == 'radio' && !el.checked) )
        continue; // don't include fieldsets OR unchecked radio buttons
      var encodedData = encodeURIComponent( el.name );
      encodedData += "=";
      encodedData += encodeURIComponent( el.value );
      dataArray.push( encodedData );
    }
    dataString = dataArray.join( "&" );

    dataObj = {
      url: formAction,
      data: dataString,
      callback: callback
    };

    if ( formMethod == 'get' ) {
      dataObj.url = formAction + '?' + dataString; // format for GET
      this.get( dataObj );
    } else {
      this.post( dataObj );
    }
  }
}