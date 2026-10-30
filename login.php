<?php
require_once __DIR__ . '/server/init.php';
require_once __DIR__ . '/server/connection.php';

if(is_logged_in()){
    redirect('account.php');
}

$email = '';

if(isset($_POST['login_btn'])){
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email=? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    $ok = false;
    if($user){
        if(password_verify($password, $user['user_password'])){
            $ok = true;
        }else if(strlen($user['user_password']) === 32 && hash_equals($user['user_password'], md5($password))){
            // Accounts made by the old version used md5. Upgrade them on first login.
            $ok = true;
            $new_hash = password_hash($password, PASSWORD_DEFAULT);
            $up = $conn->prepare("UPDATE users SET user_password=? WHERE user_id=?");
            $up->bind_param('si', $new_hash, $user['user_id']);
            $up->execute();
        }
    }

    if($ok){
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['user_email'] = $user['user_email'];
        $_SESSION['logged_in'] = true;

        flash('success', 'Welcome back, ' . $user['user_name'] . '!');
        $next = isset($_SESSION['after_login']) ? $_SESSION['after_login'] : 'account.php';
        unset($_SESSION['after_login']);
        redirect($next);
    }

    flash('danger', 'Incorrect email or password.');
}

$page_title = 'Login';
?>
<?php include('layouts/header.php'); ?>

    <section class="section">
      <div class="container">
        <div class="auth-wrap">
          <form id="login-form" class="form-card" method="POST" action="login.php">
            <div class="text-center mb-4">
              <h3>Welcome back</h3>
              <p class="sub mb-0">Log in to manage your cart and orders.</p>
            </div>
            <div class="mb-3">
              <label for="login-email">Email</label>
              <input type="email" class="form-control" id="login-email" name="email" value="<?php echo e($email); ?>" placeholder="you@example.com" required autofocus />
            </div>
            <div class="mb-4">
              <label for="login-password">Password</label>
              <input type="password" class="form-control" id="login-password" name="password" placeholder="Your password" required />
            </div>
            <button type="submit" class="btn btn-green btn-lg w-100" id="login-btn" name="login_btn">Login</button>
            <p class="text-center mt-4 mb-0">New to KrishiDesk? <a id="register-url" href="register.php">Create an account</a></p>
          </form>
        </div>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
