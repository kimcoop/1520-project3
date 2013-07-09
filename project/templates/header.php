<div class="container nav-container">
  <ul class="nav nav-pills pull-right">
    <li class="">
      <a href="#">
        Welcome, <%= current_user.full_name %>
      </a>
    </li>
    
    <li class="<%= ( current_user.is_admin ? "" : "hidden" ) %>">
      <a href="admin.php">Admin</a>
    </li>  
    
    <li class="">
      <a href="settings.php">Settings</a>
    </li>

    <li>
      <a href="routes.php?action=logout">Logout</a>
    </li>
    
  </ul>
  <h3 class="title muted">
    <a href="#">
    Advisor Cloud 3.0
    </a>
  </h3>
</div><!-- .container -->
