<?php
require_once __DIR__ . '/server/init.php';
require_once __DIR__ . '/server/connection.php';

$name = '';
$email = '';
$message = '';

if(isset($_POST['send_message'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if($name === '' || $message === ''){
        flash('danger', 'Please enter your name and a message.');
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        flash('danger', 'Please enter a valid email address.');
    }else{
        $conn->query("CREATE TABLE IF NOT EXISTS `contact_messages` (
            `message_id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `email` varchar(100) NOT NULL,
            `message` text NOT NULL,
            `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`message_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $stmt = $conn->prepare("INSERT INTO contact_messages(name,email,message) VALUES (?,?,?)");
        $stmt->bind_param('sss', $name, $email, $message);

        if($stmt->execute()){
            flash('success', 'Thanks ' . $name . '! Your message has been sent.');
            redirect('contact.php');
        }
        flash('danger', 'Sorry, we could not send your message. Please try again.');
    }
}

$page_title = 'Contact Us';
$active = 'contact';
?>
<?php include('layouts/header.php'); ?>

    <section class="page-hero">
      <div class="container">
        <h1>Contact Us</h1>
        <p>Questions about an order or a product? We would love to help.</p>
      </div>
    </section>

    <section id="contact" class="section">
      <div class="container">
        <div class="row g-5">
          <div class="col-lg-5">
            <h3 class="mb-4">Get in touch</h3>
            <div class="contact-info">
              <div class="icon"><i class="fas fa-user"></i></div>
              <div><h6>Name</h6><p><?php echo e(SITE_OWNER); ?></p></div>
            </div>
            <div class="contact-info">
              <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
              <div><h6>Address</h6><p><?php echo e(SITE_ADDRESS); ?></p></div>
            </div>
            <div class="contact-info">
              <div class="icon"><i class="fas fa-phone"></i></div>
              <div><h6>Phone</h6><p><?php echo e(SITE_PHONE); ?></p></div>
            </div>
            <div class="contact-info">
              <div class="icon"><i class="fas fa-envelope"></i></div>
              <div><h6>Email</h6><p><?php echo e(SITE_EMAIL); ?></p></div>
            </div>
          </div>

          <div class="col-lg-7">
            <form class="form-card" method="POST" action="contact.php">
              <h3>Send us a message</h3>
              <p class="sub">We usually reply within a day.</p>
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="contact-name">Your name</label>
                  <input type="text" class="form-control" id="contact-name" name="name" value="<?php echo e($name); ?>" required />
                </div>
                <div class="col-md-6">
                  <label for="contact-email">Email</label>
                  <input type="email" class="form-control" id="contact-email" name="email" value="<?php echo e($email); ?>" required />
                </div>
                <div class="col-12">
                  <label for="contact-message">Message</label>
                  <textarea class="form-control" id="contact-message" name="message" rows="5" required><?php echo e($message); ?></textarea>
                </div>
              </div>
              <button type="submit" name="send_message" class="btn btn-green btn-lg mt-4">Send Message</button>
            </form>
          </div>
        </div>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
