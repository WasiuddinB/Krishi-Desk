<?php
require_once __DIR__ . '/server/init.php';

$page_title = 'Farming Guides';
$active = 'blog';

// To add a guide, add another entry here: image, label, title, intro, list of tips.
$posts = [
    [
        'assets/imgs/site/blog-land-preparation.jpg',
        'Before planting',
        'Preparing land for planting',
        'Good land preparation helps seeds come up evenly and keeps early weeds down.',
        [
            'Plough or till to loosen the soil and break up large clods.',
            'Remove weeds and old crop residue before sowing or transplanting.',
            'Level the field so water spreads evenly.',
            'Check drainage before the rains so water does not stand on young plants.',
            'Ask your local Department of Agricultural Extension (DAE) office about the right timing for your crop and area.',
        ],
    ],
    [
        'assets/imgs/site/blog-pesticide-safety.jpg',
        'Crop care',
        'Handling pesticides safely',
        'Pesticides protect crops, but they can harm people, animals and water if used carelessly.',
        [
            'Read the whole label before you buy and before every use.',
            'Wear gloves, long sleeves, a mask and eye protection when mixing and spraying.',
            'Mix only what you need, and do not spray in strong wind or just before rain.',
            'Do not eat, drink or smoke while spraying. Wash your hands and clothes afterwards.',
            'Store products in their original container, locked away from children and food.',
            'Never reuse empty containers for food or water.',
        ],
    ],
    [
        'assets/imgs/site/blog-power-tiller.jpg',
        'Machinery',
        'Using a power tiller safely',
        'A power tiller saves a lot of work, but the blades and engine need respect.',
        [
            'Read the operating manual before the first use.',
            'Check fuel, oil, blades and guards before starting.',
            'Wear sturdy shoes and avoid loose clothing that could catch.',
            'Keep children and animals away from the working area.',
            'Switch the engine off before clearing the blades, and let it cool before refuelling.',
        ],
    ],
];
?>
<?php include('layouts/header.php'); ?>

    <section class="page-hero">
      <div class="container">
        <h1>Farming Guides</h1>
        <p>Short, practical reading for the field.</p>
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
                <p><?php echo e($post[3]); ?></p>
                <ul class="post-tips">
                  <?php foreach($post[4] as $tip){ ?><li><?php echo e($tip); ?></li><?php } ?>
                </ul>
              </div>
            </article>
          </div>
          <?php } ?>
        </div>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
