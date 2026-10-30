<?php
require_once __DIR__ . '/server/init.php';

$page_title = 'Tutorials';
$active = 'tutorials';

$videos = [
    ['Tutorial 1', 'assets/videos/sample_1.mp4', 'A short walkthrough of modern farming practice.'],
    ['Tutorial 2', 'assets/videos/sample_2.mp4', 'Practical tips you can apply on your own land.'],
    ['Tutorial 3', 'assets/videos/sample_3.mp4', 'Getting the most from your tools and crops.'],
];
?>
<?php include('layouts/header.php'); ?>

    <section class="page-hero">
      <div class="container">
        <h1>Farming Tutorials</h1>
        <p>Watch and learn at your own pace.</p>
      </div>
    </section>

    <section id="videos" class="section">
      <div class="container">
        <div class="row g-4">
          <?php foreach($videos as $video){ ?>
          <div class="col-lg-4 col-md-6">
            <div class="video-card">
              <video controls preload="metadata">
                <source src="<?php echo e($video[1]); ?>" type="video/mp4">
                Your browser does not support the video tag.
              </video>
              <div class="video-body">
                <h5><?php echo e($video[0]); ?></h5>
                <p><?php echo e($video[2]); ?></p>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
