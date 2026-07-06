<!-- SUB COURSES------------------------------------->
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
.note-editable
{
	min-height:100px;
}
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Course Subjects
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
						Subjects List
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs"  data-toggle="modal" data-target="#kt_modal_2">
							 Add Subjects
							</button>
						</li>
						
						<li class="nav-item">
							<button type="button" id="btnShareSubject" class="btn-accordion btn btn-primary btn-xs"  data-toggle="modal" data-target="#kt_modal_3">
							 Share Subjects
							</button>
						</li>
						
					</ul>
					
					
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<div class="row mt-3">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							<thead>
								<tr>
									<th>Id</th>
									<th>Icon</th>
									<th>Course</th>
									<th width="170px">Subject Name</th>
									<th >Type</th>
									<th>Description</th>
									<th>Marks</th>
									<th>Status</th>
									<th width="90px">Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								</tr>
							</thead>
							<tbody>
							@if(!empty($sub))
							@foreach($sub as $r)
							<tr>
								<td>{{$r->id}}</td>
								<td><img src="{{ config('constants.file_path').$r->subject_icon}}" style="width:50px;height:50px"></td>
								<td>{{$r->course_name}}</td>
								<td>{{$r->subject_name}}
								@if($r->subscription_end_date!="")
								<br><span title="Subscription end date" style="color:#f54138;">Expiry: {{date_create($r->subscription_end_date)->format('d-m-Y')}}</span>
								@endif
								<br><span title="App store product id" style="color:#2b489b;">App ID: {{$r->app_store_product_id}}</span>
								@php
									if($r->ios_subscription_type==1){ $ios_type="Subscription";}
									else if($r->ios_subscription_type==2){ $ios_type="Consumable";}
									else { $ios_type="";}
								@endphp
								<br><span title="Subscriptin Type" style="color:#2b489b;">Type: {{$ios_type}}</span>
								</td>
								<td>{{$r->subject_type}}</td>
								<td>{!! $r->description !!}</td>
								<td>Mark:{{$r->question_mark}}<br> Neg:{{$r->negative_mark }}</td>
								<td>
								@if($r->status==1)
								<span class="badge badge-success">Active</span>
								@else
								<span class="badge badge-danger">Inactive</span>
								@endif
								</td>
								<td style="width:90px;">
									<a href="" id="{{$r->id}}" class="edit btn bt-brand btn-secondary btn-elevate btn-circle btn-icon" data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a> 
									<a href="{{url('delete_subject').'/'.$r->id}}" id="conf" class="btn bt-danger btn-secondary btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a> 
									@if($r->status==1)
									<a href="{{url('deactivate_subject').'/'.$r->id}}" class="btn bt-warning btn-secondary btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a> 	
									@else
									<a href="{{url('activate_subject').'/'.$r->id}}" class="btn bt-success btn-secondary btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a> 	
									@endif
									<a href="" id="{{$r->id}}" class="shareBtn btn bt-primary btn-secondary btn-elevate btn-circle btn-icon" data-toggle="modal" title="Share Subjects"><i class="fa fa-share-alt"></i></a> 
								</td>
							</tr>
							@endforeach
							@endif
							</tbody>
						</table>
					</div>
				
				</div>

				<!--End:: Content-->
		</div>

		<!--end:: Widgets/Sale Reports-->
	  </div>
     </div>
   </div>
</div>

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


<!--begin::Modal-->
	<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Subjects</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body" style="padding:15px 30px;">
					
					<form method="post" action="" enctype="multipart/form-data">
							@csrf
							<div class="row">
							<div class="col-lg-12 col-xl-12 col-xxl-12">
							
							<div class="form-group">
								<div class="row">
								<div class="col-xl-8 col-xxl-8 col-lg-8">
									<label>Subject Icon(.jpg|.png only) </label>
										<input type="file" onchange="fileValidation();" id="subject_icon" class="form-control" name="subject_icon" required>
								</div>
								<div class="col-xl-4 col-xxl-4 col-lg-4">
									<img src="" id="icon_output" style="width:80px;">
								</div>
								</div>
							</div>
									
							<div class="form-group">
							  <div class="row">
								<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Course</label>
								<div class="col-lg-9 col-xl-9 col-xxl-9">
								<select id="course_id" class="form-control" name="course_id"   required>
								 <option value="">--select--</option>
								 @foreach($crs as $r)
								   <option value="{{$r->id}}">{{ $r->course_name }}</option>
								 @endforeach
								</select>
							 </div>
							</div>
							</div>
							
							<div class="form-group">
							 <div class="row">
								<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Subject Name </label>
								<div class="col-lg-9 col-xl-9 col-xxl-9">
								<input type="text" id="subject_name" class="form-control" name="subject_name" required>
							</div>
							</div>
							</div>
							
							
														
							<div class="form-group">
							  <div class="row">
								<div class="col-lg-4 col-xl-4 col-xxl-4">
								<label>Subject Type </label>
								<select id="subject_type" class="form-control input-default " name="subject_type" required>
								<option value="">--select--</option>
								<option value="MCQ">MCQ</option>
								<option value="OTHERS">OTHERS</option>
								</select>
							   </div>
							
							  <div class="col-lg-4 col-xl-4 col-xxl-4">
								<label>Question Mark </label>
								<input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="question_mark" required>
							  </div>
							 
								<div class="col-lg-4 col-xl-4 col-xxl-4">
								<label>Negative Mark </label>
									<input type="text" class=" textarea form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  name="negative_mark" required>
								</div>
							</div>
							</div>
							
							
							<div class="form-group">
							 <div class="row">
							 <div class="col-lg-7 col-xl-7 col-xxl-7">
								<label class="">App Store Product Id </label>
								<input type="text" id="app_store_product_id" class="form-control" name="app_store_product_id" required>
							</div>
							<div class="col-lg-5 col-xl-5 col-xxl-5">
							<label class="">Subscription Type(IOS)</label>
							<select name="subscription_type" class="form-control" required>
										<option value="">--select--</option>
										<option value="1">Subscription</option>
										<option value="2">Consumable</option>
									</select>
							</div>
							</div>
							</div>
							
							
							<div class="form-group" style="padding:3px 10px;">
							  <div class="row">
								<label>Description </label>
								<textarea rows=3 class=" textarea form-control" name="description" required></textarea>
							  </div>
							</div>
							
							<label style="color:blue;">To set subscription end date</label>  
							   <div class="row">
							   
								<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">Subscription End Date </label>
								<div class="col-lg-6 col-xl-6 col-xxl-6">
								<div class="input-group" style="width:150px;">
									<input type="date" class="form-control" style="width:150px;" name="subscription_end_date" id="subscription_end_date" required>
								</div>
							   </div>
							   </div>
							   
							
							<div class="form-group mt-3" style="background:#e4e4e4;padding:5px 10px;">
							
							<label style="color:blue;">To create subject Package - Enter below details</label>
							  <div class="row">
								<div class="col-lg-6 col-xl-6 col-xxl-6">
								<label>Package Rate </label>
								<div class="input-group" style="width:150px;">
										<div class="input-group-prepend"><span class="input-group-text">₹</span></div>
										<input type="number" class="form-control" id="package_rate" name="package_rate" placeholder="rate" required>
									</div>
							   </div>
							   <div class="col-lg-6 col-xl-6 col-xxl-6">
								<label>IOS Rate </label>
								<div class="input-group" style="width:150px;">
										<div class="input-group-prepend"><span class="input-group-text">$</span></div>
										<input type="number" class="form-control" id="ios_rate" name="ios_rate" placeholder="rate" required>
									</div>
							   </div>

							</div>

							  <div class="row mt-2">
							   <div class="col-lg-6 col-xl-6 col-xxl-6">
							   <label >Start Date </label>
								<input type="date" class="form-control" style="width:150px;" name="start_date" required>
							  </div>
							  <div class="col-lg-6 col-xl-6 col-xxl-6">
								<label>Expiry Date </label>
								<input type="date" class="form-control" style="width:150px;" name="expiry_date" required>
							  </div>
							</div>
							</div>
							
							
							
							
						<hr style="margin:5px 0px;">

						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12 text-right">
							<button type="submit" class="btn btn-primary"> Submit </button>
							<button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
						</div>
						</div>
					</div>
					</div>
						</form>
				</div>
				
			</div>
		</div>
	</div>

	<!--end::Modal-->
	
	
	
	<!--begin::Modal-->
	<div class="modal fade" id="kt_modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Share Subjects</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body" style="padding:15px 30px;">
			
				</div>
				
			</div>
		</div>
	</div>

	<!--end::Modal-->


@push('scripts')
<!--<script src="{{ asset('js/pages/crud/datatables/advanced/column-rendering.js')}}" type="text/javascript"></script>-->
<script>

//$(".textarea").summernote();

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
 
var table=$('#datatable').DataTable({
	"processing": true,
	'paging':true,
	'pageLength':10,
	'bDestroy':true,
	'saveState':true,
 });
 

 $('#btnAdd').click(function()
 {
	$("#icon_output").attr('src','');
 });


 $("#subject_icon").change(function() {
      var file = document.getElementById("subject_icon").files[0];
      if (file) {
          var reader = new FileReader();
        reader.onload = function() {
              $("#icon_output").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
      }
 });


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_subject"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
		
  });


$('#datatable tbody').on( 'click', '.shareBtn', function ()
{
	var sid=$(this).attr('id');
		var Result=$("#kt_modal_3 .modal-body");
		$(this).attr('data-target','#kt_modal_3');

		jQuery.ajax({
			type: "GET",
			url: "subject_detail_for_share"+"/"+sid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			  Result.html(res);
			}
		});
		
  });


function fileValidation()
{
	 var fileInput = document.getElementById('subject_icon'); 
	 var allowedExtensions="";

		allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	          
		 var filePath = fileInput.value; 
					
            if (!allowedExtensions.exec(filePath)) { 
                alert('Invalid file type, Try again.'); 
                fileInput.value = ''; 
                return false; 
			}
			else
			{
				return true;
			}
}

$("#course_id").change(function()
{
	var cid=$(this).val();
	if(cid!="")
	{
	    jQuery.ajax({
			type: "GET",
			url: "get_course_subscription_end_date"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#subscription_end_date").val(res);
			}
		});
	}
	
});



$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});



</script

@endpush

@endsection





