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
    ['Fresh Vegetables', 'Straight from the field to your kitchen.', 'vegetable'],
    ['Farm Machines', 'Tractors, tillers, pumps and sprayers to ease the work.', 'machine'],
    ['Pesticides', 'Protect your crops from pests and disease.', 'pesticide'],
];
?>
<?php include('layouts/header.php'); ?>

      <!--Home-->
      <section id="home">
        <div class="container">
          <div class="row align-items-center g-5">
            <div class="col-lg-6">
              <span class="kicker"><i class="fas fa-seedling"></i> New way for farmers</span>
              <h1><span>Best Products</span> For Farming</h1>
              <p class="lead">Seeds, vegetables, machines and crop care at fair prices. We help the people who feed us grow more and spend less.</p>
              <a href="shop.php" class="btn btn-green btn-lg me-2">Shop Now</a>
              <a href="tutorial.php" class="btn btn-outline-green btn-lg">Watch Tutorials</a>
              <div class="hero-stats">
                <div><strong>15+</strong><span>Products</span></div>
                <div><strong>4</strong><span>Categories</span></div>
                <div><strong>24/7</strong><span>Online ordering</span></div>
              </div>
            </div>
            <div class="col-lg-6 text-center text-lg-end">
              <div class="hero-img d-inline-block">
                <img src="assets/imgs/back2.png" alt="A farmer checking crop moisture on a phone"/>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!--Features-->
      <section class="section pb-0">
        <div class="container">
          <div class="row g-4">
            <div class="col-lg-3 col-sm-6">
              <div class="feature"><div class="icon"><i class="fas fa-truck"></i></div><h5>Delivery to your door</h5><p>We bring orders to your farm or home.</p></div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="feature"><div class="icon"><i class="fas fa-tags"></i></div><h5>Fair prices</h5><p>Honest pricing with regular offers.</p></div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="feature"><div class="icon"><i class="fas fa-play-circle"></i></div><h5>Learn as you grow</h5><p>Free video tutorials for modern farming.</p></div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div class="feature"><div class="icon"><i class="fas fa-cloud-sun-rain"></i></div><h5>Weather forecast</h5><p>Check local weather before you plan.</p></div>
            </div>
          </div>
        </div>
      </section>

      <!--Brands-->
      <section id="brand" class="section">
        <div class="container">
          <div class="section-head">
            <span class="eyebrow">Trusted names</span>
            <h2>Popular Brands in Agriculture</h2>
          </div>
          <div class="brand-row">
            <img src="assets/imgs/brand2.png" alt="Bayer"/>
            <img src="assets/imgs/brand3.png" alt="Syngenta"/>
            <img src="assets/imgs/brand4.png" alt="John Deere"/>
          </div>
        </div>
      </section>

      <!--Explore categories-->
      <section class="section section-alt">
        <div class="container">
          <div class="section-head">
            <span class="eyebrow">Explore</span>
            <h2>Shop By Need</h2>
          </div>
          <div class="row g-4">
            <div class="col-lg-4 col-md-6">
              <a class="promo" href="shop.php?category=fertilizer">
                <img src="assets/imgs/exclusive1.jpg" alt="Oil palm fruit and oil"/>
                <div class="details"><h3>Find Exclusive Oil Seeds</h3><span class="go">Shop now <i class="fas fa-arrow-right"></i></span></div>
              </a>
            </div>
            <div class="col-lg-4 col-md-6">
              <a class="promo" href="shop.php?category=fertilizer">
                <img src="assets/imgs/exclusive3.jpg" alt="A seedling being fed with fertilizer"/>
                <div class="details"><h3>Get Proper Fertilizers</h3><span class="go">Shop now <i class="fas fa-arrow-right"></i></span></div>
              </a>
            </div>
            <div class="col-lg-4 col-md-12">
              <a class="promo" href="shop.php?category=vegetable">
                <img src="assets/imgs/tomato2.jpg" alt="Fresh red tomatoes"/>
                <div class="details"><h3>Farm Fresh Vegetables</h3><span class="go">Shop now <i class="fas fa-arrow-right"></i></span></div>
              </a>
            </div>
          </div>
        </div>
      </section>

      <!--Latest-->
      <section class="section">
        <div class="container">
          <div class="section-head">
            <span class="eyebrow">Just in</span>
            <h2>Our Featured Products</h2>
            <p>Hand-picked products our customers love.</p>
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
      <section class="pb-5">
        <div class="container">
          <div id="banner">
            <h4>Mid Season Sale</h4>
            <h2>Vast collection, almost every farming product available</h2>
            <a href="shop.php" class="btn btn-light-green btn-lg">Browse the Shop</a>
          </div>
        </div>
      </section>

      <!--Category sections-->
      <?php foreach($sections as $i => $section){ ?>
      <section class="section <?php echo $i % 2 === 0 ? 'section-alt' : ''; ?>">
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
