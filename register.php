<?php
require_once __DIR__ . '/server/init.php';
require_once __DIR__ . '/server/connection.php';

if(is_logged_in()){
    redirect('account.php');
}

$name = '';
$email = '';

if(isset($_POST['register'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    $error = '';

    if($name === ''){
        $error = 'Please enter your name.';
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = 'Please enter a valid email address.';
    }else if($password !== $confirmPassword){
        $error = 'Passwords do not match.';
    }else if(strlen($password) < 6){
        $error = 'Password must be at least 6 characters.';
    }else{
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE user_email=?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($num_rows);
        $stmt->fetch();
        $stmt->close();

        if($num_rows != 0){
            $error = 'A user with this email already exists.';
        }
    }

    if($error === ''){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users(user_name,user_email,user_password) VALUES (?,?,?)");
        $stmt->bind_param('sss', $name, $email, $hash);

        if($stmt->execute()){
            session_regenerate_id(true);
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;
            $_SESSION['logged_in'] = true;

            flash('success', 'Account created. Welcome to KrishiDesk, ' . $name . '!');
            $next = isset($_SESSION['after_login']) ? $_SESSION['after_login'] : 'account.php';
            unset($_SESSION['after_login']);
            redirect($next);
        }
        $error = 'We could not create your account. Please try again.';
    }

    flash('danger', $error);
}

$page_title = 'Register';
?>
<?php include('layouts/header.php'); ?>

    <section class="section">
      <div class="container">
        <div class="auth-wrap">
          <form id="register-form" class="form-card" method="POST" action="register.php">
            <div class="text-center mb-4">
              <h3>Create your account</h3>
              <p class="sub mb-0">It only takes a minute.</p>
            </div>
            <div class="mb-3">
              <label for="register-name">Name</label>
              <input type="text" class="form-control" id="register-name" name="name" value="<?php echo e($name); ?>" placeholder="Your full name" required autofocus />
            </div>
            <div class="mb-3">
              <label for="register-email">Email</label>
              <input type="email" class="form-control" id="register-email" name="email" value="<?php echo e($email); ?>" placeholder="you@example.com" required />
            </div>
            <div class="mb-3">
              <label for="register-password">Password</label>
              <input type="password" class="form-control" id="register-password" name="password" placeholder="At least 6 characters" minlength="6" required />
            </div>
            <div class="mb-4">
              <label for="register-confirm-password">Confirm password</label>
              <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Repeat your password" required />
            </div>
            <button type="submit" class="btn btn-green btn-lg w-100" id="register-btn" name="register">Register</button>
            <p class="text-center mt-4 mb-0">Already have an account? <a id="login-url" href="login.php">Login</a></p>
          </form>
        </div>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
