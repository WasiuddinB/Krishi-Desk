<!-- <!DOCTYPE html>
<html>
  <head>
    <title>Tutorial</title>
  </head>
  <body> -->

  <?php include('layouts/header.php') ?>

    <section id="videos" class="container mt-5 py-5">
      <div class="row">
        <div class="container text-center mt-3 py-3"><h3>Here are some Tutorial videos</h3></div>
        <hr class="mx-auto">
      <!-- <h1>Tutorial Videos</h1> -->
          <?php
            echo '<video width="640" height="360" controls>';
            echo '<source src="assets/videos/sample_1.mp4" type="video/mp4">';
            echo '<source src="assets/videos/sample_2.mp4" type="video/mp4">';
            echo 'Your browser does not support the video tag.';
            echo '</video>';
            echo '<br/>';
          ?>
          <?php
            echo '<video width="640" height="360" controls>';
            echo '<source src="assets/videos/sample_2.mp4" type="video/mp4">';
            echo 'Your browser does not support the video tag.';
            echo '</video>';
            echo '<br/>';
          ?>
          <?php
            echo '<video width="640" height="360" controls>';
            echo '<source src="assets/videos/sample_3.mp4" type="video/mp4">';
            echo 'Your browser does not support the video tag.';
            echo '</video>';
          ?>
        </div>
        <br/>
    </section>


<?php include('layouts/footer.php') ?>
  <!-- </body>
</html> -->
