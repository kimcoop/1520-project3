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

  getData: function() {
    var xmlHttp = this.create();
    xmlHttp.open( 'get', this.getUrl(), true );
    xmlHttp.send(null);
    xmlHttp.onreadystatechange = function() {
      if (xmlHttp.readyState === 4) {
        if (xmlHttp.status === 200) {
          alert(xmlHttp.responseText);
        } else {
          alert('Error: ' + xmlHttp.responseText);
        }
      } else {
        console.log( 'loading' );
      }
    };
  },

  postData: function( url, data, callback ) {
    var xmlHttp = this.create();
    xmlHttp.open( 'post', url, true );
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlHttp.send( data );
    xmlHttp.onreadystatechange = function() {
      if ( xmlHttp.readyState === 4 ) {
        if ( xmlHttp.status === 200 ) {
          callback( JSON.parse( xmlHttp.responseText ) );
        } else {
          alert('Error: ' + xmlHttp.responseText);
        }
      } else {
        console.log( 'loading' );
      }
    };
  },

  postForm: function( form ) {
    var formAction = form.action, formMethod = form.method;
    console.log( formAction, formMethod );
    var dataArray = [], dataString = '';
    
    for ( var i = 0; i < form.elements.length; i++ ) { // Loop to gather form data from all form inputs
      var encodedData = encodeURIComponent( form.elements[i].name );
      encodedData += "=";
      encodedData += encodeURIComponent( form.elements[i].value );
      dataArray.push( encodedData );
    }
    console.debug (dataArray);
    dataString = dataArray.join( "&" );
    this.postData( formAction, dataString, function( data ) {
      console.log( 'callback!');
      console.debug( data );
    });
  }
}

