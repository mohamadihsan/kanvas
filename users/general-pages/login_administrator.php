<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Login</title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="../assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="../assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="../assets/css/ace.min.css" />

		<link rel="stylesheet" href="../assets/css/ace-rtl.min.css" />

		<script src="../assets/js/jquery-2.1.4.min.js"></script>
		<!-- gritter notification -->
		<link rel="stylesheet" href="../assets/css/jquery.gritter.min.css" />
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<!-- <i class="ace-icon fa fa-building green"></i> -->
									<span class="red">PT.Kanvas</span>
									<span class="white" id="id-text2">Mulia</span>
								</h1>
								<!--<h4 class="blue" id="id-company-text">&copy; Company Name</h4>-->
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-lock green"></i>
												Login
											</h4>

											<div class="space-6"></div>

											<form method="post" action="../action/login.php">

												<input type="hidden" name="log_user" value="administrator" placeholder="">

												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" name="nama_pengguna" placeholder="Nama Pengguna" required/>
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" name="kata_sandi" placeholder="Kata Sandi" required/>
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">

														<button type="submit" class="width-35 pull-right btn btn-sm btn-success">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Login</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>

										</div><!-- /.widget-main -->

									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

							</div><!-- /.position-relative -->

							<!--<div class="navbar-fixed-top align-right">
								<br />
								&nbsp;
								<a id="btn-login-dark" href="#">Dark</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-blur" href="#">Blur</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-light" href="#">Light</a>
								&nbsp; &nbsp; &nbsp;
							</div>-->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='../assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<script src="../assets/js/bootstrap.min.js"></script>
		<script src="../assets/js/jquery-ui.custom.min.js"></script>

		<script src="../assets/js/jquery.easypiechart.min.js"></script>
		<!-- gritter notification -->
		<script src="../assets/js/jquery.gritter.min.js"></script>

		<script>

			// LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA
			$(document).ready(function(){

				//Callback handler for form submit event
				$(".myform").submit(function(e)
				{

				var formObj = $(this);
				var formURL = formObj.attr("action");
				var formData = new FormData(this);
				$.ajax({
					url: formURL,
					type: 'POST',
					data:  formData,
					contentType: false,
					cache: false,
					processData:false,
					beforeSend: function (){
							$("#loading").show(1000).html("<img src='../assets/images/loading.gif' height='100'>");
							},
					success: function(data, textStatus, jqXHR){
							$("#result").html(data);
							$("#loading").hide();
							$("#hapus").modal('hide');
							$('#mytable').DataTable().ajax.reload();
					},
						error: function(jqXHR, textStatus, errorThrown){
				}
				});
					e.preventDefault(); //Prevent Default action.
					e.unbind();
				});

			});
		</script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 $(document).on('click', '.toolbar a[data-target]', function(e) {
				e.preventDefault();
				var target = $(this).data('target');
				$('.widget-box.visible').removeClass('visible');//hide others
				$(target).addClass('visible');//show target
			 });
			});



			//you don't need this, just used for changing background
			jQuery(function($) {
			 $('#btn-login-dark').on('click', function(e) {
				$('body').attr('class', 'login-layout');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'blue');

				e.preventDefault();
			 });
			 $('#btn-login-light').on('click', function(e) {
				$('body').attr('class', 'login-layout light-login');
				$('#id-text2').attr('class', 'grey');
				$('#id-company-text').attr('class', 'blue');

				e.preventDefault();
			 });
			 $('#btn-login-blur').on('click', function(e) {
				$('body').attr('class', 'login-layout blur-login');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'light-blue');

				e.preventDefault();
			 });

			});
		</script>
	</body>
</html>

<?php
	$gagal_login = isset($_SESSION['login'])? $_SESSION['login'] : true;
	if($gagal_login==false) {
		 ?>
	    <script type="text/javascript">
		    $(function(){
	            $.gritter.add({
	                // (string | mandatory) the heading of the notification
	                title: 'Gagal!',
	                // (string | mandatory) the text inside the notification
	                text: 'Akun anda tidak terdaftar!',
	                // (string | optional) the image to display on the left
	                image: '../assets/images/gagal.png',
	                // (bool | optional) if you want it to fade out on its own or just sit there
	                sticky: false,
	                // (int | optional) the time you want it to be alive for before fading out
	                time: ''
		        });
	        });
		</script>
		<?php
		session_unset($_SESSION['login']);
	}
?>
