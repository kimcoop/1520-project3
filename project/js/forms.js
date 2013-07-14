var forms = {

  init: function() {
    var forms = document.getElementsByTagName( "form" );

    for ( var i=0; i < forms.length; i++ ) {
      forms[ i ].onsubmit = function( event ) {
        if ( this.id == 'signin_form' || this.className.indexOf( 'normal-form') > -1 )
          return;
        var callback = undefined;
        var e = event || window.event;
        e.preventDefault();
        if ( this.id == 'log_advising_session_form' || this.id == 'advising_notes_form' || this.id == 'end_session_log_form' ) {
          callback = function( data ) {
            applyView( data.template, data ); 
            refreshCurrentStudent();
          }
          // callback = function( data ) { 
          //   applyView( data.template, data );
          //   showHeader( data ); 
          // }
        } else if ( this.id == 'search_student_form' ) {
          // verify PSID is 7 digits
          for ( var i = 0; i < this.elements.length; i++ ) {
            if ( this.elements[i].name == 'student_search_term' ) {
              var value = this.elements[i].value;
              if ( !isNaN( parseInt( value ) ) && value.length != 7 ) { // it's a PSID (not first name - last name)
                showNotice( "PeopleSoft ID must be 7 digits.", "error" );
                return false;
              } else {
                callback = function( data ) {
                  applyView( data.template, data );
                }
              }
            }
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