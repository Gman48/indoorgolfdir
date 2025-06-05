<!-- === Footer original === -->
<footer>
	<div class="container footer-container">
		<div data-aos="zoom-in" class="footer-columns">
			<div class="ft-col">
				<div class="footer-logo logo-sm text-center">
					<!-- <span>IG.dir</span> -->
					<img src="<?=ROOT?>/assets/images/IGDlogo.png">
				</div>
				<p class="idg-info">The Indoor Golf Directory is one of the most comprehensive directories on the internet for Indoor Golf facilities in North America.  Our process ensures that the information presented in our directory is accurate and up to date ensuring the best user experience for you.</p>
			</div>

			<div data-aos="zoom-in" class="col sales-box"> 
				<h3 class="footer-title">Do your own an Indoor Golf facility that is not listed in our directory?<br></h3>
				<span>email <a href="mailto:info@indoorgolfdir.com">info@indoorgolfdir.com</a></span>
				<h3 class="footer-title">Would you like your listing to be a featured listing?</h3>
				<span>Contact us at <a href="mailto:sales@indoorgolfdir.com">sales@indoorgolfdir.com</a></span></span>
			</div>

			<div data-aos="zoom-in" class="links"> 
				<h3 class="ft-links-title">Page Links</h3>
				<ul class="footer-links">
					<li class="ft-nav-item">
                    	<a href="<?=ROOT?>/home" class="ft-nav-link">Home</a>
                	</li>
					<li class="ft-nav-item">
						<a href="<?=ROOT?>/#country" class="ft-nav-link">Canada</a>
					</li>
					<li class="ft-nav-item">
						<a href="<?=ROOT?>/#country" class="ft-nav-link">United States</a>
					</li>
					<!-- <li class="ft-nav-item">
						<a href="#" class="ft-nav-link">Blog</a>
					</li> -->
					<!-- <li class="ft-nav-item">
						<a href="#" class="ft-nav-link">About Us</a>
					</li> -->
					<li class="ft-nav-item">
						<a href="<?=ROOT?>/admin" class="ft-nav-link">Admin</a>
					</li>
					<!-- only show login if not already logged in -->
					<?php if(!logged_in()):?>  
					<li class="ft-nav-item">
						<a href="<?=ROOT?>/login" class="ft-nav-link">Login</a>
					</li>
					<?php endif;?>
				</ul>

				<div class="search-footer">
					<span>Quick search</span>
					<form action="search" method="POST">
						<input type="text" name="search" placeholder="facility name or city">
						<button class="btn btn-dark" type="submit" name="submit-search">Search</button>
					</form>
				</div>
			</div>

			<!-- <div data-aos="zoom-in" class="col" class="company"> 
				<h3 class="footer-title">Visit our other Directory sites</h3>
				<ul class="footer-links">
					<li class="ft-nav-item">
                    	<a href="#" class="ft-nav-link">RV parks</a>
                	</li>
					<li class="ft-nav-item">
						<a href="#" class="ft-nav-link">Dog Parks</a>
					</li>
					<li class="ft-nav-item">
						<a href="#" class="ft-nav-link">Public Golf Courses</a>
					</li>
				</ul>
			</div> -->

			<!-- <ul class="social-icons"> 
				<li><div class="fa fa-facebook"></div></li>
				<li><div class="fa fa-twitter"></div></li>
				<li><div class="fa fa-github"></div></li>
				<li><div class="fa fa-youtube"></div></li>
			</ul> -->
			
		</div>
	</div>

	<hr class="divider">
	<div class="copyright">
		<p>Copyright @<?=date("Y")?> The Indoor Golf Directory</p>
		<p>Web Design and Development by <a href="https://ez-webs.com">ez-webs.com</a></p>
	</div>
</footer>



<!-- ================== AOS ================== -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script> 
	AOS.init({
		duration:1600,
	});
</script>

<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<!-- scripts from Ecom site to ensure owl works -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!-- Owl Carousel Js file -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha256-pTxD+DSzIwmwhOqTFN+DB+nHjO4iAsbgfyFq5K5bcE0=" crossorigin="anonymous"></script> -->

<!--  isotope plugin cdn  -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha256-CBrpuqrMhXwcLLUd5tvQ4euBHCdh7wGlDfNz8vbu/iI=" crossorigin="anonymous"></script> -->

<!-- END scripts from Ecom site to ensure owl works -->


<!-- Scripts for swiper carousel  -->
<!-- <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> -->

<!-- Swipper JS code for slides-->
<!-- <script>
let swiperCards = new Swiper('.card__content', {
    loop: true,
    spaceBetween: 32,
    grabCursor: true,

    pagination: {
      el: '.swiper-pagination',
      clickable: true,
      dynamicBullets: true,
      },

    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
      },

    breakpoints:{
      600: {
        slidesPerView: 2,
      },
      968: {
        slidesPerView: 3,
      },
    },

    });
</script> -->

<!-- JS for hamburger menu -->
<script>
    const hamburger = document.querySelector(".hamburger");
    const navMenu = document.querySelector(".nav-menu");

    //when hamburger is clicked, list appears and X appears
    hamburger.addEventListener("click", () => {
        hamburger.classList.toggle("active");
        navMenu.classList.toggle("active");
    })

    //when nav-link is clicked, menu disappears and hamburger comes back
    document.querySelectorAll(".nav-link").forEach(n => n.addEventListener("click", () => {
        hamburger.classList.remove("active");
        navMenu.classList.remove("active");
    }))

</script>

<script src="<?=ROOT?>/assets/js/script.js?<?= time();?>"></script>
<script src="<?=ROOT?>/assets/js/index.js?<?= time();?>"></script>

</body>
</html>