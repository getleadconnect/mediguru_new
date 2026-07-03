@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')
<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Dashboard
	</h3>
</div>
</div>

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

<!--begin:: Widgets/Stats-->
		<div class="kt-portlet">
			<div class="kt-portlet__body  kt-portlet__body--fit">
				<div class="row row-no-padding row-col-separator-lg">
					<div class="col-md-3 col-lg-3 col-xl-3">

						<!--begin::Total Profit-->
						<div class="kt-widget24">
							<div class="kt-widget24__details">
								<div class="kt-widget24__info">
									<h4 class="kt-widget24__title">
										<b>Students</b>
									</h4>
									<span class="kt-widget24__desc">
										Registred Students
									</span>
								</div>
								<span class="kt-widget24__stats kt-font-brand">
									123
								</span>
							</div>
							<div class="progress progress--sm">
								<div class="progress-bar kt-bg-brand" role="progressbar" style="width: 78%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<!--<div class="kt-widget24__action">
								<span class="kt-widget24__change">
									Change
								</span>
								<span class="kt-widget24__number">
									78%
								</span>
							</div> -->
						</div>

						<!--end::Total Profit-->
					</div>
					<div class="col-md-3 col-lg-3 col-xl-3">

						<!--begin::New Feedbacks-->
						<div class="kt-widget24">
							<div class="kt-widget24__details">
								<div class="kt-widget24__info">
									<h4 class="kt-widget24__title">
										<b>Subscriptions</b>
									</h4>
									<span class="kt-widget24__desc">
										Subscribed Students
									</span>
								</div>
								<span class="kt-widget24__stats kt-font-warning">
									1349
								</span>
							</div>
							<div class="progress progress--sm">
								<div class="progress-bar kt-bg-warning" role="progressbar" style="width: 84%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<!--<div class="kt-widget24__action">
								<span class="kt-widget24__change">
									Change
								</span>
								<span class="kt-widget24__number">
									84%
								</span>
							</div> -->
						</div>

						<!--end::New Feedbacks-->
					</div>
					<div class="col-md-3 col-lg-3 col-xl-3">

						<!--begin::New Orders-->
						<div class="kt-widget24">
							<div class="kt-widget24__details">
								<div class="kt-widget24__info">
									<h4 class="kt-widget24__title">
										<b>Payments</b>
									</h4>
									<span class="kt-widget24__desc">
										Purchased Amount
									</span>
								</div>
								<span class="kt-widget24__stats kt-font-danger">
									8964.00
								</span>
							</div>
							<div class="progress progress--sm">
								<div class="progress-bar kt-bg-danger" role="progressbar" style="width: 69%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<!--<div class="kt-widget24__action">
								<span class="kt-widget24__change">
									Change
								</span>
								<span class="kt-widget24__number">
									69%
								</span>
							</div>-->
						</div>

						<!--end::New Orders-->
					</div>
					<div class="col-md-3 col-lg-3 col-xl-3">

						<!--begin::New Users-->
						<div class="kt-widget24">
							<div class="kt-widget24__details">
								<div class="kt-widget24__info">
									<h4 class="kt-widget24__title">
										<b>Users</b>
									</h4>
									<span class="kt-widget24__desc">
										Joined Users
									</span>
								</div>
								<span class="kt-widget24__stats kt-font-success">
									276
								</span>
							</div>
							<div class="progress progress--sm">
								<div class="progress-bar kt-bg-success" role="progressbar" style="width: 90%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
							<!--<div class="kt-widget24__action">
								<span class="kt-widget24__change">
									Change
								</span>
								<span class="kt-widget24__number">
									90%
								</span>
							</div> -->
						</div>

						<!--end::New Users-->
					</div>
				</div>
			</div>
		</div>
		
<!--begin:: Widgets/Stats-->
		<div class="kt-portlet">
			<div class="kt-portlet__body  kt-portlet__body--fit">
				<div class="row row-no-padding row-col-separator-lg">
					<div class="col-md-3 col-lg-3 col-xl-3">
						<!--begin::Total Profit-->
						<div class="kt-widget24" style="padding:15px;">
						
									<div class="row"> <!-- newely added --->
									   <div class="col-lg-12">
										  <div class="kt-widget24__details">
											<div class="kt-widget24__info">
												
												<!--<h4 class="kt-widget24__title"><b>Students</b></h4>	-->
												
												<span class="kt-widget24__desc">
													<h6 style="font-size:1.1rem;color: #595d6e;margin-top:7px;"><b>Today</b></h6>
												</span>
											</div>
											<span class="kt-widget24__stats kt-font-brand">
												
												<div class="dropdown dropdown-inline">
													<button type="button" class="btn btn-hover-brand btn-elevate-hover btn-icon btn-sm btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<i class="flaticon-more"></i>
													</button>
													<div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(-149px, -191px, 0px); top: 0px; left: 0px; will-change: transform;">
														<a class="dropdown-item" href="#"><i class="la la-plus"></i> New Report</a>
														<a class="dropdown-item" href="#"><i class="la la-user"></i> Add Customer</a>
														<a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New Download</a>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
													</div>
												</div>
	
											</span>
										  </div>
									   </div>
									</div>
						
							<div class="kt-widget24__details">
								<div class="kt-widget24__info">
									
									<!--<h4 class="kt-widget24__title"><b>Students</b></h4>	-->
									
									<span class="kt-widget24__desc">
										Registred Students
									</span>
								</div>
								<span class="kt-widget24__stats kt-font-brand">
									123
								</span>
							</div>
							
						</div>

						<!--end::Total Profit-->
					</div>
					
					<div class="col-md-3 col-lg-3 col-xl-3">
						<!--begin::Total Profit-->
						<div class="kt-widget24" style="padding:15px;">
						
									<div class="row"> <!-- newely added --->
									   <div class="col-lg-12">
										  <div class="kt-widget24__details">
											<div class="kt-widget24__info">
												
												<!--<h4 class="kt-widget24__title"><b>Students</b></h4>	-->
												
												<span class="kt-widget24__desc">
													<h6 style="font-size:1.1rem;color: #595d6e;margin-top:7px;"><b>Today</b></h6>
												</span>
											</div>
											<span class="kt-widget24__stats kt-font-brand">
												
												<div class="dropdown dropdown-inline">
													<button type="button" class="btn btn-hover-brand btn-elevate-hover btn-icon btn-sm btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<i class="flaticon-more"></i>
													</button>
													<div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(-149px, -191px, 0px); top: 0px; left: 0px; will-change: transform;">
														<a class="dropdown-item" href="#"><i class="la la-plus"></i> New Report</a>
														<a class="dropdown-item" href="#"><i class="la la-user"></i> Add Customer</a>
														<a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New Download</a>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
													</div>
												</div>
	
											</span>
										  </div>
									   </div>
									</div>
						
							<div class="kt-widget24__details">
								<div class="kt-widget24__info">
									
									<!--<h4 class="kt-widget24__title"><b>Students</b></h4>	-->
									
									<span class="kt-widget24__desc">
										Registred Students
									</span>
								</div>
								<span class="kt-widget24__stats kt-font-brand">
									123
								</span>
							</div>
							
						</div>

						<!--end::Total Profit-->
					</div>
					
					<div class="col-md-3 col-lg-3 col-xl-3">
						<!--begin::Total Profit-->
						<div class="kt-widget24" style="padding:15px;">
						
									<div class="row"> <!-- newely added --->
									   <div class="col-lg-12">
										  <div class="kt-widget24__details">
											<div class="kt-widget24__info">
												
												<!--<h4 class="kt-widget24__title"><b>Students</b></h4>	-->
												
												<span class="kt-widget24__desc">
													<h6 style="font-size:1.1rem;color: #595d6e;margin-top:7px;"><b>Today</b></h6>
												</span>
											</div>
											<span class="kt-widget24__stats kt-font-brand">
												
												<div class="dropdown dropdown-inline">
													<button type="button" class="btn btn-hover-brand btn-elevate-hover btn-icon btn-sm btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<i class="flaticon-more"></i>
													</button>
													<div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(-149px, -191px, 0px); top: 0px; left: 0px; will-change: transform;">
														<a class="dropdown-item" href="#"><i class="la la-plus"></i> New Report</a>
														<a class="dropdown-item" href="#"><i class="la la-user"></i> Add Customer</a>
														<a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New Download</a>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
													</div>
												</div>
	
											</span>
										  </div>
									   </div>
									</div>
						
							<div class="kt-widget24__details">
								<div class="kt-widget24__info">
									
									<!--<h4 class="kt-widget24__title"><b>Students</b></h4>	-->
									
									<span class="kt-widget24__desc">
										Registred Students
									</span>
								</div>
								<span class="kt-widget24__stats kt-font-brand">
									123
								</span>
							</div>
							
						</div>

						<!--end::Total Profit-->
					</div>
					
					<div class="col-md-3 col-lg-3 col-xl-3">
						<!--begin::Total Profit-->
						<div class="kt-widget24" style="padding:15px;">
						
									<div class="row"> <!-- newely added --->
									   <div class="col-lg-12">
										  <div class="kt-widget24__details">
											<div class="kt-widget24__info">
												
												<!--<h4 class="kt-widget24__title"><b>Students</b></h4>	-->
												
												<span class="kt-widget24__desc">
													<h6 style="font-size:1.1rem;color: #595d6e;margin-top:7px;"><b>Today</b></h6>
												</span>
											</div>
											<span class="kt-widget24__stats kt-font-brand">
												
												<div class="dropdown dropdown-inline">
													<button type="button" class="btn btn-hover-brand btn-elevate-hover btn-icon btn-sm btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														<i class="flaticon-more"></i>
													</button>
													<div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; transform: translate3d(-149px, -191px, 0px); top: 0px; left: 0px; will-change: transform;">
														<a class="dropdown-item" href="#"><i class="la la-plus"></i> New Report</a>
														<a class="dropdown-item" href="#"><i class="la la-user"></i> Add Customer</a>
														<a class="dropdown-item" href="#"><i class="la la-cloud-download"></i> New Download</a>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item" href="#"><i class="la la-cog"></i> Settings</a>
													</div>
												</div>
	
											</span>
										  </div>
									   </div>
									</div>
						
							<div class="kt-widget24__details">
								<div class="kt-widget24__info">
									
									<!--<h4 class="kt-widget24__title"><b>Students</b></h4>	-->
									
									<span class="kt-widget24__desc">
										Registred Students
									</span>
								</div>
								<span class="kt-widget24__stats kt-font-brand">
									123
								</span>
							</div>
							
						</div>

						<!--end::Total Profit-->
					</div>
				</div>
			</div>
		</div>		

<div class="row">
<div class="col-xl-6">

		<!--begin:: Widgets/Sale Reports-->
		<div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						Analytics : &nbsp;&nbsp;<a href="{{ url('question_attendees')}}" class="btn btn-primary" style="padding:3px 15px 3px 15px;"> Question Attendees</a></h4>
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<!--<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#kt_widget11_tab1_content" role="tab">
								Last Month
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#kt_widget11_tab2_content" role="tab">
								All Time
							</a>
						</li>  -->
					</ul>
				</div>
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->
				
				<div class="row">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<div class="card" style="height:390px !important;">	
						<div class="card-header" style="padding-left:10px;">
							<h4 class="card-title" style="font-size:14px;">Analytics ( Mock Test Attended)</h4>
						</div>
						
						<!-- to change chart area width ----->
						<input type="hidden" id="chart_column_count" value="{{ $qpaper_count }}">
						<input type="hidden" id="chart_leg_text" value="{{ $leg_text }}"> <!--- Question papers --->
						<input type="hidden" id="chart_data1" value="{{ $tot_stud_count }}"> <!-- total students -->
						<input type="hidden" id="chart_data2" value="{{ $qp_att_st_count }}"><!--  attended student count --->
						
						<!-- ---------------------------- -->

						<div class="card-body">
						<div class="row">
						<div class="col-xl-12 col-xxl-12 col-lg-12 text-right pr-5">
						<label ><span style="background-color:#2497ca;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Total Students</label>					
						<label class="pl-3" ><span style="background-color:#2bc155;">&nbsp;&nbsp;&nbsp;&nbsp;</span> Attended Students</label> 	
						</div>
						</div>

						<div style="width:100%;height:290px;overflow-x:scroll;">
							<div id="multi-line-chart" class="ct-chart ct-golden-section chartlist-chart">
						</div>
						</div>
						</div>
						</div>
					</div>
					</div>

				
				<!--End:: Content-->
			</div>
		</div>

		<!--end:: Widgets/Sale Reports-->
	</div>
	</div>

<!--End::Dashboard 4-->
</div>
@push('scripts')
<script>


</script

@endpush

@endsection
