var AC_Forms = {
  allFieldsPresent: function( form ) {
    // ensure all form fields have values
    for ( var i = 0; i < form.elements.length; i++ ) {
      var name = form.elements[i].name,
        value = form.elements[i].value,
        type = form.elements[i].type;
      if ( type != 'submit' && !!name && !value ) return false; // if name is present, check the input
    }
    return true;
  },

  prevent: function( event ) {
    var e = event || window.event;
    e.preventDefault();
  },

  isValidPsid: function( form ) {
    for ( var i = 0; i < form.elements.length; i++ ) {
      if ( form.elements[i].className.indexOf( "validate-psid-input" ) > -1 ) {
        var value = form.elements[i].value;
        if ( (!isNaN( parseInt( value ) ) && value.length != 7) )
          return false;
      }
    }
    return true;
    // if input is a valid number AND its value is 7, true
  },

  init: function() {
    var forms = document.getElementsByTagName( "form" );

    for ( var i=0; i < forms.length; i++ ) {
      forms[ i ].onsubmit = function( event ) {
        if ( this.className.indexOf( 'normal-form') > -1 )
          return;
        AC_Forms.prevent( event );

        var callback = undefined;

        if ( this.id == 'log_advising_session_form' || this.id == 'advising_notes_form' || this.id == 'end_session_log_form' ) {
          callback = function( data ) {
            applyView( data.template, data ); 
            refreshCurrentStudent();
          }
        } else if ( this.id == 'delete_user_form' ) {
          callback = function( data ) {
            applyView( data.template, data ); 
            getAllUsersForSelect( 'deleteUserSelect' );
          }

        } else if ( this.className.indexOf( "validate-require-all" ) > -1 ) {
          if (!AC_Forms.allFieldsPresent( this )) {
            showNotice( "All fields required.", "error" );
            return false;
          } else {
            callback = function( data ) { applyView( data.template, data ); }
          }
        } else if ( this.className.indexOf( "validate-psid" ) > -1 ) {
          // verify PSID is 7 digits
          if (!AC_Forms.isValidPsid( this )) {
            showNotice( "PeopleSoft ID must be 7 digits.", "error" );
            return false;
          } else {
            callback = function( data ) { applyView( data.template, data ); }
          }
          
        } else {
          callback = function( data ) { applyView( data.template, data ); }
        }

        if ( this.name == 'review_course' ) {
          callback = function( data ) {
            applyView( data.template, data );
            getReviewsForUser();
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