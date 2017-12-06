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

		<li class="<?php if($menu=='barang') echo "active"; ?>">
			<a href="./index.php?menu=barang">
				<i class="menu-icon fa fa-cubes"></i>
				<span class="menu-text"> Barang </span>
			</a>

			<b class="arrow"></b>
		</li>

		<li class="<?php if($menu=='pemesanan') echo "active"; ?>">
			<a href="./index.php?menu=pemesanan">
				<i class="menu-icon fa fa-file-text-o"></i>
				<span class="menu-text"> Pemesanan Barang </span>
			</a>

			<b class="arrow"></b>
		</li>

	</ul><!-- /.nav-list -->

	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div>
</div>