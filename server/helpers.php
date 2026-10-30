<?php

// Small helpers shared by every page.

// Escape text before printing it into HTML.
function e($value){
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

// Format a number as Bangladeshi Taka.
function money($amount){
    return 'Bdt. ' . number_format((float)$amount, 2);
}

// Queue a one-time message that is shown as a toast on the next page.
// $type is one of: success, danger, warning, info.
function flash($type, $message){
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

// Take all queued messages (and clear them).
function pull_flash(){
    $messages = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
    unset($_SESSION['flash']);
    return $messages;
}

function redirect($url){
    header('Location: ' . $url);
    exit;
}

function is_logged_in(){
    return !empty($_SESSION['logged_in']);
}

// Send guests to the login page and bring them back afterwards.
function require_login($return_to = 'account.php'){
    if(!is_logged_in()){
        $_SESSION['after_login'] = $return_to;
        flash('warning', 'Please log in to continue.');
        redirect('login.php');
    }
}

// Price after the product's special offer (a percentage off) is applied.
function final_price($product){
    $price = (float)$product['product_price'];
    $offer = (int)$product['product_special_offer'];
    if($offer > 0 && $offer < 100){
        $price = round($price * (100 - $offer) / 100, 2);
    }
    return $price;
}

function category_label($category){
    $labels = [
        'vegetable' => 'Vegetables',
        'machine' => 'Machines',
        'pesticide' => 'Pesticides',
        'fertilizer' => 'Fertilizers & Seeds',
    ];
    return isset($labels[$category]) ? $labels[$category] : ucfirst($category);
}

// Recalculate cart totals stored in the session (used by the cart badge).
function recalc_cart(){
    $total = 0;
    $quantity = 0;
    if(!empty($_SESSION['cart'])){
        foreach($_SESSION['cart'] as $item){
            $total += $item['product_price'] * $item['product_quantity'];
            $quantity += $item['product_quantity'];
        }
    }
    $_SESSION['total'] = $total;
    $_SESSION['quantity'] = $quantity;
}

// Print one product card. $row is a row from the products table.
function product_card($row, $col = 'col-xl-3 col-lg-4 col-md-6 col-12'){
    $price = final_price($row);
    $offer = (int)$row['product_special_offer'];
    $url = 'single_product.php?product_id=' . (int)$row['product_id'];
    ?>
    <div class="<?php echo $col; ?> d-flex">
      <div class="product-card w-100">
        <a href="<?php echo $url; ?>" class="product-media">
          <img src="assets/imgs/<?php echo e($row['product_image']); ?>" alt="<?php echo e($row['product_name']); ?>" loading="lazy"/>
          <?php if($offer > 0){ ?><span class="badge-offer">-<?php echo $offer; ?>%</span><?php } ?>
        </a>
        <div class="product-body">
          <span class="product-cat"><?php echo e(category_label($row['product_category'])); ?></span>
          <h5 class="p-name"><a href="<?php echo $url; ?>"><?php echo e($row['product_name']); ?></a></h5>
          <div class="p-price">
            <?php echo money($price); ?>
            <?php if($offer > 0){ ?><s><?php echo money($row['product_price']); ?></s><?php } ?>
          </div>
          <div class="product-actions">
            <a class="btn btn-outline-green btn-sm" href="<?php echo $url; ?>">Details</a>
            <form method="POST" action="cart.php">
              <input type="hidden" name="product_id" value="<?php echo (int)$row['product_id']; ?>"/>
              <input type="hidden" name="product_quantity" value="1"/>
              <button type="submit" name="add_to_cart" class="btn btn-green btn-sm"><i class="fas fa-cart-plus"></i> Add</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php
}

?>
