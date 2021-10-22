<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?= base_url() ?>assets/dist/img/user1.png" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p><?= $user->username ?></p>
				<small><?= $user->email ?></small>
			</div>
		</div>

		<ul class="sidebar-menu" data-widget="tree">
			<li class="header"><b>MAIN MENU</b></li>
			<!-- Optionally, you can add icons to the links -->
			<?php
			$page = $this->uri->segment(1);
			$master = ["about", "history", "award", "leader", "insight", "category", "journey"];
			$section = ["download", "video", "slider", "cornerstones"];
			$job = ["jobs"];
			$users = ["users"];
			?>
			<li class="<?= $page === 'dashboard' ? "active" : "" ?>"><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			<?php if ($this->ion_auth->is_admin()) : ?>
				<li class="treeview <?= in_array($page, $master)  ? "active menu-open" : ""  ?>">
					<a href="#"><i class="fa fa-folder"></i> <span>Our About us</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="<?= $page === 'about' ? "active" : "" ?>">
							<a href="<?= base_url('admin/about') ?>">
								<i class="fa fa-circle-o"></i>
								Add page
							</a>
						</li>
						<li class="<?= $page === 'history' ? "active" : "" ?>">
							<a href="<?= base_url('admin/history') ?>">
								<i class="fa fa-circle-o"></i>
								Our History
							</a>
						</li>
						<li class="<?= $page === 'award' ? "active" : "" ?>">
							<a href="<?= base_url('admin/award') ?>">
								<i class="fa fa-circle-o"></i>
								Our Awards
							</a>
						</li>
						<li class="<?= $page === 'leader' ? "active" : "" ?>">
							<a href="<?= base_url('admin/leader') ?>">
								<i class="fa fa-circle-o"></i>
								Our Leader
							</a>
						</li>
					</ul>
				</li>
			<?php endif; ?>

				<?php if ($this->ion_auth->is_admin()) : ?>
				<li class="treeview <?= in_array($page, $master)  ? "active menu-open" : ""  ?>">
					<a href="#"><i class="fa fa-folder"></i> <span>Our Insight</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="<?= $page === 'category' ? "active" : "" ?>">
							<a href="<?= base_url('admin/insight/category') ?>">
								<i class="fa fa-circle-o"></i>
								Category
							</a>
						</li>
						<li class="<?= $page === 'insight' ? "active" : "" ?>">
							<a href="<?= base_url('admin/insight') ?>">
								<i class="fa fa-circle-o"></i>
								Our Insight
							</a>
						</li>
					</ul>
				<?php endif; ?>
				
				<?php if ($this->ion_auth->is_admin()) : ?>
				<li class="treeview <?= in_array($page, $master)  ? "active menu-open" : ""  ?>">
					<a href="#"><i class="fa fa-folder"></i> <span>Our Journey</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="<?= $page === 'journey' ? "active" : "" ?>">
							<a href="<?= base_url('admin/journey') ?>">
								<i class="fa fa-circle-o"></i>
								Journery
							</a>
						</li>
					</ul>
				<?php endif; ?>

				<?php if ($this->ion_auth->is_admin()) : ?>
				<li class="header"><b>SECTION</b></li>
				<li class="<?= $page === 'cornerstones' ? "active" : "" ?>">
					<a href="<?= base_url('admin/cornerstones') ?>" rel="noopener noreferrer">
						<i class="fa fa-download"></i> <span>Cornerstones</span>
					</a>
				</li>
				<li class="<?= $page === 'download' ? "active" : "" ?>">
					<a href="<?= base_url('admin/download') ?>" rel="noopener noreferrer">
						<i class="fa fa-download"></i> <span>Download</span>
					</a>
				</li>
				<li class="<?= $page === 'video' ? "active" : "" ?>">
					<a href="<?= base_url('admin/video') ?>" rel="noopener noreferrer">
						<i class="fa fa-play"></i> <span>Video</span>
					</a>
				</li>
				<li class="<?= $page === 'slider' ? "active" : "" ?>">
					<a href="<?= base_url('admin/slider') ?>" rel="noopener noreferrer">
						<i class="fa fa-sliders"></i> <span>Slider</span>
					</a>
				</li>
			<?php endif; ?>


			<?php if ($this->ion_auth->is_admin()) : ?>
				<li class="header"><b>ADMINISTRATOR</b></li>
				<li class="<?= $page === 'users' ? "active" : "" ?>">
					<a href="<?= base_url('admin/users') ?>" rel="noopener noreferrer">
						<i class="fa fa-users"></i> <span>User Management</span>
					</a>
				</li>
			<?php endif; ?>
		</ul>

	</section>
	<!-- /.sidebar -->
</aside>