var forms = {

  init: function() {
    var forms = document.getElementsByTagName( "form" );

    for ( var i=0; i < forms.length; i++ ) {
      forms[ i ].onsubmit = function( event ) {
        var callback = undefined;
        var e = event || window.event;
        e.preventDefault();
        if ( this.id == 'log_advising_session_form' || this.id == 'advising_notes_form' || this.id == 'end_session_log_form' ) {
          callback = function( data ) {
            applyView( data.template, data ); 
            refreshCurrentStudent();
          }
        } else if ( this.id == 'signin_form' ) {
          callback = function( data ) { 
            applyView( data.template, data );
            showHeader( data ); 
          }
        } else {
          callback = function( data ) {
            applyView( data.template, data );
          }
        }
        xmlHttp.submitForm({ 
          form: this, 
          callback: callback
        });
      }
    }
  }

}