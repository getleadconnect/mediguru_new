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

		<link href="{{asset('css/pages/login/login-3.css')}}" rel="stylesheet" type="text/css" />
		
		<!--end:: Vendor Plugins -->
		<link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="{{ asset('media/logos/fav/favicon.ico')}}" />
		
	<style>
	
	.kt-login__wrapper-new
	{
		background-color:#fff;
		margin-top: 25px !important;
		margin-bottom: 100px !important;
		box-shadow: 1px 1px 5px #cdc8c8;
	}

	.kt-login__logo
	{
	   margin-top: 75px !important;
	}
	
	.frm-show
	{
	   display:block;
	}
	
	.frm-hide
	{
	   display:none;
	}
	
	</style>
	
	</head>

	<!-- end::Head -->
	<!-- begin::Body -->
	
    <body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading">
		
		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-color:#fff; /*background-image: url(assets/media/bg/bg-3.jpg);*/ ">
					
					<div class="row">
						<div class="col-md-12 col-xl-12 col-xxl-12 text-center">
							<img src="{{asset('media/logos/logo.png')}}" style="width:200px;">
						</div>
					
						<!--<div class="col-md-10 col-xl-10 col-xxl-10 text-center" style="left:-130px;top:30px;">
							<h1> Account Settings</h1>
						</div> -->
					</div>
					
					<div class="row">
					  <div class="col-md-12 col-xl-12 col-xxl-12">
						 <hr style="border1px solid #e4e4e4;">
					  </div>
					</div>
			
				<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper kt-login__wrapper-new"  style="border-radius:15px;">
					<div class="kt-login__container">
						<div class="kt-login__signin">
							<div class="kt-login__head">
								<h6 class="kt-login__title">Delete User Account</h6>
								<p> Please fill the following details and submit to remove your account.</p>
							</div>
								
								<form class="kt-form frm-show" method="post" id="submitForm" autocomplete="off">
								  @csrf
									<div class="form-group">
									  <label> Name </label>
									  <input class="form-control" type="text" placeholder="Name" id="reg_name" name="reg_name" style="margin-top:0px;background:#fff;border:1px solid #e4e4e4;" required>
									</div>

									<div class="form-group">
									  <label> Reason</label>
									  <textarea class="form-control" type="text" placeholder="Reason" id="reg_reason" name="reg_reason" style="margin-top:0px;background:#fff;border:1px solid #e4e4e4;" required></textarea>
									</div>
									
									
									<div class="form-group">
									  <label> Mobile</label>									
									  <input class="form-control" type="text" placeholder="Mobile" id="reg_mobile" name="reg_mobile" style="margin-top:0px;background:#fff;border:1px solid #e4e4e4;" required>
									</div>
									
									
									<div class="form-group">
									   <label> User Password</label>
										<input class="form-control" type="password" placeholder="Password" id="reg_password" name="reg_password" style="margin-top:0px;background:#fff;border:1px solid #e4e4e4;" required>
									</div>
																		
									<div class="kt-login__actions">
										<button type="submit" class="btn btn-primary btn-elevate ">Submit</button>
									</div>
								</form>

							</div>
					    </div>
				    </div>
			    </div>
			</div>
		</div>
	</div>
		<!-- end:: Page -->
		<!--begin::Global Theme Bundle(used by all pages) -->
		<!--begin:: Vendor Plugins -->
		
	<script src="{{ asset('plugins/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>
	<script src="{{ asset('plugins/general/jquery-form/dist/jquery.form.min.js') }}" type="text/javascript"></script>

		<!--end:: Vendor Plugins -->
	<script src="{{ asset('js/scripts.bundle.js') }}" type="text/javascript"></script>

 <script>

  $("form#submitForm").submit(function(e)
  {
    e.preventDefault();    

    if($("#reg_email").val()!='' && $("#reg_mobile").val()!='' && $("#reg_reason").val()!='' && $("#reg_password").val()!='')
    {
		if(confirm("Are you sure, Delete your app account?"))
		{
		  
		  var formData = new FormData(this);
			
		   $.ajax({
			  url: "{{url('delete_user_account')}}",
			  type: 'post',
			  data: formData,
			  success: function (res) 
			  {
				  if(res==1)
				  {
					  $("#reg_name").val('');
					  $("#reg_mobile").val('');
					  $("#reg_reason").val('');
					  $("#reg_password").val('');
					  alert("Your app account successfully removed.!");
				  }
				  else
				  {
					  alert("User detail not found, Try again.");
				  }
			  },
				cache: false,
				contentType: false,
				processData: false
			});
		}
	}
	else
	{
		alert("Form details are missing.!");
	}

});



</script>
		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>