<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/dist/css/mystyle.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/plugins/iCheck/square/blue.css">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="<?= base_url() ?>assets/bower_components/jquery/jquery-3.3.1.min.js"></script>
</head>

<body class="hold-transition login-page" style="font-family: 'Poppins'">
	<div class="login-box pt-5">
		<!-- /.login-logo -->
		<div class="login-box-body">
			<h3 class="text-center mt-0 mb-4">
				<b>Maybank</b>
			</h3>
			<p class="login-box-msg">Login to start session</p>

			<div id="infoMessage" class="text-center"><?php echo $message; ?></div>

			<?= form_open("admin/auth/cek_login", array('id' => 'login')); ?>
			<div class="form-group has-feedback">
				<?= form_input($identity); ?>
				<span class="fa fa-envelope form-control-feedback"></span>
				<span class="help-block"></span>
			</div>
			<div class="form-group has-feedback">
				<?= form_input($password); ?>
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				<span class="help-block"></span>
			</div>
			<div class="row">
				<!-- /.col -->
				<div class="col-xs-12">
					<?= form_submit('submit', lang('login_submit_btn'), array('id' => 'submit', 'class' => 'btn btn-primary btn-block')); ?>
				</div>
				<!-- /.col -->
			</div>
			<?= form_close(); ?>
		</div>
	</div>

	<script type="text/javascript">
		let base_url = '<?= base_url(); ?>';
	</script>
	<script src="<?= base_url() ?>assets/dist/js/app/auth/login.js"></script>

	<script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="<?= base_url() ?>assets/plugins/iCheck/icheck.min.js"></script>
	<script>
		$(function() {
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
				increaseArea: '20%',
			});
		});

		$(document).ready(function() {
			$('form#login input').on('change', function() {
				$(this).parent().removeClass('has-error');
				$(this).next().next().text('');
			});

			$('form#login').on('submit', function(e) {
				e.preventDefault();
				e.stopImmediatePropagation();

				var infobox = $('#infoMessage');
				infobox.addClass('callout callout-info').text('Checking...');

				var btnsubmit = $('#submit');
				btnsubmit.attr('disabled', 'disabled').val('Wait...');

				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: $(this).serialize(),
					success: function(data) {
						infobox.removeAttr('class').text('');
						btnsubmit.removeAttr('disabled').val('Login');
						if (data.status) {
							infobox.addClass('callout callout-success text-center').text('Login Sukses');
							var go = base_url + data.url;
							window.location.href = go;
						} else {
							if (data.invalid) {
								$.each(data.invalid, function(key, val) {
									$('[name="' + key + '"').parent().addClass('has-error');
									$('[name="' + key + '"').next().next().text(val);
									if (val == '') {
										$('[name="' + key + '"').parent().removeClass('has-error');
										$('[name="' + key + '"').next().next().text('');
									}
								});
							}
							if (data.failed) {
								infobox.addClass('callout callout-danger text-center').text(data.failed);
							}
						}
					}
				});
			});
		});
	</script>
</body>

</html>