var xmlHttp = {

  create: function() {
    var xmlHttp = null;
    //if XMLHttpRequest is available then creating and returning it
    if (typeof(XMLHttpRequest) != undefined) {
      return new XMLHttpRequest;
    //if window.ActiveXObject is available than the user is using IE...so we have to create the newest version XMLHttp object
    } else if (window.ActiveXObject) {
      var ieXMLHttpVersions = ['MSXML2.XMLHttp.5.0', 'MSXML2.XMLHttp.4.0', 'MSXML2.XMLHttp.3.0', 'MSXML2.XMLHttp', 'Microsoft.XMLHttp'];
      //In this array we are starting from the first element (newest version) and trying to create it. If there is an
      //exception thrown we are handling it (and doing nothing ^^)
      for (var i = 0; i < ieXMLHttpVersions.length; i++) {
        try {
            xmlHttp = new ActiveXObject(ieXMLHttpVersions[i]);
            return xmlHttp;
        } catch (e) {
        }
      }
    }
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
            alert( 'error parsing JSON data (console)' );
            // console.debug( data );
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
        async = dataObj.async || true, 
        callback = dataObj.callback;

    var xmlHttp = this.create();
    xmlHttp.open( 'post', url, async );
    xmlHttp.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded" );
    xmlHttp.send( data );
    xmlHttp.onreadystatechange = function() {
      if ( xmlHttp.readyState === 4 ) {
        if ( xmlHttp.status === 200 ) {
          var data = xmlHttp.responseText;
          try {
            data = JSON.parse( data );
          } catch ( error ) {
            alert( 'error parsing JSON data (console)' );
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

  submitForm: function( form ) {
    var formAction = form.action, 
      formMethod = form.method;
    var dataArray = [], 
      dataString = '', 
      dataObj = {};
    
    for ( var i = 0; i < form.elements.length; i++ ) { // Loop to gather form data from all form inputs
      var encodedData = encodeURIComponent( form.elements[i].name );
      encodedData += "=";
      encodedData += encodeURIComponent( form.elements[i].value );
      dataArray.push( encodedData );
    }
    dataString = dataArray.join( "&" );
    console.log('form data: ' +dataString);

    dataObj = {
      url: formAction,
      data: dataString,
      callback: function( data ) {
        applyView( data.template, data );
        if ( form.name == 'signin_form' ) {
          showHeader( data );
        }
      }
    };

    if ( formMethod == 'get' ) {
      dataObj.url = formAction + '?' + dataString; // format for GET
      this.get( dataObj );
    } else {
      this.post( dataObj );
    }
  }
}
