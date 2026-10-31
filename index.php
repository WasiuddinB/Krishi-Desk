<?php
require_once __DIR__ . '/server/init.php';
require_once __DIR__ . '/server/connection.php';

$page_title = 'Home';
$active = 'home';

// Fetch one row-set of products for a home page section.
function home_products($conn, $category = null, $limit = 4){
    if($category === null){
        $stmt = $conn->prepare("SELECT * FROM products ORDER BY product_id DESC LIMIT ?");
        $stmt->bind_param('i', $limit);
    }else{
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_category=? ORDER BY product_id LIMIT ?");
        $stmt->bind_param('si', $category, $limit);
    }
    $stmt->execute();
    return $stmt->get_result();
}

$sections = [
    ['Fresh Vegetables', 'Sold by the kilogram.', 'vegetable'],
    ['Farm Machines', 'Equipment for tilling, irrigation and spraying.', 'machine'],
    ['Pesticides', 'Crop-protection products. Always read the label before use.', 'pesticide'],
];
?>
<?php include('layouts/header.php'); ?>

      <!--Home-->
      <section id="home">
        <div class="container">
          <div class="row align-items-center g-5">
            <div class="col-lg-6">
              <span class="kicker"><i class="fas fa-seedling"></i> From seed to harvest</span>
              <h1>Everything your farm needs, <span>from seed to harvest.</span></h1>
              <p class="lead">Find essential seeds, fertilizers, crop-care products and farm equipment in one place. Straightforward shopping for the people who grow our food.</p>
              <a href="shop.php" class="btn btn-green btn-lg me-2 mb-2">Shop Farm Essentials</a>
              <a href="blog.php" class="btn btn-outline-green btn-lg mb-2">Explore Farming Guides</a>
            </div>
            <div class="col-lg-6 text-center text-lg-end">
              <div class="hero-img d-inline-block">
                <img src="assets/imgs/site/hero-farmer.jpg" alt="A farmer working in a paddy field in Bangladesh"/>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!--What you can do here-->
      <section class="section pb-0">
        <div class="container">
          <div class="row g-4">
            <div class="col-lg-3 col-sm-6">
              <div class="feature"><div class="icon"><i class="fas fa-th-large"></i></div><h5>Shop by category</h5><p>Vegetables, machines, crop care and fertilizers, each in its own section.</p></div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="feature"><div class="icon"><i class="fas fa-shopping-cart"></i></div><h5>Order online</h5><p>Add to cart, check out and follow every order from your account.</p></div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="feature"><div class="icon"><i class="fas fa-book-open"></i></div><h5>Farming guides</h5><p>Practical reading on land preparation, crop care and safe machine use.</p></div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="feature"><div class="icon"><i class="fas fa-cloud-sun-rain"></i></div><h5>Weather forecast</h5><p>A five-day forecast for your district, with notes for field work.</p></div>
            </div>
          </div>
        </div>
      </section>

      <!--Explore categories-->
      <section class="section">
        <div class="container">
          <div class="section-head">
            <span class="eyebrow">Shop by need</span>
            <h2>Start with what the field needs</h2>
          </div>
          <div class="row g-4">
            <div class="col-lg-4 col-md-6">
              <a class="promo" href="shop.php?category=vegetable">
                <img src="assets/imgs/site/promo-vegetables.jpg" alt="Fresh vegetables at a market" loading="lazy"/>
                <div class="details"><h3>Fresh vegetables</h3><span class="go">Shop vegetables <i class="fas fa-arrow-right"></i></span></div>
              </a>
            </div>
            <div class="col-lg-4 col-md-6">
              <a class="promo" href="shop.php?category=machine">
                <img src="assets/imgs/site/promo-machinery.jpg" alt="Farm machinery at work in a field" loading="lazy"/>
                <div class="details"><h3>Farm machinery</h3><span class="go">Shop machines <i class="fas fa-arrow-right"></i></span></div>
              </a>
            </div>
            <div class="col-lg-4 col-md-12">
              <a class="promo" href="shop.php?category=pesticide">
                <img src="assets/imgs/site/promo-cropcare.jpg" alt="A farmer applying a crop-care treatment" loading="lazy"/>
                <div class="details"><h3>Crop care</h3><span class="go">Shop crop care <i class="fas fa-arrow-right"></i></span></div>
              </a>
            </div>
          </div>
        </div>
      </section>

      <!--Latest-->
      <section class="section section-alt">
        <div class="container">
          <div class="section-head">
            <span class="eyebrow">New in the shop</span>
            <h2>Recently added</h2>
            <p>The latest products added to KrishiDesk.</p>
          </div>
          <div class="row g-4">
            <?php
              $latest = home_products($conn, null, 4);
              while($row = $latest->fetch_assoc()){ product_card($row); }
            ?>
          </div>
        </div>
      </section>

      <!--Banner-->
      <section class="section pb-0">
        <div class="container">
          <div id="banner">
            <h4>Check before you spray</h4>
            <h2>See the five-day forecast for your district before you plan field work</h2>
            <a href="weather_forecast.php" class="btn btn-light-green btn-lg">Open the forecast</a>
          </div>
        </div>
      </section>

      <!--Category sections-->
      <?php foreach($sections as $i => $section){ ?>
      <section class="section <?php echo $i % 2 === 1 ? 'section-alt' : ''; ?>">
        <div class="container">
          <div class="section-head">
            <h2><?php echo e($section[0]); ?></h2>
            <p><?php echo e($section[1]); ?></p>
          </div>
          <div class="row g-4">
            <?php
              $items = home_products($conn, $section[2], 4);
              while($row = $items->fetch_assoc()){ product_card($row); }
            ?>
          </div>
          <div class="text-center mt-4">
            <a href="shop.php?category=<?php echo e($section[2]); ?>" class="btn btn-outline-green">View all <?php echo e(strtolower($section[0])); ?></a>
          </div>
        </div>
      </section>
      <?php } ?>

<?php include('layouts/footer.php'); ?>
