<?php
require_once __DIR__ . '/server/init.php';
require_once __DIR__ . '/server/connection.php';

$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param('i', $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if(!$product){
    flash('warning', 'Sorry, that product could not be found.');
    redirect('shop.php');
}

$price = final_price($product);
$offer = (int)$product['product_special_offer'];

// Only show each distinct image once in the gallery.
$images = array_values(array_unique(array_filter([
    $product['product_image'],
    $product['product_image2'],
    $product['product_image3'],
    $product['product_image4'],
])));

// Related products from the same category.
$stmt = $conn->prepare("SELECT * FROM products WHERE product_category=? AND product_id<>? ORDER BY product_id LIMIT 4");
$stmt->bind_param('si', $product['product_category'], $product_id);
$stmt->execute();
$related = $stmt->get_result();

$page_title = $product['product_name'];
$active = 'shop';
?>
<?php include('layouts/header.php'); ?>

    <section class="section">
      <div class="container">
        <nav class="breadcrumb-lite">
          <a href="index.php">Home</a> / <a href="shop.php">Shop</a> /
          <a href="shop.php?category=<?php echo e($product['product_category']); ?>"><?php echo e(category_label($product['product_category'])); ?></a> /
          <?php echo e($product['product_name']); ?>
        </nav>

        <div class="row g-5">
          <div class="col-lg-5 col-md-6">
            <div class="main-img-wrap">
              <img id="mainImg" src="assets/imgs/<?php echo e($images[0]); ?>" alt="<?php echo e($product['product_name']); ?>"/>
            </div>
            <?php if(count($images) > 1){ ?>
            <div class="small-img-group">
              <?php foreach($images as $i => $img){ ?>
              <div class="small-img-col">
                <img src="assets/imgs/<?php echo e($img); ?>" class="small-img <?php if($i === 0){echo 'selected';} ?>" alt="<?php echo e($product['product_name']); ?> view <?php echo $i + 1; ?>"/>
              </div>
              <?php } ?>
            </div>
            <?php } ?>
          </div>

          <div class="col-lg-7 col-md-6">
            <span class="product-cat"><?php echo e(category_label($product['product_category'])); ?></span>
            <h1 class="h2 mt-1 mb-3"><?php echo e($product['product_name']); ?></h1>
            <div class="price-big mb-3">
              <?php echo money($price); ?>
              <?php if($offer > 0){ ?><s><?php echo money($product['product_price']); ?></s> <span class="badge-offer position-static ms-2"><?php echo $offer; ?>% off</span><?php } ?>
            </div>

            <p class="text-muted"><?php echo e($product['product_description']); ?></p>

            <form method="POST" action="cart.php" class="d-flex align-items-center flex-wrap gap-3 my-4">
              <input type="hidden" name="product_id" value="<?php echo (int)$product['product_id']; ?>"/>
              <input type="number" name="product_quantity" class="qty-input" value="1" min="1" max="99" aria-label="Quantity"/>
              <button class="btn btn-green btn-lg" type="submit" name="add_to_cart"><i class="fas fa-cart-plus"></i> Add to Cart</button>
              <a href="shop.php" class="btn btn-outline-green btn-lg">Keep Shopping</a>
            </form>

            <ul class="list-unstyled text-muted small">
              <li><i class="fas fa-check text-success me-2"></i>Delivered to your door</li>
              <li><i class="fas fa-check text-success me-2"></i>Secure checkout</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <?php if($related->num_rows > 0){ ?>
    <section id="related-products" class="section section-alt">
      <div class="container">
        <div class="section-head">
          <h2>Related Products</h2>
          <p>More from <?php echo e(category_label($product['product_category'])); ?>.</p>
        </div>
        <div class="row g-4">
          <?php while($row = $related->fetch_assoc()){ product_card($row); } ?>
        </div>
      </div>
    </section>
    <?php } ?>

<?php include('layouts/footer.php'); ?>
