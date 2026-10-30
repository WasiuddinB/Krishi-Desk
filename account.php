<?php
require_once __DIR__ . '/server/init.php';
require_once __DIR__ . '/server/connection.php';

if(isset($_GET['logout'])){
    if(is_logged_in()){
        unset($_SESSION['logged_in'], $_SESSION['user_id'], $_SESSION['user_email'], $_SESSION['user_name']);
        session_regenerate_id(true);
        flash('info', 'You have been logged out.');
    }
    redirect('login.php');
}

require_login('account.php');

$user_id = (int)$_SESSION['user_id'];

if(isset($_POST['change_password'])){
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if($password !== $confirmPassword){
        flash('danger', 'Passwords do not match.');
    }else if(strlen($password) < 6){
        flash('danger', 'Password must be at least 6 characters.');
    }else{
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_id=?");
        $stmt->bind_param('si', $hash, $user_id);

        if($stmt->execute()){
            flash('success', 'Your password has been updated.');
        }else{
            flash('danger', 'Could not update your password.');
        }
    }
    redirect('account.php');
}

$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY order_id DESC");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$initial = mb_strtoupper(mb_substr($_SESSION['user_name'], 0, 1));
$page_title = 'My Account';
$active = 'account';
?>
<?php include('layouts/header.php'); ?>

    <section class="page-hero">
      <div class="container">
        <h1>My Account</h1>
        <p>Manage your details and track your orders.</p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="row g-4">
          <div class="col-lg-5">
            <div class="form-card account-box h-100">
              <div class="avatar"><?php echo e($initial); ?></div>
              <h3><?php echo e($_SESSION['user_name']); ?></h3>
              <p class="sub"><?php echo e($_SESSION['user_email']); ?></p>
              <a href="#orders" id="order-btn" class="btn btn-outline-green me-1">My Orders</a>
              <a href="account.php?logout=1" id="logout-btn" class="btn btn-outline-danger">Logout</a>
            </div>
          </div>

          <div class="col-lg-7">
            <form id="account-form" class="form-card h-100" method="POST" action="account.php">
              <h3>Change password</h3>
              <p class="sub">Choose a new password for your account.</p>
              <div class="mb-3">
                <label for="account-password">New password</label>
                <input type="password" class="form-control" id="account-password" name="password" placeholder="At least 6 characters" minlength="6" required/>
              </div>
              <div class="mb-4">
                <label for="account-password-confirm">Confirm new password</label>
                <input type="password" class="form-control" id="account-password-confirm" name="confirmPassword" placeholder="Repeat the password" required/>
              </div>
              <button type="submit" name="change_password" class="btn btn-green" id="change-pass-btn">Change Password</button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!--Orders-->
    <section id="orders" class="section section-alt orders">
      <div class="container">
        <div class="section-head">
          <h2>My Orders</h2>
        </div>

        <?php if(empty($orders)){ ?>
          <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <h4>No orders yet</h4>
            <p>When you place an order it will show up here.</p>
            <a href="shop.php" class="btn btn-green">Go to the shop</a>
          </div>
        <?php } else { ?>
          <div class="data-card table-scroll">
            <table class="data-table">
              <tr>
                <th>Order</th>
                <th>Date</th>
                <th>Status</th>
                <th class="num">Total</th>
                <th class="num">Actions</th>
              </tr>
              <?php foreach($orders as $row){ $unpaid = ($row['order_status'] === 'not paid'); ?>
              <tr>
                <td>#<?php echo (int)$row['order_id']; ?></td>
                <td><?php echo e(date('j M Y', strtotime($row['order_date']))); ?></td>
                <td><span class="status <?php echo $unpaid ? 'status-unpaid' : 'status-paid'; ?>"><?php echo e($row['order_status']); ?></span></td>
                <td class="num"><?php echo money($row['order_cost']); ?></td>
                <td class="num">
                  <a class="btn btn-outline-green btn-sm" href="order_details.php?order_id=<?php echo (int)$row['order_id']; ?>">Details</a>
                  <?php if($unpaid){ ?><a class="btn btn-green btn-sm" href="payment.php?order_id=<?php echo (int)$row['order_id']; ?>">Pay</a><?php } ?>
                </td>
              </tr>
              <?php } ?>
            </table>
          </div>
        <?php } ?>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
