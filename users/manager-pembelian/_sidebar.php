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

		<li class="<?php if($menu=='bahan-baku') echo "active"; ?>">
			<a href="./index.php?menu=bahan-baku">
				<i class="menu-icon fa fa-cubes"></i>
				<span class="menu-text"> Bahan Baku </span>
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

		<li class="<?php if($menu=='supplier') echo "active"; ?>">
			<a href="./index.php?menu=supplier">
				<i class="menu-icon fa fa-building"></i>
				<span class="menu-text"> Supplier </span>
			</a>

			<b class="arrow"></b>
		</li>

		<li class="<?php if($menu=='peramalan') echo "active"; ?>">
			<a href="./index.php?menu=peramalan">
				<i class="menu-icon fa fa-bar-chart"></i>
				<span class="menu-text"> Peramalan </span>
			</a>

			<b class="arrow"></b>
		</li>

		<li class="<?php if($menu=='pemesanan') echo "active"; ?>">
			<a href="./index.php?menu=pemesanan">
				<i class="menu-icon fa fa-shopping-cart"></i>
				<span class="menu-text"> Pemesanan </span>
			</a>

			<b class="arrow"></b>
		</li>

		<li class="<?php if($menu=='persediaan') echo "active"; ?>">
			<a href="./index.php?menu=persediaan">
				<i class="menu-icon fa fa-file-o"></i>
				<span class="menu-text"> Persediaan Bahan </span>
			</a>

			<b class="arrow"></b>
		</li>
	</ul><!-- /.nav-list -->

	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div>
</div>
