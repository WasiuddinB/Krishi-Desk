<?php include('layouts/header.php'); ?>



<!--Home-->

      <section id="home">
        <div class="container">
          <h5>New Way for Farmers</h5>
          <h1><span>Best Products</span> For Farming</h1>
          <p>We offer the best price possible to help the people who provides for us.</p>
          <button>Shop Now</button>
        </div>
      </section>
      <br/>

      <!--Brand-->
      <section id="brand" class="container">
        <div class="row">
        <div class="container text-center"><h3>Few Brands We Work With</h3></div>
          <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand1.png"/>
          <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand2.png"/>
          <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand3.png"/>
          <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/brand4.png"/>
        </div>
        <br/>
      </section>
      <!--New Section-->
      <section id="new" class="w-100">
        <div class="row p-0 m-0">
          <!--One-->
          <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
            <img class="img-fluid" src="assets/imgs/exclusive1.jpg"/>
            <div class="details">
              <h2>Find Exclusive OilSeeds</h2>
              <button class="text-uppercase">Shop Now</button>
            </div>
          </div>
          <!--Two-->
          <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
            <img class="img-fluid" src="assets/imgs/exclusive2.jpg"/>
            <div class="details">
              <h2>Get your hands on John Deere Electronics</h2>
              <button class="text-uppercase">Shop Now</button>
            </div>
          </div>
          <!--Three-->
          <div class="one col-lg-4 col-md-12 col-sm-12 p-0">
            <img class="img-fluid" src="assets/imgs/exclusive3.jpg"/>
            <div class="details">
              <h2>Get yourself some proper fertilizers.</h2>
              <button class="text-uppercase">Shop Now</button>
            </div>
          </div>
        </div>
      </section>

      <!--Featured-->
      <section id="featured" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
          <h3>Our Featured</h3>
          <hr class="mx-auto">
          <p>Here are the featured products.</p>
        </div>
        <div class="row mx-auto container-fluid">

        <?php include('server/get_featured_products.php');?>

        <?php while($row=$featured_products->fetch_assoc()) {  ?>
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>"/>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
            <h4 class="p-price">Bdt. <?php echo $row['product_price'];?></h4>
            <a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
          </div>

          <?php } ?>
          

        </div>
      </section>

      <!--Banner-->
      <section id="banner" class="my-5 py-5">
        <div class="container">
          <h4>Mid Season Sale</h4>
          <h1>Vast Collection <br> Almost every products available</h1>
          <button class="text-uppercase">Shop Now</button>
        </div>
      </section>

      <!--Vegetables-->
      <section id="featured" class="my-5">
        <div class="container text-center mt-5 py-5">
          <h3>Vegetables</h3>
          <hr class="mx-auto">
          <p>Here you can check the featured products.</p>
        </div>
        <div class="row mx-auto container-fluid">

        <?php include('server/get_veg.php'); ?>

        <?php while($row=$veg_products->fetch_assoc()) { ?>
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>"/>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
            <h4 class="p-price">Bdt. <?php echo $row['product_price'];?></h4>
            <a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
          </div>

          <?php } ?>
          
        </div>
      </section>

      <!--Machines-->
      <section id="shoes" class="my-5">
        <div class="container text-center mt-5 py-5">
          <h3>Machines</h3>
          <hr class="mx-auto">
          <p>Here you can check the Machine products.</p>
        </div>


        <div class="row mx-auto container-fluid">

          <?php include('server/get_machines.php'); ?>
          <?php while($row=$machine_products->fetch_assoc()) { ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>"/>
              <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
              <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
              <h4 class="p-price">Bdt. <?php echo $row['product_price'];?></h4>
              <a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
            </div>
          <?php } ?>
        </div>
      </section>

      <!--Pesticides-->
      <section id="watches" class="my-5">
        <div class="container text-center mt-5 py-5">
          <h3>Pesticides</h3>
          <hr class="mx-auto">
          <p>Here you can check the featured products.</p>
        </div>

        <div class="row mx-auto container-fluid">

          <?php include('server/get_pesticides.php'); ?>
          <?php while($row=$pest_products->fetch_assoc()) { ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>"/>
              <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
              <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
              <h4 class="p-price">Bdt. <?php echo $row['product_price'];?></h4>
              <a href="<?php echo "single_product.php?product_id=". $row['product_id']; ?>"><button class="buy-btn">Buy Now</button></a>
            </div>
          <?php } ?>
          
        </div>
      </section>



<?php include('layouts/footer.php') ?>
