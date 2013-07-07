<aside class="well">
  <h4 class="title">Current Report</h4>

  <div class="media">
    <a class="pull-left" href="#">
      <img class="media-object img-circle" src="{ gravatar }" />
    </a>
    <div class="media-body">
      <h4 class="media-heading">{ full_name }</h4>
      { user_id }
    </div>
  </div>

  <br>

  <p>
    <strong>PeopleSoft #:</strong>{ psid }
  </p>
  <p>
    <strong>Email:</strong>{ email }
  </p>
  <p>
    <strong>Courses Taken:</strong>{ total_courses_taken }
  </p>
  <p>
    <strong>GPA:</strong>{ gpa }
  </p>

  
    <form action="routes.php" method="post" name="log_advising_session_form">
      <button class="btn btn-block btn-primary" type="submit" name="log_advising_session_form_submit">
        <i class="icon icon-edit"></i>&nbsp;
        Log advising session
      </button>
    </form>
  
    <p class="text-success">Logging current advising session</p>
    <a href="routes.php?action=end_session_log" class="btn btn-block btn-primary">
      <i class="icon icon-remove-sign"></i>&nbsp;
      Stop logging session
    </a>
  


  <a href="advisor.php" class="btn btn-block btn-primary">
    <i class="icon icon-chevron-left"></i>&nbsp;
    Back to search
  </a>

</aside>
<aside class="well">
  <h4 class="title">Session Notes</h4>
  Please log your session before adding notes.
  <form action="routes.php" method="post" name="advising_notes_form">
    <input type="hidden" value="{ logging_session_id }" name="session_id" />
    <textarea class="input-block-level" name="note_content" rows="11" placeholder="Notes"></textarea>
    <button class="btn btn-block btn-primary" type="submit" name="advising_notes_form_submit">
      <i class="icon icon-plus-sign"></i>&nbsp;
      Add notes to current session
    </button>
  </form>
</aside>