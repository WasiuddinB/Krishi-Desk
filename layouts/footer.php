    </main>

    <!--Footer-->
    <footer class="site-footer">
        <div class="row container mx-auto pt-5 g-4">
            <div class="footer-one col-lg-4 col-md-6 col-12">
                <div class="d-flex align-items-center mb-3">
                    <img src="assets/imgs/logo22.png" alt="KrishiDesk logo"/>
                    <span class="footer-brand">কৃষি<span>Desk</span></span>
                </div>
                <p><?php echo e(SITE_TAGLINE); ?></p>
            </div>
            <div class="footer-one col-lg-2 col-md-6 col-6">
                <h5 class="pb-2">Shop</h5>
                <ul>
                    <li><a href="shop.php?category=vegetable">Vegetables</a></li>
                    <li><a href="shop.php?category=machine">Machines</a></li>
                    <li><a href="shop.php?category=pesticide">Pesticides</a></li>
                    <li><a href="shop.php?category=fertilizer">Fertilizers &amp; Seeds</a></li>
                </ul>
            </div>
            <div class="footer-one col-lg-2 col-md-6 col-6">
                <h5 class="pb-2">Explore</h5>
                <ul>
                    <li><a href="tutorial.php">Tutorials</a></li>
                    <li><a href="blog.php">Blog</a></li>
                    <li><a href="weather_forecast.php">Weather</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-one col-lg-4 col-md-6 col-12">
                <h5 class="pb-2">Contact Us</h5>
                <p class="mb-1"><i class="fas fa-map-marker-alt"></i> <?php echo e(SITE_ADDRESS); ?></p>
                <p class="mb-1"><i class="fas fa-phone"></i> <?php echo e(SITE_PHONE); ?></p>
                <p class="mb-1"><i class="fas fa-envelope"></i> <?php echo e(SITE_EMAIL); ?></p>
            </div>
        </div>
        <div class="copyright mt-5">
            <div class="row container mx-auto align-items-center g-3">
                <div class="col-lg-4 col-md-12">
                    <img class="pay-img" src="assets/imgs/payment.jpg" alt="Accepted payment methods"/>
                </div>
                <div class="col-lg-4 col-md-6 text-lg-center">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php echo e(SITE_NAME); ?> &middot; Built by <?php echo e(SITE_OWNER); ?></p>
                </div>
                <div class="col-lg-4 col-md-6 text-md-end">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        function googleTranslateElementInit(){
            new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,bn', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
        }
    </script>
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>
    <script src="assets/js/app.js"></script>
</body>
</html>
