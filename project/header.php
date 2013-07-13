<?php require_once('functions.php') ?>

<header>
  <div class="container nav-container">
    <ul class="nav nav-pills pull-right" id="nav">
      <li class="">
        <a href="#" class="link-home">Welcome, <?php current_user()->get_full_name() ?></a>
      </li>
      
      <?php if ( current_user()->is_admin() ) { ?>
        <li>
          <a href="#" id="link-admin" data="admin.html">Admin</a>
        </li>
      <?php } ?>
      
      <li class="">
        <a href="#" id="link-settings">Settings</a>
      </li>

      <li>
        <a href="routes.php?action=logout" id="link-logout">Logout</a>
      </li>

    </ul>
    <h3 class="title muted">
      <a href="#" class="link-home">Advisor Cloud 3.0</a>
    </h3>
  </div><!-- .container -->
</header>