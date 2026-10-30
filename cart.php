<?php
require_once __DIR__ . '/server/init.php';
require_once __DIR__ . '/server/connection.php';

if(!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

// Every action redirects back here afterwards so that refreshing the page
// does not repeat it.
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $quantity = isset($_POST['product_quantity']) ? max(1, min(99, (int)$_POST['product_quantity'])) : 1;

    if(isset($_POST['add_to_cart'])){
        // The name, image and price always come from the database, never from the form.
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        if(!$product){
            flash('danger', 'That product is no longer available.');
            redirect('shop.php');
        }

        if(isset($_SESSION['cart'][$product_id])){
            $_SESSION['cart'][$product_id]['product_quantity'] = min(99, $_SESSION['cart'][$product_id]['product_quantity'] + $quantity);
            flash('info', $product['product_name'] . ' was already in your cart, so we increased the quantity.');
        }else{
            $_SESSION['cart'][$product_id] = [
                'product_id' => $product_id,
                'product_name' => $product['product_name'],
                'product_price' => final_price($product),
                'product_image' => $product['product_image'],
                'product_quantity' => $quantity,
            ];
            flash('success', $product['product_name'] . ' was added to your cart.');
        }
        recalc_cart();

        // Send people back to where they were instead of the cart.
        $back = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $host = parse_url($back, PHP_URL_HOST);
        if($back !== '' && $host === $_SERVER['HTTP_HOST'] && strpos($back, 'cart.php') === false){
            redirect($back);
        }
        redirect('cart.php');

    }else if(isset($_POST['remove_product'])){
        unset($_SESSION['cart'][$product_id]);
        recalc_cart();
        flash('info', 'Item removed from your cart.');
        redirect('cart.php');

    }else if(isset($_POST['edit_quantity'])){
        if(isset($_SESSION['cart'][$product_id])){
            $_SESSION['cart'][$product_id]['product_quantity'] = $quantity;
            recalc_cart();
            flash('success', 'Quantity updated.');
        }
        redirect('cart.php');
    }
}

recalc_cart();
$cart = $_SESSION['cart'];
$total = $_SESSION['total'];

$page_title = 'Your Cart';
$active = 'cart';
?>
<?php include('layouts/header.php'); ?>

    <section class="page-hero">
      <div class="container">
        <h1>Your Cart</h1>
        <p>Review your items before checking out.</p>
      </div>
    </section>

    <section class="section cart">
      <div class="container">

        <?php if(empty($cart)){ ?>
          <div class="empty-state">
            <i class="fas fa-shopping-basket"></i>
            <h4>Your cart is empty</h4>
            <p>Looks like you haven't added anything yet.</p>
            <a href="shop.php" class="btn btn-green btn-lg">Start Shopping</a>
          </div>
        <?php } else { ?>
          <div class="row g-4">
            <div class="col-lg-8">
              <div class="data-card table-scroll">
                <table class="data-table">
                  <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th class="num">Subtotal</th>
                  </tr>
                  <?php foreach($cart as $item){ ?>
                  <tr>
                    <td>
                      <div class="cart-product">
                        <img src="assets/imgs/<?php echo e($item['product_image']); ?>" alt="<?php echo e($item['product_name']); ?>"/>
                        <div>
                          <p><a href="single_product.php?product_id=<?php echo (int)$item['product_id']; ?>"><?php echo e($item['product_name']); ?></a></p>
                          <small><?php echo money($item['product_price']); ?> each</small>
                          <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo (int)$item['product_id']; ?>"/>
                            <button type="submit" name="remove_product" class="link-danger-soft"><i class="fas fa-trash-alt"></i> Remove</button>
                          </form>
                        </div>
                      </div>
                    </td>
                    <td>
                      <form method="POST" action="cart.php" class="qty-form">
                        <input type="hidden" name="product_id" value="<?php echo (int)$item['product_id']; ?>"/>
                        <input type="number" name="product_quantity" class="qty-input" value="<?php echo (int)$item['product_quantity']; ?>" min="1" max="99" aria-label="Quantity"/>
                        <button type="submit" name="edit_quantity" class="btn btn-outline-green btn-sm">Update</button>
                      </form>
                    </td>
                    <td class="num"><strong><?php echo money($item['product_quantity'] * $item['product_price']); ?></strong></td>
                  </tr>
                  <?php } ?>
                </table>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="summary-card">
                <h5 class="mb-3">Order Summary</h5>
                <div class="row-line"><span>Items</span><span><?php echo (int)$_SESSION['quantity']; ?></span></div>
                <div class="row-line total"><span>Total</span><span><?php echo money($total); ?></span></div>
                <a href="checkout.php" class="btn btn-green btn-lg w-100 mt-3">Proceed to Checkout</a>
                <a href="shop.php" class="btn btn-link w-100 mt-1">Continue shopping</a>
              </div>
            </div>
          </div>
        <?php } ?>

      </div>
    </section>

<?php include('layouts/footer.php'); ?>
