
        </div> <!-- #main -->
      <div class="push"></div>
  </div><!-- .container.main -->

    <footer>
    <div class="container">
      <p class="text-center">
        <?php
          $format = '%1$s %2$s %3$s. All Rights Reserved.';
          echo sprintf( $format, '&copy;', date('Y'), 'AdvisorCloud' );
        ?>
      </p>
    </div>
  </footer>

  <script src="js/xmlHttpHandler.js"></script>
  <script src="js/simpleTemplate.js"></script>
  <script src="js/tabs.js"></script>
  <script src="js/user.js"></script>
  <script src="js/links.js"></script>
  <script src="js/forms.js"></script>
  <script src="js/main.js"></script>
  
  <script type="text/html" id="course_tmpl"><?php include( 'templates/course.html'); ?></script>
  <script type="text/html" id="student_tmpl"><?php include( 'templates/student.html'); ?></script>
  <script type="text/html" id="notice_tmpl"><?php include( 'templates/notice.html'); ?></script>
  <script type="text/html" id="review_table_tmpl"><?php include( 'templates/reviews.html'); ?></script>

  </body>
</html>