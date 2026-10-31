<?php
require_once __DIR__ . '/server/init.php';
require_once __DIR__ . '/server/connection.php';

$page_title = 'Shop';
$active = 'shop';

$categories = [
    'all' => 'All products',
    'vegetable' => 'Vegetables',
    'machine' => 'Machines',
    'pesticide' => 'Pesticides',
    'fertilizer' => 'Fertilizers & Seeds',
];
$price_ranges = [
    'any' => ['Any price', null, null],
    'u500' => ['Under Bdt. 500', 0, 500],
    'r500' => ['Bdt. 500 - 5,000', 500, 5000],
    'r5000' => ['Bdt. 5,000 - 50,000', 5000, 50000],
    'o50000' => ['Above Bdt. 50,000', 50000, null],
];
$sorts = [
    'new' => ['Newest first', 'product_id DESC'],
    'low' => ['Price: low to high', 'product_price ASC'],
    'high' => ['Price: high to low', 'product_price DESC'],
    'name' => ['Name: A to Z', 'product_name ASC'],
];

// Read the filters from the URL (so filtering and paging share one set of links).
$category = isset($_GET['category']) && isset($categories[$_GET['category']]) ? $_GET['category'] : 'all';
$price = isset($_GET['price']) && isset($price_ranges[$_GET['price']]) ? $_GET['price'] : 'any';
$sort = isset($_GET['sort']) && isset($sorts[$_GET['sort']]) ? $_GET['sort'] : 'new';
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$page_no = isset($_GET['page_no']) ? max(1, (int)$_GET['page_no']) : 1;

$where = [];
$types = '';
$params = [];

if($category !== 'all'){
    $where[] = 'product_category = ?';
    $types .= 's';
    $params[] = $category;
}
if($price_ranges[$price][1] !== null){
    $where[] = 'product_price >= ?';
    $types .= 'd';
    $params[] = $price_ranges[$price][1];
}
if($price_ranges[$price][2] !== null){
    $where[] = 'product_price < ?';
    $types .= 'd';
    $params[] = $price_ranges[$price][2];
}
if($q !== ''){
    $where[] = '(product_name LIKE ? OR product_description LIKE ?)';
    $types .= 'ss';
    $like = '%' . $q . '%';
    $params[] = $like;
    $params[] = $like;
}
$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$stmt = $conn->prepare("SELECT COUNT(*) FROM products $where_sql");
if($params){ $stmt->bind_param($types, ...$params); }
$stmt->execute();
$stmt->bind_result($total_records);
$stmt->fetch();
$stmt->close();

$per_page = 8;
$total_pages = max(1, (int)ceil($total_records / $per_page));
if($page_no > $total_pages){ $page_no = $total_pages; }
$offset = ($page_no - 1) * $per_page;

$order_sql = $sorts[$sort][1];
$stmt = $conn->prepare("SELECT * FROM products $where_sql ORDER BY $order_sql LIMIT $offset, $per_page");
if($params){ $stmt->bind_param($types, ...$params); }
$stmt->execute();
$products = $stmt->get_result();

// Build a link that keeps the current filters but changes the page.
function shop_link($page){
    $query = $_GET;
    $query['page_no'] = $page;
    return 'shop.php?' . http_build_query($query);
}
?>
<?php include('layouts/header.php'); ?>

    <section class="page-hero">
      <div class="container">
        <h1>Our Shop</h1>
        <p>Vegetables, farm machines, crop care and fertilizers.</p>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="row g-4">

          <!--Filters-->
          <div class="col-lg-3">
            <form class="filter-card" action="shop.php" method="GET">
              <h5>Search &amp; Filter</h5>

              <label class="form-label small">Keyword</label>
              <input type="text" class="form-control mb-3" name="q" value="<?php echo e($q); ?>" placeholder="e.g. tomato, sprayer"/>

              <label class="form-label small">Category</label>
              <?php foreach($categories as $key => $label){ ?>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="category" value="<?php echo e($key); ?>" id="cat_<?php echo e($key); ?>" <?php if($category === $key){echo 'checked';} ?>/>
                <label class="form-check-label" for="cat_<?php echo e($key); ?>"><?php echo e($label); ?></label>
              </div>
              <?php } ?>

              <label class="form-label small mt-3" for="price">Price</label>
              <select class="form-select mb-3" name="price" id="price">
                <?php foreach($price_ranges as $key => $range){ ?>
                <option value="<?php echo e($key); ?>" <?php if($price === $key){echo 'selected';} ?>><?php echo e($range[0]); ?></option>
                <?php } ?>
              </select>

              <label class="form-label small" for="sort">Sort by</label>
              <select class="form-select mb-4" name="sort" id="sort">
                <?php foreach($sorts as $key => $s){ ?>
                <option value="<?php echo e($key); ?>" <?php if($sort === $key){echo 'selected';} ?>><?php echo e($s[0]); ?></option>
                <?php } ?>
              </select>

              <button type="submit" class="btn btn-green w-100">Apply</button>
              <a href="shop.php" class="btn btn-link w-100 mt-1">Clear filters</a>
            </form>
          </div>

          <!--Products-->
          <div class="col-lg-9">
            <p class="text-muted mb-3">
              Showing <strong><?php echo $total_records; ?></strong> product<?php echo $total_records == 1 ? '' : 's'; ?>
              <?php if($category !== 'all'){ ?> in <strong><?php echo e($categories[$category]); ?></strong><?php } ?>
              <?php if($q !== ''){ ?> matching &ldquo;<?php echo e($q); ?>&rdquo;<?php } ?>
            </p>

            <?php if($total_records == 0){ ?>
              <div class="empty-state">
                <i class="fas fa-search"></i>
                <h4>No products found</h4>
                <p>Try a different keyword or clear the filters.</p>
                <a href="shop.php" class="btn btn-green">See all products</a>
              </div>
            <?php } else { ?>
              <div class="row g-4">
                <?php while($row = $products->fetch_assoc()){ product_card($row, 'col-xl-4 col-md-6 col-12'); } ?>
              </div>

              <?php if($total_pages > 1){ ?>
              <nav aria-label="Product pages">
                <ul class="pagination justify-content-center mt-5">
                  <li class="page-item <?php if($page_no <= 1){echo 'disabled';} ?>">
                    <a class="page-link" href="<?php echo $page_no <= 1 ? '#' : e(shop_link($page_no - 1)); ?>">Previous</a>
                  </li>
                  <?php for($i = 1; $i <= $total_pages; $i++){ ?>
                  <li class="page-item <?php if($i == $page_no){echo 'active';} ?>">
                    <a class="page-link" href="<?php echo e(shop_link($i)); ?>"><?php echo $i; ?></a>
                  </li>
                  <?php } ?>
                  <li class="page-item <?php if($page_no >= $total_pages){echo 'disabled';} ?>">
                    <a class="page-link" href="<?php echo $page_no >= $total_pages ? '#' : e(shop_link($page_no + 1)); ?>">Next</a>
                  </li>
                </ul>
              </nav>
              <?php } ?>
            <?php } ?>
          </div>

        </div>
      </div>
    </section>

<?php include('layouts/footer.php'); ?>
