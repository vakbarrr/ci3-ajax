<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<base href="<?= base_url(); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= $template['metadata'] ?>
	<link rel="icon" href="<?= base_url('assets/images/favicon.jpeg'); ?>">
	<title>Maybank Sekuritas</title>
	<meta name="description" content="Maybank sekuritas merupakan perusahaan sekuritas yang berada di Indonesia">
	<meta name="keywords" content="Sekuritas, Saham, Trading, Stock, Investasi, Investment">
	<link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/css/swiper.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/jquery.fancybox.min.css') ?>">
	<link rel="stylesheet" href="<?= base_url('assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/responsive.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/animate.css') ?>">

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/jquery.fancybox.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/wow.js') ?>"></script>
	<!-- <?= $template['css'] ?> -->
	<!-- <?= $template['js'] ?> -->
	<script src="<?= base_url('assets/js/jquery-ui.js') ?>"></script>
	<link rel="stylesheet" href="<?= base_url('assets/css/jquery-ui.css') ?>">
	<script src="<?= base_url('assets/js/jquery.number.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/main.js') ?>"></script>
	<!-- select2 -->
	<script src="<?= base_url(); ?>assets/admin/plugins/select2/select2.min.js"></script>
	<link href="<?= base_url(); ?>assets/admin/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />

	<!-- Global site tag (gtag.js) - Google Analytics -->

</head>

<body>
	<header>
		<nav id="navigation">
			<div class="container-fluid container-nav">
				<a href="" class="logo">
					<img class="navbar-logo" src="<?= base_url('assets/images/logo-maybank.png') ?>">
				</a>
				<a aria-label="mobile menu" class="nav-toggle">
					<span></span>
					<span></span>
					<span></span>
				</a>
				<ul class="menu-right">
					<li><a href="<?= base_url('') ?>">Beranda</a></li>
					<li><a href="<?= base_url('feature') ?>">Fitur</a></li>
					<li><a href="<?= base_url('education') ?>">Edukasi</a></li>
					<li><a href="<?= base_url('campaign') ?>">Promo</a></li>
					<li class="login"><a href="https://www.ketrade.co.id" target="blank">Login</a></li>
					<li class="acc"><a href="https://opening.maybank-ke.co.id/#/" target="blank">Mulai Investasi</a></li>
				</ul>
			</div>
		</nav>
	</header>

	<?= $template['body'] ?>

	<div class="footer-top">
		<div class="container">
			<div class="row row-footer">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="footer-top">
						<div class="may-headline mb20">
							<h2 class="may-category bold">
								Belum punya akun <span class="main-color">MyMaybank</span> ?
							</h2>
						</div>
						<div class="word">
							<p class="may-semi regular">
								Lorem, ipsum dolor sit amet consectetur adipisicing elit. Obcaecati voluptatibus commodi aut architecto ex repellat atque, velit, vel, eius, cum animi? Alias reiciendis distinctio, placeat repellat quisquam.
							</p>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-center">
					<div class="action">
						<a data-text="Buka akun yuk!" class="btn-utama button-hover" href="https://opening.maybank-ke.co.id/#/" target="_blank"> 
							Mulai Investasi
						</a>
					</div>
					<div class="footer-download">
						<div class="download-app">
							<a href="https://apps.apple.com/id/app/ketrade-pro-id/id640586062" class="" target="_blank">
								<img src="<?= base_url('assets/images/app-apple.png') ?>">
							</a>
						</div>
						<div class="download-app">
							<a href="https://play.google.com/store/apps/details?id=com.onlinetrading.ketrade" class="" target="_blank">
								<img src="<?= base_url('assets/images/app-google.png') ?>">
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer class="footer">
		<div class="footer-image wow fadeInUp">
			<div class="image">
				<img src="<?= base_url('assets/images/footer-image.png') ?>">
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
					<div class="footer-wrapper">
						<div class="image">
							<img src="<?= base_url('assets/images/logo-maybank.png') ?>">
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
					<div class="hero-word">
						<h2 class="may-category bold">
							<span class="wow fadeInUp">Maybank</span> <span class="wow fadeInUp" data-wow-delay="0.2s">Sekuritas</span> <span class="wow fadeInUp" data-wow-delay="0.3s">Indonesia</span>
						</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="footer-wrapper">
						<div class="word">
							<h2 class="may-category black bold">
								About
							</h2>
						</div>
						<div class="word mt10">
							<p class="may-semi">
								Maybank Sekuritas Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod necessitatibus illo voluptas id assumenda et quisquam sed nisi dicta exercitationem similique dignissimos quasi natus.
							</p>
						</div>
						<div class="footer-socmed mt10">
							<div class="wrapper">
								<a href="">
									<i class="fa fa-instagram"></i> 
								</a>
							</div>
							<div class="wrapper">
								<a href="">
									<i class="fa fa-facebook"></i> 
								</a>
							</div>
							<div class="wrapper">
								<a href="">
									<i class="fa fa-twitter"></i> 
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="footer-wrapper">
						<div class="word">
							<h2 class="may-category black bold">
								Quick Links
							</h2>
						</div>
						<ul>
							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
									<li><a href="<?= base_url('feature') ?>">Features</a></li>
									<li><a href="<?= base_url('campaign') ?>">Campaign</a></li>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
									<li><a href="<?= base_url('education') ?>">Education</a></li>
									<li><a href="<?= base_url('#contact') ?>">Open an Account</a></li>
								</div>
							</div>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="footer-copyright text-center">
						<div class="wrapper">
							<p class="may-main black bold">
								Copyright © 2021 Maybank Sekuritas Indonesia.<br>
								All rights reserved
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>

		<!-- <div class="floating-contact">
			<div class="image">
				<a href="https://api.whatsapp.com/send?phone=6285319698322&text=Halo%20Dietopia,%20saya%20mau%20nanya%20nanya%20nih" target="_blank">
					<img src="<?= base_url('assets/images/contact-chat.svg') ?>">
				</a>
			</div>
		</div> -->

		<script>
		// TOGGLE HAMBURGER & COLLAPSE NAV
		$('.nav-toggle').on('click', function() {
			$(this).toggleClass('open');
			$('.menu-right').toggleClass('collapse');
		});
		// REMOVE X & COLLAPSE NAV ON ON CLICK
		$('.menu-right a').on('click', function() {
			$('.nav-toggle').removeClass('open');
			$('.menu-right').removeClass('collapse');
		});

		// LINKS TO ANCHORS
		$('.menu-right a[href^="#"]').on('click', function(event) {

			var $target = $(this.getAttribute('href'));

			if ($target.length) {
				event.preventDefault();
				$('html, body').stop().animate({
					scrollTop: $target.offset().top
				}, 750, 'easeInOutQuad');
			}
		});

		$(".numberjs").number(true);
	</script>

</body>

</html>