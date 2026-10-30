<?php
require_once __DIR__ . '/server/init.php';

$page_title = 'Blog';
$active = 'blog';

$posts = [
    ['assets/imgs/exclusive3.jpg', 'Soil health', 'Feeding your crops: a simple guide to fertilizer', 'Nitrogen, phosphorus and potassium each do a different job. Learn when to apply them and how much, so your plants grow strong without wasting money.'],
    ['assets/imgs/tomato.jpg', 'Vegetables', 'Growing better tomatoes at home or on the farm', 'From choosing a sunny spot to staking and watering, these habits help you get bigger, juicier tomatoes season after season.'],
    ['assets/imgs/back2.png', 'Smart farming', 'Using your phone to farm smarter', 'Weather forecasts, moisture checks and market prices are now a tap away. Here is how small farms can use simple tools to save water and time.'],
    ['assets/imgs/exclusive1.jpg', 'Oil crops', 'Why oil palm and oilseeds are worth a look', 'Oilseed crops can add a steady second income. We explain what they need to thrive and what to expect at harvest.'],
    ['assets/imgs/carrot.jpg', 'Vegetables', 'Root vegetables 101: carrots and potatoes', 'Loose soil, even watering and the right harvest time make all the difference for root crops. Start with these basics.'],
    ['assets/imgs/back.jpg', 'Technology', 'Smart agriculture explained in plain words', 'Sensors, drones and data sound complicated, but the idea is simple: give each plant exactly what it needs. See how it works.'],
];
?>
<?php include('layouts/header.php'); ?>

    <section class="page-hero">
      <div class="container">
        <h1>The KrishiDesk Blog</h1>
        <p>Tips, guides and ideas for growing more.</p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="row g-4">
          <?php foreach($posts as $post){ ?>
          <div class="col-lg-4 col-md-6">
            <article class="post-card">
              <img src="<?php echo e($post[0]); ?>" alt="<?php echo e($post[2]); ?>" loading="lazy"/>
              <div class="post-body">
                <span class="meta"><?php echo e($post[1]); ?></span>
                <h5 class="mt-1"><?php echo e($post[2]); ?></h5>
                <p class="mb-0"><?php echo e($post[3]); ?></p>
              </div>
            </article>
          </div>
          <?php } ?>
        </div>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
