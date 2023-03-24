<?php
include('server/connection.php');
if(isset($_GET['product_id'])){
  $product_id=$_GET['product_id'];
  $stmt=$conn->prepare("SELECT * FROM products WHERE product_id = ?");
  $stmt->bind_param("i",$product_id);
  $stmt->execute();
  $product=$stmt->get_result();
}else{
  header('location: index.php');
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>


    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
        <!--NavBar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
      <div class="container">
        <img class="logo" src="assets/imgs/logo22.png"/>
        <h2 class="brand">কৃষিDesk</h2>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            
            <li class="nav-item">
              <a class="nav-link" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shop.html">Shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Blog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact Us</a>
            </li>
          </li>

          <li class="nav-item">
            <a href="cart.html"><i class="fas fa-shopping-bag"></i></a>
            <a href="account.html"><i class="fas fa-user"></i></a>
          </li>
            
          </ul>
          
        </div>
      </div>
    </nav>

          <!--Single Product-->
          <section class="container single-product my-5 pt-5">
            <div class="row mt-5">
              <?php while($row=$product->fetch_assoc()) {?>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <img class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo $row['product_image']; ?>" id="mainImg"/>
                    <div class="small-img-group">
                        <div class="small-img-col">
                            <img src="assets/imgs/<?php echo $row['product_image']; ?>" width="100%" class="small-img"/>
                        </div>
                        <div class="small-img-col">
                            <img src="assets/imgs/<?php echo $row['product_image2']; ?>" width="100%" class="small-img"/>
                        </div>
                        <div class="small-img-col">
                            <img src="assets/imgs/<?php echo $row['product_image3']; ?>" width="100%" class="small-img"/>
                        </div>
                        <div class="small-img-col">
                            <img src="assets/imgs/<?php echo $row['product_image4']; ?>" width="100%" class="small-img"/>
                        </div>
                    </div>
                </div>
                


                <div class="col-lg-6 col-md-12 col-sm-12">
                  <h6>Farming1/Farming2</h6>
                  <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
                  <h2>Bdt.<?php echo $row['product_price']; ?></h2>
                  <input type="number" value="1"/>
                  <button class="buy-btn">Add To Cart</button>
                  <h4 class="mt-5 mb-5">Product Details</h4>
                  <span><?php echo $row['product_description']; ?></span>

                </div>

                <?php } ?>

            </div>
          </section>

          <!--Related Products-->
      <section id="related-products" class="my-5 pb-5">
        <div class="container text-center mt-5 py-5">
          <h3>Related Products</h3>
          <hr class="mx-auto">
          <p>Here are some related products.</p>
        </div>
        <div class="row mx-auto container-fluid">
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/back.jpg"/>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name">FARMING STUFF</h5>
            <h4 class="p-price">Bdt.200.00</h4>
            <button class="buy-btn">Buy Now</button>
          </div>
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/back.jpg"/>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name">FARMING STUFF</h5>
            <h4 class="p-price">Bdt.200.00</h4>
            <button class="buy-btn">Buy Now</button>
          </div>
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/back.jpg"/>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name">FARMING STUFF</h5>
            <h4 class="p-price">Bdt.200.00</h4>
            <button class="buy-btn">Buy Now</button>
          </div>
          <div class="product text-center col-lg-3 col-md-4 col-sm-12">
            <img class="img-fluid mb-3" src="assets/imgs/back.jpg"/>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name">FARMING STUFF</h5>
            <h4 class="p-price">Bdt.200.00</h4>
            <button class="buy-btn">Buy Now</button>
          </div>
        </div>
      </section>











        <!--Footer-->
        <footer class="mt-5 py-5">
        <div class="row container mx-auto pt-5">
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <img src="assets/imgs/logo22.png"/>
            <p class="pt-3">We provide the best products for you</p>
          </div>
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">Featured</h5>
            <ul class="text-uppercase">
              <li><a href="#">TS</a></li>
              <li><a href="#">TS</a></li>
              <li><a href="#">TS</a></li>
              <li><a href="#">TS</a></li>
              <li><a href="#">new arrivals</a></li>
            </ul>
          </div>
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">Contact Us</h5>
            <div>
              <h6 class="text-uppercase">Address</h6>
              <p>1234 Street name,City</p>
            </div>
            <div>
              <h6 class="text-uppercase">Phone</h6>
              <p>12345678910</p>
            </div>
            <div>
              <h6 class="text-uppercase">Email</h6>
              <p>info@gmail.com</p>
            </div>
          </div>
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">Instagram</h5>
            <div class="row">
              <img src="assets/imgs/logo" class="img-fluid w-25 h-100 m-2"/>
              <img src="assets/imgs/logo" class="img-fluid w-25 h-100 m-2"/>
              <img src="assets/imgs/logo" class="img-fluid w-25 h-100 m-2"/>
              <img src="assets/imgs/logo" class="img-fluid w-25 h-100 m-2"/>
              <img src="assets/imgs/logo" class="img-fluid w-25 h-100 m-2"/>
            </div>
          </div>
        </div>
        <div class="copyright mt-5">
          <div class="row container mx-auto">
            <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
              <img src="assets/imgs/payment.jpg"/>
            </div>
            <div class="col-lg-3 col-md-5 col-sm-12 mb-4 text-nowrap mb-2">
              <p>Wasi-UB @ 2023 All rights reserved</p>
            </div>
            <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
        </div>
            </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script>

      var mainImg = document.getElementById("mainImg");
      var smallImg = document.getElementsByClassName("small-img");

      for(let i=0; i<4;i++){
          smallImg[i].onclick = function(){
          mainImg.src = smallImg[i].src;
        }
      }
      


    </script>
</body>
</html>