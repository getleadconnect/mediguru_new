<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../../../">
		<meta charset="utf-8" />
		<title>Mediguru</title>
		<meta name="description" content="Login page example">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

		<!--begin::Page Custom Styles(used by this page) -->
		<link href="{{asset('css/pages/login/login-3.css')}}" rel="stylesheet" type="text/css" />

			<!--end:: Vendor Plugins -->
		<link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="{{ asset('media/logos/fav/favicon.ico')}}" />
	<style>

	.kt-login__logo
	{
		margin-top: 60px !important;
		margin-bottom: 10px !important;
	}

	@media(min-width: 1920px) {
	  .kt-login__logo {
		margin-top:120px !important;
	} }

	/* ---- beautified sign-in card ---- */
	.kt-login__wrapper-new
	{
		background: #ffffff !important;
		margin-top: 25px !important;
		margin-bottom: 100px !important;
		border-radius: 16px !important;
		box-shadow: 0 18px 45px rgba(47, 93, 63, 0.18) !important;
		padding: 45px 45px 40px !important;
		border-top: 5px solid #5f7a5f;
	}

	.kt-login__wrapper-new .kt-login__title
	{
		color: #2f4a35 !important;
		font-weight: 600;
		font-size: 22px;
		margin-bottom: 4px;
	}

	.kt-login__wrapper-new .kt-login__subtitle
	{
		color: #97a79c;
		font-size: 13px;
		margin-bottom: 28px;
	}

	/* input with leading icon */
	.mg-field
	{
		position: relative;
		margin-bottom: 20px;
	}

	.mg-field > i
	{
		position: absolute;
		top: 50%;
		left: 16px;
		transform: translateY(-50%);
		color: #9aa8a0;
		font-size: 15px;
		z-index: 2;
	}

	.kt-login__wrapper-new .mg-field .form-control
	{
		height: 50px;
		padding-left: 44px;
		padding-right: 44px;
		background: #f5f8f6 !important;
		border: 1.5px solid #e3e9e5 !important;
		border-radius: 10px !important;
		font-size: 14px;
		color: #2b3a2f;
		transition: border-color .2s, background .2s, box-shadow .2s;
	}

	.kt-login__wrapper-new .mg-field .form-control:focus
	{
		background: #ffffff !important;
		border-color: #5f7a5f !important;
		box-shadow: 0 0 0 4px rgba(95, 122, 95, 0.14) !important;
	}

	.kt-login__wrapper-new .mg-field .form-control::placeholder { color: #adbab2; }

	.mg-toggle-pwd
	{
		position: absolute;
		top: 50%;
		right: 14px;
		transform: translateY(-50%);
		color: #9aa8a0;
		cursor: pointer;
		z-index: 2;
		padding: 6px;
	}

	.kt-login__wrapper-new .kt-login__btn-primary
	{
		width: 100%;
		height: 50px;
		border: none;
		border-radius: 10px;
		font-weight: 600;
		font-size: 15px;
		letter-spacing: .3px;
		background: linear-gradient(135deg, #6d926d 0%, #2f5d3f 100%) !important;
		transition: box-shadow .2s, transform .15s;
	}

	.kt-login__wrapper-new .kt-login__btn-primary:hover
	{
		box-shadow: 0 10px 22px rgba(47, 93, 63, 0.30);
		transform: translateY(-1px);
	}

	.mg-error
	{
		display: flex;
		align-items: center;
		gap: 8px;
		background: #fdecec;
		color: #c0392b;
		border: 1px solid #f5c6c6;
		border-radius: 8px;
		padding: 10px 13px;
		font-size: 13px;
		margin-bottom: 18px;
	}

	</style>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body style="background:#eef2f0; class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading">

		<!-- begin:: Page -->
		<div class=" kt-grid--root kt-page">
			<div class="kt-login kt-login--v3 kt-login--signin" id="kt_login">
				<div class="kt-grid__item  kt-grid kt-grid--hor" style="background-color:#eef2f0;">

						<div class="kt-login__logo text-center">
								<a href="#">
									<img src="{{asset('media/logos/logo.png')}}" style="width:200px;">
								</a>
						</div>

					<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper kt-login__wrapper-new">

						<div class="kt-login__container">

							<div class="kt-login__signin">
								<div class="kt-login__head text-center">
									<h3 class="kt-login__title">Sign In To Admin</h3>
									<div class="kt-login__subtitle">Enter your credentials to continue</div>
								</div>

								@if($errors->has('err'))
									<div class="mg-error">
										<i class="fas fa-exclamation-circle"></i>
										<span>{{ $errors->first('err') }}</span>
									</div>
								@endif

								<form class="kt-form" method="post" action="{{ url('login') }}">
								@csrf
									<div class="mg-field">
										<i class="fas fa-envelope"></i>
										<input class="form-control" type="text" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="off" required autofocus>
									</div>
									<div class="mg-field">
										<i class="fas fa-lock"></i>
										<input class="form-control" type="password" placeholder="Password" name="password" id="password" required>
										<span class="mg-toggle-pwd" id="togglePwd"><i class="fas fa-eye"></i></span>
									</div>

									<div class="kt-login__actions">
										<button type="submit" class="btn btn-primary btn-elevate kt-login__btn-primary">Sign In</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<!-- end:: Page -->

		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#22b9ff",
						"light": "#ffffff",
						"dark": "#282a3c",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
						"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
					}
				}
			};
		</script>

		<!--begin:: Vendor Plugins -->
		<script src="{{ asset('plugins/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}" type="text/javascript"></script>

		<!--begin::Page Scripts(used by this page) -->
		<script src="{{ asset('js/pages/custom/login/login-general.js') }}" type="text/javascript"></script>
		<script>
			$(function () {
				$('#togglePwd').on('click', function () {
					var $input = $('#password');
					var isPwd = $input.attr('type') === 'password';
					$input.attr('type', isPwd ? 'text' : 'password');
					$(this).find('i').toggleClass('fa-eye fa-eye-slash');
				});
			});
		</script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>
