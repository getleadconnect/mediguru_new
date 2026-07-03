<!DOCTYPE html>

<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4 & Angular 8
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../../">
		<meta charset="utf-8" />
		<title>Mediguru</title>
		<meta name="description" content="No aside layout examples">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!--begin::Fonts -->
		<!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">-->

		<!--end::Fonts -->

		<!--begin::Page Vendors Styles(used by this page) -->

		<!--end::Page Vendors Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->

		<!--begin:: Vendor Plugins -->
				
		
		<!--begin::Fonts -->
		<!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">-->

		<!--end::Fonts -->

		<!--begin::Global Theme Styles(used by all pages) -->

		<!--begin:: Vendor Plugins -->
		<link href="{{ asset('plugins/general/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/tether/dist/css/tether.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/bootstrap-timepicker/css/bootstrap-timepicker.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/bootstrap-select/dist/css/bootstrap-select.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/select2/dist/css/select2.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/ion-rangeslider/css/ion.rangeSlider.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/nouislider/distribute/nouislider.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/owl.carousel/dist/assets/owl.carousel.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/owl.carousel/dist/assets/owl.theme.default.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/dropzone/dist/dropzone.css')}}" rel="stylesheet" type="text/css" />
		<!--<link href="{{ asset('plugins/general/quill/dist/quill.snow.css')}}" rel="stylesheet" type="text/css" />-->
		<link href="{{ asset('plugins/general/@yaireo/tagify/dist/tagify.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/summernote/dist/summernote.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/bootstrap-markdown/css/bootstrap-markdown.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/animate.css/animate.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/toastr/build/toastr.css')}}" rel="stylesheet" type="text/css" />
		<!--<link href="{{ asset('plugins/general/dual-listbox/dist/dual-listbox')}}" rel="stylesheet" type="text/css" />-->
		<link href="{{ asset('plugins/general/morris.js/morris.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/sweetalert2/dist/sweetalert2.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/socicon/css/socicon.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/plugins/line-awesome/css/line-awesome.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/plugins/flaticon/flaticon.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/plugins/flaticon2/flaticon.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/general/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css" />

		<!--end:: Vendor Plugins -->
		<link href="{{ asset('css/style.bundle.css')}}" rel="stylesheet" type="text/css" />

		<!--begin:: Vendor Plugins for custom pages -->
		<link href="{{ asset('plugins/custom/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/@fullcalendar/core/main.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/@fullcalendar/daygrid/main.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/@fullcalendar/list/main.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/@fullcalendar/timegrid/main.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/datatables.net-autofill-bs4/css/autoFill.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/datatables.net-colreorder-bs4/css/colReorder.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/datatables.net-fixedcolumns-bs4/css/fixedColumns.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/datatables.net-keytable-bs4/css/keyTable.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/datatables.net-rowgroup-bs4/css/rowGroup.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/datatables.net-rowreorder-bs4/css/rowReorder.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/datatables.net-scroller-bs4/css/scroller.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/jstree/dist/themes/default/style.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/jqvmap/dist/jqvmap.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/uppy/dist/uppy.min.css')}}" rel="stylesheet" type="text/css" />

		<!--end:: Vendor Plugins for custom pages -->

		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins(used by all pages) -->
		
		<!--end:: Vendor Plugins -->
		<link href="{{ asset('css/pre-loader.css')}}" rel="stylesheet" type="text/css" />
					
		<link rel="shortcut icon" href="{{ asset('media/logos/fav.png')}}" />
		
		<!--<link rel="stylesheet" href="{{ asset('chartist/chartist.min.css')}}">-->
		
	<style>
	.icon-color
	 {
	  color:#282a3c !important;
	 }
	
	</style>	

		@yield('stylesheets')

	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
		
	@php
        $menus = App\Models\MenuGroup::query();
		$auid=Session::get('admin_id');
        $mgrps=$menus->select('menu_groups.id','menu_group_type','menu_group_name','menu_group_icon')
                  ->Join('user_menus','menu_groups.id','=','user_menus.menu_group_id')
				  ->where(function($where)use($auid){
				  $where->where('user_menus.admin_id', '=', $auid);})
				  ->distinct(['menu_group_id'])->orderBy('id','ASC')->get();
				  
		$umenus=App\Models\UserMenu::where('admin_id',$auid)->orderBy("menu_order", "ASC")->get();

	@endphp
	

 <body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-page--loading" style="min-height:600px;overflow-y:scroll;">
 
 <div class="pre-loader">
        <br/><br/>
        <div class="row">
            <div class="col-md-12">
                <div class="loader15">
                    <span></span><span></span><span></span><span></span>
                </div>
			</div>
        </div>
        <br/><br/>
    </div>


		<!-- begin:: Page -->

		<!-- begin:: Header Mobile -->
		<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
			<div class="kt-header-mobile__logo">
				<a href="javascript:void(0)">
					<!--<img alt="Logo" src="{{ asset('media/logos/logo1.svg')}}" /> -->
					<img alt="Logo" src="{{ asset('media/logos/logo.png')}}" />
				</a>
			</div>
			<div class="kt-header-mobile__toolbar" style="background: #fff;">
				<div class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></div>
				<!--<div class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></div>-->
				<div class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></div>
			</div>
		</div>

		<!-- end:: Header Mobile -->
		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

				<!-- begin:: Aside -->
			 <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
				<div class="kt-aside  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

					<!-- begin:: Aside Menu -->
					<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper" style="position:fixed !important;min-width: 250px;">
						<div id="kt_aside_menu" class="kt-aside-menu kt-scroll" data-scroll="true" style="margin-top:45px;height:850px;border-right: .1rem solid #e4e4e4;" data-ktmenu-vertical="1">
					
							<ul class="kt-menu__nav ">

								<li class="kt-menu__item " aria-haspopup="true">
								<a href="{{url('dashboard')}}" class="kt-menu__link ">
								<i class="kt-menu__link-icon flaticon2-protection icon-color">
								</i><span class="kt-menu__link-text">Dashboard</span></a>
								</li>
															
																
								@foreach($mgrps as $mg)
								@if(strtoupper($mg->menu_group_type)=="MULTIPLE")

								<li class="kt-menu__item kt-menu__item--submenu " aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
								<a href="javascript:;" class="kt-menu__link kt-menu__toggle">
								<i class="kt-menu__link-icon {{ $mg->menu_group_icon }} icon-color"></i>
								<span class="kt-menu__link-text">{{$mg->menu_group_name }}</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
									<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
										<ul class="kt-menu__subnav">
										@php
										    $umnus= $umenus->where('menu_group_id',$mg->id)->sortBy('menu_order');
										@endphp
										
										
										@foreach($umnus as $um)
										@if($mg->id==$um->menu_group_id)
										
											<li class="kt-menu__item " aria-haspopup="true">
											<a href="{{ url($um->menu_url)}}" class="kt-menu__link ">
											<i class="kt-menu__link-bullet fas fa-caret-right"></i>
											<span class="kt-menu__link-text">{{ $um->menu_option }}</span>
											</a></li>
										@endif
										@endforeach
										</ul>
									</div>
								</li>
								
								@else

									@if(strtoupper($mg->menu_group_type)=="SINGLE")
										@foreach($umenus as $um)
											@if($mg->id==$um->menu_group_id)
								
											<li class="kt-menu__item " aria-haspopup="true">
											<a href="{{ $um->menu_url }}" class="kt-menu__link ">
											<i class="kt-menu__link-icon {{ $mg->menu_group_icon }} icon-color">
											</i><span class="kt-menu__link-text">{{ $um->menu_option }}</span></a>
											</li>
															
											@endif
											
										@endforeach
									@endif
								
								@endif
								@endforeach
							</ul>
						</div>
					</div>

					<!-- end:: Aside Menu -->
				</div>

				<!-- end:: Aside -->
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

					<!-- begin:: Header -->
					<div id="kt_header" class="kt-header kt-grid kt-grid--ver  kt-header--fixed " style="background:#fbfbfb;"> <!-- #3d644d -->

						<!-- begin:: Aside -->
						<div class="kt-header__brand kt-grid__item  " id="kt_header_brand" style="background:#fbfbfb;width: 250px;border-right:.1rem solid #e4e4e4;">
							<!--<div class="kt-header__brand-logo">
								<a href="javacript:void(0)">
									<img alt="Logo" src="{{ url('media/logos/logo-1.png')}}" />
								</a>
							</div> -->
							
							<div class="kt-header-mobile__logo" style="width: 100px;display: block;">
								<a href="javascript:void(0)">
								<!--<img alt="Logo" src="{{asset('media/logos/logo1.svg')}}" style="width: 58px;margin-top: 5px;">-->
								<img alt="Logo" src="{{asset('media/logos/logo.png')}}" style="width: 140px;margin-top: 5px;margin-left:-30px;">
								</a>
							</div>
						</div>

						<!-- end:: Aside -->

						<!-- begin:: Title -->
						
						<div class="row" style="width:100%;">
						   <div class="col-lg-12 col-xl-12 col-xxl-12" style="display:flex;">
							   <h3 class="kt-header__title kt-grid__item"> Mediguru - Administrations </h3>
						   </div>
						</div>

						<!-- end:: Title -->

						<!-- begin: Header Menu -->
						<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
	
						<!-- end: Header Menu -->

						<!-- begin:: Header Topbar -->
						<div class="kt-header__topbar">

							<!--begin: User bar -->
							<div class="kt-header__topbar-item kt-header__topbar-item--user">
								<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
									<img class="kt-hidden" alt="Pic" src="{{ asset('media/users/300_21.jpg')}}" />
									<span class="kt-header__topbar-icon kt-hidden-"><i class="flaticon2-user-outline-symbol"></i></span>
								</div>
								<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl" style="width:270px; !important;">

									<!--begin: Head -->
									<div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background:#50724e;/*background-image: asset({{ asset('media/misc/bg-1.jpg')}});*/">
										<div class="kt-user-card__avatar">
											<img class="kt-hidden" alt="Pic" src="{{ asset('media/users/300_25.jpg')}}" />

											<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
											<span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success"><i class="flaticon2-user"></i></span>
										</div>
										<div class="kt-user-card__name">
											<span>Hello,<strong> {{ Session::get('admin_name') }}</strong></span>
										</div>
	
									</div>

									<!--end: Head -->

									<!--begin: Navigation -->
									<div class="kt-notification">
									
									
										<a href="#" class="kt-notification__item" data-toggle="modal" data-target="#kt_modal_password">
											<div class="kt-notification__item-icon">
												<i class="flaticon2-calendar-3 kt-font-success"></i>
											</div>
											<div class="kt-notification__item-details">
												<div class="kt-notification__item-title kt-font-bold">
													Change Password
												</div>
											</div>
										</a>

										<div class="kt-notification__custom kt-space-between">

											<a href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form2').submit();" class="btn  btn-primary btn-sm btn-bold">Sign Out</a>
											
											<form id="logout-form2" action="{{ route('admin.logout') }}" method="POST" class="d-none">
											@csrf
											</form>
										
										</div>
									</div>

									<!--end: Navigation -->
								</div>
							</div>

							<!--end: User bar -->

						</div>

						<!-- end:: Header Topbar -->
					</div>

					<!-- end:: Header -->
					<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content" >
					
					<!------- content --------->
					
					@yield('contents')
						
					<!-- end:: Content -->
					</div>

					<!-- begin:: Footer -->
					<div class="kt-footer  kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer" style="border-top:1px solid #b7b7b7;">
						<div class="kt-container  kt-container--fluid ">
							<div class="kt-footer__copyright">
								2022&nbsp;&copy;&nbsp;<a href="http://mediguru.co.in" target="_blank" class="kt-link">mediguru.co.in</a>
							</div>
							<div class="kt-footer__menu">
							
							</div>
						</div>
					</div>

					<!-- end:: Footer -->
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!-- end::Quick Panel -->

	<div class="modal fade" id="kt_modal_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					
				<input type="hidden" id="admin_id" name="admin_id" value="{{ Session::get('admin_id') }}" >
				  
					<div class="form-group">
						<label>New Password </label>
							<input type="password" id="new_pass" class="form-control input-default " name="new_pass" autocomplete=off required>
						</div>

					<div class="form-group">
						<label>Confirm Password </label>
							<input type="password" id="re_pass" class="form-control input-default " name="re_pass" autocomplete=off required>
						</div>
					<div class="row">
					<div class="col-lg-12 col-xl-12 text-center">
						<label id="err_mes" style="color:red"></label>	
						<label id="succ_mes" style="color:Green"></label>
					</div>
					</div>

				<div class="modal-footer">
					<button type="button" id="btnChkPass" class="btn btn-primary"> Submit </button>
					<button type="button" id="btnClose" class="btn btn-danger light" data-dismiss="modal">Close</button>
				</div>
		
				</div>
				
			</div>
		</div>
	</div>


		<!--ENd:: Chat-->

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

		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->

		<!--begin:: Vendor Plugins -->
		
		
		<!--begin:: Vendor Plugins -->
		<script src="{{ asset('plugins/general/jquery/dist/jquery.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/popper.js/dist/umd/popper.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/js-cookie/src/js.cookie.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/moment/min/moment.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/tooltip.js/dist/umd/tooltip.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/perfect-scrollbar/dist/perfect-scrollbar.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/sticky-js/dist/sticky.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/wnumb/wNumb.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/jquery-form/dist/jquery.form.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/block-ui/jquery.blockUI.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/js/global/integration/plugins/bootstrap-datepicker.init.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/js/global/integration/plugins/bootstrap-timepicker.init.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/bootstrap-daterangepicker/daterangepicker.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/bootstrap-maxlength/src/bootstrap-maxlength.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/plugins/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/bootstrap-select/dist/js/bootstrap-select.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/bootstrap-switch/dist/js/bootstrap-switch.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/js/global/integration/plugins/bootstrap-switch.init.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/select2/dist/js/select2.full.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/ion-rangeslider/js/ion.rangeSlider.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/typeahead.js/dist/typeahead.bundle.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/handlebars/dist/handlebars.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/inputmask/dist/jquery.inputmask.bundle.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/inputmask/dist/inputmask/inputmask.date.extensions.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/nouislider/distribute/nouislider.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/owl.carousel/dist/owl.carousel.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/autosize/dist/autosize.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/clipboard/dist/clipboard.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/dropzone/dist/dropzone.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/js/global/integration/plugins/dropzone.init.js')}}" type="text/javascript"></script>
		<!--<script src="{{ asset('plugins/general/quill/dist/quill.js" type="text/javascript')}}"></script>-->
		<script src="{{ asset('plugins/general/@yaireo/tagify/dist/tagify.polyfills.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/@yaireo/tagify/dist/tagify.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/summernote/dist/summernote.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/markdown/lib/markdown.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/bootstrap-markdown/js/bootstrap-markdown.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/js/global/integration/plugins/bootstrap-markdown.init.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/bootstrap-notify/bootstrap-notify.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/js/global/integration/plugins/bootstrap-notify.init.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/jquery-validation/dist/jquery.validate.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/jquery-validation/dist/additional-methods.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/js/global/integration/plugins/jquery-validation.init.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/toastr/build/toastr.min.js')}}" type="text/javascript"></script>
		<!--<script src="{{ asset('plugins/general/dual-listbox/dist/dual-listbox.js')}}" type="text/javascript"></script>-->
		<script src="{{ asset('plugins/general/raphael/raphael.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/morris.js/morris.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/chart.js/dist/Chart.bundle.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/plugins/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/plugins/jquery-idletimer/idle-timer.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/waypoints/lib/jquery.waypoints.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/counterup/jquery.counterup.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/es6-promise-polyfill/promise.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/sweetalert2/dist/sweetalert2.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/js/global/integration/plugins/sweetalert2.init.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/jquery.repeater/src/lib.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/jquery.repeater/src/jquery.input.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/jquery.repeater/src/repeater.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/general/dompurify/dist/purify.js')}}" type="text/javascript"></script>

		<!--end:: Vendor Plugins -->
		<script src="{{ asset('js/scripts.bundle.js')}}" type="text/javascript"></script>

		<!--begin:: Vendor Plugins for custom pages -->
		<script src="{{ asset('plugins/custom/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/@fullcalendar/core/main.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/@fullcalendar/daygrid/main.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/@fullcalendar/google-calendar/main.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/@fullcalendar/interaction/main.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/@fullcalendar/list/main.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/@fullcalendar/timegrid/main.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/gmaps/gmaps.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/flot/dist/es5/jquery.flot.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/flot/source/jquery.flot.resize.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/flot/source/jquery.flot.categories.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/flot/source/jquery.flot.pie.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/flot/source/jquery.flot.stack.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/flot/source/jquery.flot.crosshair.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/flot/source/jquery.flot.axislabels.js')}}" type="text/javascript"></script>
		
		<script src="{{ asset('plugins/custom/datatables.net/js/jquery.dataTables.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-bs4/js/dataTables.bootstrap4.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/js/global/integration/plugins/datatables.init.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-autofill/js/dataTables.autoFill.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-autofill-bs4/js/autoFill.bootstrap4.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/jszip/dist/jszip.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/pdfmake/build/pdfmake.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/pdfmake/build/vfs_fonts.js')}}" type="text/javascript"></script>
		
		<script src="{{ asset('plugins/custom/datatables.net-buttons/js/dataTables.buttons.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-buttons/js/buttons.colVis.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-buttons/js/buttons.flash.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-buttons/js/buttons.html5.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-buttons/js/buttons.print.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-colreorder/js/dataTables.colReorder.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-keytable/js/dataTables.keyTable.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-responsive/js/dataTables.responsive.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-rowgroup/js/dataTables.rowGroup.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-rowreorder/js/dataTables.rowReorder.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-scroller/js/dataTables.scroller.min.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/datatables.net-select/js/dataTables.select.min.js')}}" type="text/javascript"></script>
		
		<script src="{{ asset('plugins/custom/jstree/dist/jstree.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/jqvmap/dist/jquery.vmap.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/jqvmap/dist/maps/jquery.vmap.world.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/jqvmap/dist/maps/jquery.vmap.russia.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/jqvmap/dist/maps/jquery.vmap.usa.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/jqvmap/dist/maps/jquery.vmap.germany.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/jqvmap/dist/maps/jquery.vmap.europe.js')}}" type="text/javascript"></script>
		<script src="{{ asset('plugins/custom/uppy/dist/uppy.min.js')}}" type="text/javascript"></script>

		<!--end:: Vendor Plugins for custom pages -->

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts(used by this page) -->
		<script src="{{ asset('js/pages/crud/forms/widgets/select2.js')}}" type="text/javascript"></script>
		
		
		<script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}" type="text/javascript"></script>
		<!--end:: Vendor Plugins for custom pages -->

		<!--end::Global Theme Bundle -->

		<!--begin::Page Vendors(used by this page) -->
		{{-- <script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script> --}}

		<!--end::Page Vendors -->

		<!--begin::Page Scripts(used by this page) -->
		<script src="{{ asset('js/pages/dashboard.js') }}" type="text/javascript"></script>
		
		<!--begin::Page Scripts(used by this page) -->
		<script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-daterangepicker.js')}}" type="text/javascript"></script>
		

		<!--end:: Vendor Plugins for custom pages -->

		<!--end::Global Theme Bundle -->

		<!--begin::Page Vendors(used by this page) -->
		<!--<script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>-->

		<!--end::Page Vendors -->

		<!--end::Page Scripts -->
		
		<!--<script src="{{ asset('chartist/chartist.min.js')}}"></script>
		<script src="{{ asset('chartist/chartist-plugin-tooltip.min.js')}}"></script>
		<script src="{{ asset('chartist/chartist-init.js')}}"></script> -->
		
		<!--<script src="{{ asset('js/pages/components/charts/morris-charts.js')}}" type="text/javascript"></script>-->
		<script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>
		
	<script>
	
	<!-- ---------- pre loader --------- -->
	
	(function($)
	{
	  'use strict';
		$(window).on('load', function () {
			if ($(".pre-loader").length > 0)
			{
				$(".pre-loader").fadeOut("slow");
			}
		});
	})(jQuery)
		
	<!-- -------------------------- -->>
		
	/*$('#kt_modal_2').on('show.bs.modal', function (e) {
    $('body').addClass("example-open");
	}).on('hide.bs.modal', function (e) {
		$('body').removeClass("example-open");
	})*/
		
	
	$("#btnChkPass").click(function()
	{
	var id=$("#admin_id").val();
	var new_pass=$("#new_pass").val();
	
	var re_pass=$("#re_pass").val();
	
	if(new_pass!=re_pass)
	{
		  $("#succ_mes").html("");
		  $("#err_mes").html("Confirm password not matching.");
	}
	else
	{
	jQuery.ajax({
			type: "post",
			asset: "{{asset('change_password')}}",
			dataType: 'html',
			data: {aid:id,new_pass:new_pass,_token: "{{csrf_token()}}"},
			success: function(res)
			{
			  if(res==1)
			   {
				   $("#err_mes").html("");
				   $("#succ_mes").html("Password successfully Changed.");
			   }
			   else
			   {
				   $("#succ_mes").html("");
				   $("#err_mes").html("Something wrong, try again.");
			   }
			   
			   /*$("#new_pass").val("");
			   $("#re_pass").val("");
			   $("#succ_mes").html("");
			   $("#err_mes").html("");*/
			}
		});
	}
});


$("#btnClose").click(function()
{
	$("#new_pass").val("");
	$("#re_pass").val("");
	$("#succ_mes").html("");
	$("#err_mes").html("");
});

			
	</script>
			
	@stack('scripts')
		
		
		
	</body>

	<!-- end::Body -->
</html>