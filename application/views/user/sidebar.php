<div class="main-menu">
	<header class="header">
		<a href="index.html" class="logo">Parepare</a>
		<button type="button" class="button-close fa fa-times js__menu_close"></button>
		<div class="user">
			<a href="#" class="avatar"><img src="<?=base_url()?>assets/images/admin.png" alt=""><span class="status online"></span></a>
			<h5 class="name"><a href="#">Pengunjung</a></h5>
			<h5 class="position">Pengunjung</h5>

		</div>
		<!-- /.user -->
	</header>
	<!-- /.header -->
	<div class="content">

		<div class="navigation">
			<h5 class="title">Navigasi</h5>
			<!-- /.title -->
			<ul class="menu js__accordion">
				<li <?php if ($header == 'Halaman Utama') {
						echo 'class="current"';
					} ?>>
					<a class="waves-effect" href="<?= base_url('user') ?>"><i class="menu-icon fa fa-home"></i><span>Halaman Utama</span></a>
				</li>
				


			</ul>

		</div>
		<!-- /.navigation -->
	</div>
	<!-- /.content -->
</div>
<!-- /.main-menu -->

<div class="fixed-navbar">
	<div class="pull-left">
		<button type="button" class="menu-mobile-button glyphicon glyphicon-menu-hamburger js__menu_mobile"></button>
		<h1 class="page-title"><?= $header ?></h1>
		<!-- /.page-title -->
	</div>
	<!-- /.pull-left -->
	<div class="pull-right">

		<!-- <a href="#" class="ico-item fa fa-power-off"></a> -->
	</div>
	<!-- /.pull-right -->
</div>