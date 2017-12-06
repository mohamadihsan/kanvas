<div id="sidebar" class="sidebar responsive ace-save-state">
	<script type="text/javascript">
		try{ace.settings.loadState('sidebar')}catch(e){}
	</script>

	<ul class="nav nav-list">
		<li class="<?php if($menu=='') echo "active"; ?>">
			<a href="./">
				<i class="menu-icon fa fa-home"></i>
				<span class="menu-text"> Beranda </span>
			</a>

			<b class="arrow"></b>
		</li>

		<li class="<?php if($menu=='produk') echo "active"; ?>">
			<a href="./index.php?menu=produk">
				<i class="menu-icon fa fa-cube"></i>
				<span class="menu-text"> Produk </span>
			</a>

			<b class="arrow"></b>
		</li>

		<li class="<?php if($menu=='pelanggan') echo "active"; ?>">
			<a href="./index.php?menu=pelanggan">
				<i class="menu-icon fa fa-user"></i>
				<span class="menu-text"> Pelanggan </span>
			</a>

			<b class="arrow"></b>
		</li>

		<li class="<?php if($menu=='distribusi') echo "active"; ?>">
			<a href="./index.php?menu=distribusi">
				<i class="menu-icon fa fa-calendar"></i>
				<span class="menu-text"> Jadwal Distribusi </span>
			</a>

			<b class="arrow"></b>
		</li>

		<li class="<?php if($menu=='pemesanan') echo "active"; ?>">
			<a href="./index.php?menu=pemesanan">
				<i class="menu-icon fa fa-file-text"></i>
				<span class="menu-text"> Pemesanan Produk </span>
			</a>

			<b class="arrow"></b>
		</li>

	</ul><!-- /.nav-list -->

	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div>
</div>
