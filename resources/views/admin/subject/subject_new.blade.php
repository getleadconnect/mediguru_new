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
.kt-quick-panel .kt-quick-panel__nav {
    padding: 0.7rem 0 0 0 !important;
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
						
						<li>
						<!--<div class="kt-header__topbar-item kt-header__topbar-item--quickpanel" data-toggle="kt-tooltip" title="Quick panel" data-placement="top">
								<div class="kt-header__topbar-wrapper">
									<span class="kt-header__topbar-icon" id="kt_quick_panel_toggler_btn"><i class="flaticon2-cube-1"></i>GGGGGG</span>
								</div>
							</div>
						</li>-->
						
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
									<th>Type</th>
									<th>Description</th>
									<!--<th>Marks</th>-->
									<th>Status</th>
									<th style="padding-left:20px;">Copy</th>
									<th width="110px">Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								</tr>
							</thead>
							<tbody>
							
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


  <div id="kt_quick_panel" class="kt-quick-panel">
			<a href="#" class="kt-quick-panel__close" style="border:1px solid #22b9ff;" id="kt_quick_panel_close_btn"><i class="flaticon2-delete" style="color:red;"></i></a>
			<div class="kt-quick-panel__nav">
				<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand  kt-notification-item-padding-x" role="tablist">
					<li class="nav-item active">
						<a class="nav-link active" data-toggle="tab" href="#kt_quick_panel_tab_notifications" role="tab">COPY SUBJECT</a>
					</li>
				</ul>
			</div>
			
			<div class="kt-quick-panel__content" style="padding-top:7px;">
				<div class="tab-content">
					<div class="tab-pane fade show kt-scroll active" id="kt_quick_panel_tab_notifications" role="tabpanel">
						<div class="kt-notification">
							
							<div class="row ml-3 mr-3">
							<div class="col-lg-12 col-xl-12 col-xxl-12">
							
							<form id="frmCopySubject" method="post" enctype="multipart/form-data">
								@csrf
								
								<label id="lbl_msg">Welcome</label>
								
								<div class="row">
									<div class="col-lg-12 col-xl-12 col-xxl-12">
									
									<fieldset class="pl-2 pr-2" style="border:1px solid #e4e4e4;">
									<legend style="font-size:13px;width:120px;font-weight:600;">Selected Subject</legend>

										<div class="form-group">
											<input type="hidden" class="form-control" id="lesson_ids" name="lesson_ids" value="" readonly> 
											<input type="hidden" class="form-control" id="sel_subject_id" name="sel_subject_id" value=""> 
											<input type="text" class="form-control" id="sel_subject_name" name="sel_subject_name" value="" readonly> 
											
										</div>
										
										<div class="form-group">
										<div class="row">
										<label class="col-lg-6 col-xl-6 col-xxl-6">No of lessons in subject :</label>
										<label class="col-lg-4 col-xl-4 col-xxl-4" id="no_of_lessons">10</label>
										</div>

										<label style="color:#000;"><b><u>Lessons Items</u></b></label>
										
										<style>
										table tr
										{
											height:25px;
										}
										</style>
										
										<div class="form-group">
										<div class="row">
										<div class="col-lg-12 col-xl-12 col-xxl-12">
										<table width="100%">
											<tr><td>No of videos</td><td width="100px"><span id="no_of_videos"></span></td></tr>
											<tr><td>No of Tests</td><td><span id="no_of_mcq_test"></span></td></tr>
											<tr><td>No of PDFs</td><td><span id="no_of_pdfs"></span></td></tr>
											<tr><td>No of live Tests</td><td><span id="no_of_live_test"></span></td></tr>
										</table>
										</div>
										</div>
										</div>
									
									</fieldset>


									<fieldset class="mt-3 pl-2 pr-2" style="border:1px solid #7fbf7f;">
									<legend style="font-size:13px;width:150px;font-weight:600;color:#094d09">Copy subject to course</legend>

									<div class="form-group">
										<label >New subject Name : </label>
										<input type="text" class="form-control" id="new_subject_name" name="new_subject_name" value="" required> 
									</div>
									
									<div class="form-group">
									<div class="row">
									<div class="col-lg-9 col-xl-9 col-xxl-9">
										<label >Subject Icon : </label>
										<input type="file" class="form-control" onchange="fileValidation(this);" id="new_subject_icon" name="new_subject_icon" required> 
									</div>
									<div class="col-lg-3 col-xl-3 col-xxl-3">
										<img src="" id="ns_icon_output" style="width:60px;height:60px;"> 
									</div>
									</div>
									</div>
																		

									<div class="form-group">
										<label>Select course to create subject</label>
										<select id="copy_course_id" class="form-control" name="copy_course_id"  required>
										 <option value="">--select--</option>
										  @foreach($crs as $r)
										    <option value="{{$r->id}}">{{ $r->course_name }}</option>
										  @endforeach
										</select>
									</div>
									</fieldset>
									<!-- <hr style="margin:5px 0px;">-->
									<div class="row mt-2">
									<div class="col-lg-12 col-xl-12 col-xxl-12 text-right">
										<button type="submit" class="btn btn-primary"> Submit </button>
										<button type="button" id="close_kt_quick_panel_btn" class="btn_close_right_panel btn btn-danger" data-dismiss="modal" >Close</button>
									</div>
									</div>
								</div>
								</div>
							 </form>
							</div>
							</div>

						</div>
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
										<input type="file" onchange="fileValidation(this);" id="subject_icon" class="form-control" name="subject_icon" required>
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
								<div class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">
								<label>Subject Type </label>
								</div>
								<div class="col-lg-4 col-xl-4 col-xxl-4">
								<select id="subject_type" class="form-control input-default " name="subject_type" required>
								<option value="">--select--</option>
								<option value="MCQ">MCQ</option>
								<option value="OTHERS">OTHERS</option>
								</select>
							   </div>
							
							 <!-- <div class="col-lg-4 col-xl-4 col-xxl-4">
								<label>Question Mark </label>
								<input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="question_mark" required>
							  </div>
							 
								<div class="col-lg-4 col-xl-4 col-xxl-4">
								<label>Negative Mark </label>
									<input type="text" class=" form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  name="negative_mark" required>
								</div>-->

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
	
	$("input[type='search']").wrap("<form>");  //for datatable search box fill remove
	$("input[type='search']").closest("form").attr("autocomplete","off");

 });
 
 $(document).on('click',"#kt_quick_panel_close_btn",function()
 {
	 //$(".kt-quick-panel").removeClass('kt-quick-panel--on');
	  $(".kt-quick-panel").fadeOut(600,function(){
		 $(".kt-quick-panel").removeClass('kt-quick-panel--on');
	 });
 });
 
 $(document).on('click',"#close_kt_quick_panel_btn",function()
 {
	 $(".kt-quick-panel").fadeOut(600,function(){
		 $(".kt-quick-panel").removeClass('kt-quick-panel--on');
	 });
	 
 });
  
 
 var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :10,
		scrollX: true,
		ordering:false,
		
		'pagingType':"simple_numbers",
        'lengthChange': true,
		
		language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                    lengthMenu: '_MENU_ page',
                },
                lengthMenu: [
                    [10, 25, 50, 100, 150, -1],
                    [10, 25, 50, 100, 150, "All"]
                ],
		
        ajax: {
			url:"view_subjects",
			data: function (data) 
		    {
				data.search = $('input[type="search"]').val();
		    },
		},
		
		columnDefs:[
				  {"width":"50px","targets":1},
				  {"width":"80px","targets":6},
				  {"width":"100px","targets":8},
				],

        columns: [
            {"data": "id" },
			{"data": "cimg" },
			{"data": "cname" },
			{"data": "sname" },
			{"data": "stype" },
			{"data": "desc" },
			//{"data": "mark" },
			{"data": "status" },
			{"data": "scopy" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
    });
 

 $('#btnAdd').click(function()
 {
	$("#icon_output").attr('src','');
 });


 $("#subject_icon").change(function()
 {
      var file = document.getElementById("subject_icon").files[0];
      if (file) {
          var reader = new FileReader();
        reader.onload = function() {
              $("#icon_output").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
      }
 });
 
 $("#new_subject_icon").change(function() {
      var file = document.getElementById("new_subject_icon").files[0];
      if (file) {
          var reader = new FileReader();
        reader.onload = function() {
              $("#ns_icon_output").attr("src", reader.result);
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


$('#datatable tbody').on( 'click', '.btnCopySubject', function()
{
	var sid=$(this).attr('id');
	
		//var Result=$("#kt_modal_3 .modal-body");
		//$(this).attr('data-target','#kt_modal_3');
		
		$("#ns_icon_output").attr('src',"");
		$("#new_subject_icon").val("");

		jQuery.ajax({
			type: "GET",
			url: "subject_detail_for_copy"+"/"+sid,
			dataType: 'json',
			//data: {vid: vid},
			success: function(res)
			{
				
			  $("#lbl_msg").html("&nbsp;");
			  console.log(res.subjects.id);
			  console.log(res.subjects.subject_name);
			  
			  $("#sel_subject_id").val(res.subjects.id);
			  $("#sel_subject_name").val(res.subjects.subject_name);
			  
			  $("#no_of_lessons").html(res.details['no_of_lessons']);
			  $("#no_of_live_test").html(res.details['no_of_live_test']);
			  $("#no_of_mcq_test").html(res.details['no_of_mcq_test']);
			  $("#no_of_videos").html(res.details['no_of_videos']);
			  $("#no_of_pdfs").html(res.details['no_of_pdfs']);
			  $("#lesson_ids").val(res.details['lesson_ids']);
			  
			   $(".kt-quick-panel").fadeIn(0,function(){
				    $(".kt-quick-panel").addClass('kt-quick-panel--on');
			   });

			}
		});
 });

   
$("form#frmCopySubject").submit(function(e)
{
   e.preventDefault();    

	if($("#share_subject_id").val()!='' && $("#new_subject_name").val()!='' && $("#share_course_id").val()!="")
	{
		
	  var mob=$("#country_code").val()+$("#mobile").val();
	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('copy_subject_to_course')}}",
          type: 'post',
          data: formData,
          success: function (res) 
		  {
			if(res==1)
			{

				$("#sel_subejct_id").val('');
				$("#sel_subejct_name").val('');
				$("#ns_icon_output").attr('src','');
				$("#new_subject_icon").val('');
				$("#copy_course_id").val('');
				
				$("#close_kt_quick_panel_btn").trigger('click');
				
				console.log(res);
				
				Swal.fire({
					  position: "top-end",
					  icon: "success",
					  title: "New subject successfully created.!",
					  showConfirmButton: true
					  //timer: 1500
					});

			}
			else
			{
				Swal.fire({
					  icon: "error",
					  title: "Oops...",
					  text: "Somthing wrong, Try again!"
					});
			}
          },
			cache: false,
			contentType: false,
			processData: false
		});
	}
	else
	{
		$("#lbl_msg").html("<span style='color:red;font-size:12px;'>New Subject Name/Course is missing, Try again.!</span>");
	}
});


function fileValidation(input)
{
	 //var fileInput = document.getElementById('subject_icon'); 
	var fileInput = input; 
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





