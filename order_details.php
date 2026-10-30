<?php
require_once __DIR__ . '/server/init.php';
require_once __DIR__ . '/server/connection.php';

require_login('account.php');

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$user_id = (int)$_SESSION['user_id'];

// Only the owner can see an order.
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id=? AND user_id=?");
$stmt->bind_param('ii', $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if(!$order){
    flash('danger', 'We could not find that order.');
    redirect('account.php#orders');
}

$stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id=?");
$stmt->bind_param('i', $order_id);
$stmt->execute();
$items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$page_title = 'Order #' . $order_id;
$active = 'account';
$is_unpaid = ($order['order_status'] === 'not paid');
?>
<?php include('layouts/header.php'); ?>

    <section class="page-hero">
      <div class="container">
        <h1>Order #<?php echo (int)$order['order_id']; ?></h1>
        <p>Placed on <?php echo e(date('j M Y, g:i a', strtotime($order['order_date']))); ?></p>
      </div>
    </section>

    <section class="section orders">
      <div class="container">
        <div class="row g-4">
          <div class="col-lg-8">
            <div class="data-card table-scroll">
              <table class="data-table">
                <tr>
                  <th>Product</th>
                  <th class="num">Price</th>
                  <th class="num">Quantity</th>
                  <th class="num">Subtotal</th>
                </tr>
                <?php foreach($items as $row){ ?>
                <tr>
                  <td>
                    <div class="cart-product">
                      <img src="assets/imgs/<?php echo e($row['product_image']); ?>" alt=""/>
                      <p><?php echo e($row['product_name']); ?></p>
                    </div>
                  </td>
                  <td class="num"><?php echo money($row['product_price']); ?></td>
                  <td class="num"><?php echo (int)$row['product_quantity']; ?></td>
                  <td class="num"><?php echo money($row['product_price'] * $row['product_quantity']); ?></td>
                </tr>
                <?php } ?>
              </table>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="summary-card">
              <h5 class="mb-3">Summary</h5>
              <div class="row-line"><span>Status</span>
                <span class="status <?php echo $is_unpaid ? 'status-unpaid' : 'status-paid'; ?>"><?php echo e($order['order_status']); ?></span>
              </div>
              <div class="row-line"><span>Deliver to</span><span class="text-end"><?php echo e($order['user_address']); ?>, <?php echo e($order['user_city']); ?></span></div>
              <div class="row-line"><span>Phone</span><span><?php echo e($order['user_phone']); ?></span></div>
              <div class="row-line total"><span>Total</span><span><?php echo money($order['order_cost']); ?></span></div>
              <?php if($is_unpaid){ ?>
                <a href="payment.php?order_id=<?php echo (int)$order['order_id']; ?>" class="btn btn-green btn-lg w-100 mt-3">Pay Now</a>
              <?php } ?>
              <a href="account.php#orders" class="btn btn-link w-100 mt-1">Back to my orders</a>
            </div>
          </div>
        </div>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
