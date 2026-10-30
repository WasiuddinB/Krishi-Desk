<?php
require_once __DIR__ . '/server/init.php';

if(empty($_SESSION['cart'])){
    flash('info', 'Your cart is empty. Add something first.');
    redirect('shop.php');
}

recalc_cart();
$cart = $_SESSION['cart'];
$logged_in = is_logged_in();

// Remember where to come back to after logging in.
if(!$logged_in){
    $_SESSION['after_login'] = 'checkout.php';
}

$page_title = 'Checkout';
$active = 'cart';
?>
<?php include('layouts/header.php'); ?>

    <section class="page-hero">
      <div class="container">
        <h1>Checkout</h1>
        <p>Tell us where to deliver your order.</p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="row g-4">

          <div class="col-lg-7">
            <?php if(!$logged_in){ ?>
              <div class="form-card text-center">
                <i class="fas fa-lock fa-2x text-success mb-3"></i>
                <h3>Please log in to continue</h3>
                <p class="sub">You need an account to place and track your orders. Your cart will be waiting for you.</p>
                <a href="login.php" class="btn btn-green btn-lg me-2">Login</a>
                <a href="register.php" class="btn btn-outline-green btn-lg">Create account</a>
              </div>
            <?php } else { ?>
              <form id="checkout-form" class="form-card" method="POST" action="server/place_order.php">
                <h3>Delivery details</h3>
                <p class="sub">We will use these details to deliver your order.</p>
                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="checkout-name">Name</label>
                    <input type="text" class="form-control" id="checkout-name" name="name" value="<?php echo e($_SESSION['user_name']); ?>" required />
                  </div>
                  <div class="col-md-6">
                    <label for="checkout-email">Email</label>
                    <input type="email" class="form-control" id="checkout-email" name="email" value="<?php echo e($_SESSION['user_email']); ?>" required />
                  </div>
                  <div class="col-md-6">
                    <label for="checkout-phone">Phone number</label>
                    <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="01XXXXXXXXX" pattern="[0-9+\- ]{7,20}" title="Enter a valid phone number" required />
                  </div>
                  <div class="col-md-6">
                    <label for="checkout-city">City</label>
                    <input type="text" class="form-control" id="checkout-city" name="city" placeholder="Dhaka" required />
                  </div>
                  <div class="col-12">
                    <label for="checkout-address">Address</label>
                    <input type="text" class="form-control" id="checkout-address" name="address" placeholder="House, road, area" required />
                  </div>
                </div>
                <button type="submit" class="btn btn-green btn-lg w-100 mt-4" id="checkout-btn" name="place_order">Place Order</button>
              </form>
            <?php } ?>
          </div>

          <div class="col-lg-5">
            <div class="summary-card">
              <h5 class="mb-3">Your order</h5>
              <?php foreach($cart as $item){ ?>
                <div class="cart-product mb-3">
                  <img src="assets/imgs/<?php echo e($item['product_image']); ?>" alt=""/>
                  <div class="flex-grow-1">
                    <p><?php echo e($item['product_name']); ?></p>
                    <small><?php echo (int)$item['product_quantity']; ?> &times; <?php echo money($item['product_price']); ?></small>
                  </div>
                  <strong><?php echo money($item['product_quantity'] * $item['product_price']); ?></strong>
                </div>
              <?php } ?>
              <div class="row-line total"><span>Total</span><span><?php echo money($_SESSION['total']); ?></span></div>
              <a href="cart.php" class="btn btn-link w-100 mt-2">Edit cart</a>
            </div>
          </div>

        </div>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
