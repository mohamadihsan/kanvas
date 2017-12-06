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

		<li class="<?php if($menu=='komposisi') echo "active"; ?>">
			<a href="./index.php?menu=komposisi">
				<i class="menu-icon fa fa-list"></i>
				<span class="menu-text"> Komposisi </span>
			</a>

			<b class="arrow"></b>
		</li>

		<li class="<?php if($menu=='produksi') echo "active"; ?>">
			<a href="./index.php?menu=produksi">
				<i class="menu-icon fa fa-list"></i>
				<span class="menu-text"> Produksi </span>
			</a>

			<b class="arrow"></b>
		</li>

		<li class="<?php if($menu=='peramalan') echo "active"; ?>">
			<a href="./index.php?menu=peramalan">
				<i class="menu-icon fa fa-bar-chart"></i>
				<span class="menu-text"> Peramalan Produksi </span>
			</a>

			<b class="arrow"></b>
		</li>
	</ul><!-- /.nav-list -->

	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div>
</div>
