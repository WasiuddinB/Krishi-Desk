<?php
require_once __DIR__ . '/server/init.php';
require_once __DIR__ . '/server/connection.php';

require_login('account.php');

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$user_id = (int)$_SESSION['user_id'];

// An order can only be paid by the person who placed it.
$stmt = $conn->prepare("SELECT order_id, order_cost, order_status FROM orders WHERE order_id=? AND user_id=?");
$stmt->bind_param('ii', $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if(!$order){
    flash('danger', 'We could not find that order.');
    redirect('account.php#orders');
}

$is_paid = ($order['order_status'] === 'paid');

$page_title = 'Payment';
$active = 'account';
?>
<?php include('layouts/header.php'); ?>

    <section class="page-hero">
      <div class="container">
        <h1>Payment</h1>
        <p>Order #<?php echo (int)$order['order_id']; ?></p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="auth-wrap">
          <div class="form-card text-center">
            <?php if($is_paid){ ?>
              <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
              <h3>This order is already paid</h3>
              <p class="sub">Thank you! We are getting your order ready.</p>
              <a href="account.php#orders" class="btn btn-green btn-lg">View my orders</a>
            <?php } else { ?>
              <h3>Total to pay</h3>
              <p class="price-big my-3"><?php echo money($order['order_cost']); ?></p>

              <form method="POST" action="server/confirm_payment.php" class="text-start">
                <input type="hidden" name="order_id" value="<?php echo (int)$order['order_id']; ?>"/>
                <label for="method">Payment method</label>
                <select class="form-select mb-3" name="method" id="method" required>
                  <option value="bkash">bKash</option>
                  <option value="nagad">Nagad</option>
                  <option value="card">Credit / Debit card</option>
                  <option value="cod">Cash on delivery</option>
                </select>
                <div class="alert alert-warning small">
                  <i class="fas fa-info-circle"></i> This is a demo store. No real money is charged.
                </div>
                <button type="submit" name="pay" class="btn btn-green btn-lg w-100">Pay <?php echo money($order['order_cost']); ?></button>
              </form>
            <?php } ?>
          </div>
        </div>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
