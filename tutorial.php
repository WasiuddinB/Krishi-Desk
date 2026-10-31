<?php
require_once __DIR__ . '/server/init.php';

$page_title = 'Videos';
$active = 'tutorials';

// Only list videos that really exist. To add a video, copy it into assets/videos
// and add an entry here: file, title, short description of what it shows.
$videos = [
    ['assets/videos/sample_1.mp4', 'Crops and wind turbines', 'Aerial footage of a crop field with wind turbines on the horizon.'],
    ['assets/videos/sample_2.mp4', 'Wheat in the wind', 'A close-up of ripening wheat moving in the breeze.'],
    ['assets/videos/sample_3.mp4', 'Flock on pasture', 'A drone view of a flock of sheep moving across grazing land.'],
];
?>
<?php include('layouts/header.php'); ?>

    <section class="page-hero">
      <div class="container">
        <h1>Farm Videos</h1>
        <p>Footage from the field. Step-by-step how-to videos are coming soon.</p>
      </div>
    </section>

    <section id="videos" class="section">
      <div class="container">
        <div class="row g-4">
          <?php foreach($videos as $video){ ?>
          <div class="col-lg-4 col-md-6">
            <div class="video-card">
              <video controls preload="metadata">
                <source src="<?php echo e($video[0]); ?>" type="video/mp4">
                Your browser does not support the video tag.
              </video>
              <div class="video-body">
                <h5><?php echo e($video[1]); ?></h5>
                <p><?php echo e($video[2]); ?></p>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
        <p class="text-center text-muted mt-5 mb-0">Looking for advice? Read our <a href="blog.php">farming guides</a>.</p>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
