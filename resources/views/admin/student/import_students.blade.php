@extends('admin.layouts.master')
@section('contents')

<style>
.btn-accordion
{
	margin-top: 10px;
	padding: 5px 10px 5px 10px !important;
    height: 35px;
}
.card {
    border:none !important;
}
.fa
{
	font-size:13px !important;
}
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Import Student Details
	</h3>
</div>
</div>

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

<div class="row">
<div class="col-lg-12 col-xl-12 col-xxl-12">

		<!--begin:: Widgets/Sale Reports-->
		<div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						Import Students Details
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<!--<a href="{{url('questions')}}" class="btn-accordion btn btn-primary btn-xs"><i class="flaticon2-left-arrow"></i> Back </a>-->
						</li>
					</ul>
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->
				
				<!--begin::Accordion-->
				
				<div class="row">
					<div class="col-xl-12 col-xxl-12 col-lg-12">

							<style>
							.st-ul li
							{
								color:blue;
							}
							</style>
							<ul class="st-ul mt-2 mb-3">
								<li class="pb-2"><u>Steps:</u></li>
								<li class="pb-2"><b>1. </b>To import bulk student details, <a style="color:blue" href="{{ url('excel_template/bulk_student_template.xlsx')}}" download="bulk_student_template.xlsx"><span style="font-weight:700;font-size:14px;">Click Here</span></a>
								to download Excel Template file.</li>
								<li class="pb-2"><b>2. </b>Open Excel file and add student details into the file. And Save the file</li>
							    <li class="pb-2"><b>3. </b>then select excel file below and click SUBMIT button.</li> 
							</ul>
														
							<form method="post" action="{{url('import_student_users')}}" enctype="multipart/form-data">
							@csrf

							<div id="quest_image" class="form-group">
								<div class="row">
								
								<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Select Excel File (.xlsx)</label>
								<div class="col-lg-5 col-cl-5 col-xxl-5">
								<input type="file" onchange="fileValidation();" id="excel_file" class="form-control" name="file" required>
								</div>
								<div class="col-xl-4 col-xxl-4 col-lg-4">
							    <img src="" id="image_output" style="width:200px;">
							  </div>
							 </div>
							</div>

							<div class="form-group">
							  <div class="row">
								<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">&nbsp;</label>
								<div class="col-lg-5 col-xl-5 col-xxl-5 text-right">
									<button type="submit" class="btn btn-primary"> Submit </button>
							  </div>
							 </div>
							</div>
						
						</form>
						</div>	
				
				</div>

				<!--End:: Content-->
			</div>
		<!--end:: Widgets/Sale Reports-->
	  </div>
     </div>
   </div>
</div>
<!--begin::Modal-->
	<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					
					
				</div>
				
			</div>
		</div>
	</div>

	<!--end::Modal-->

@push('scripts')
<!--<script src="{{ asset('js/pages/crud/datatables/advanced/column-rendering.js')}}" type="text/javascript"></script>-->
<script>

$(document).ready(function()
 {
	var mes=$('#view_message').val().split('#');
	if(mes[0]=="success")
	{	
	    toastr.success(mes[1]);
	}
	else if(mes[0]=="danger")
	{
		toastr.error(mes[1]);
	}
 });


 $('#btnAdd').click(function()
 {
	$("#icon_output").attr('src','');
 });


$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});



</script

@endpush

@endsection





