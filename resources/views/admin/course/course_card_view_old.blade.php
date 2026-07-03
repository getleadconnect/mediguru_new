@extends('admin.layouts.master')
@section('contents')


<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('css/drag-style.css')}}">
<script src="{{ asset('plugins/general/jquery/dist/jquery.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/jquery-ui.js')}}"></script>

<style>

.card {
    border:none !important;
}
.fa
{
	font-size:13px !important;
}
.note-editable
{
	min-height:110px !important;
}

.kt-portlet.kt-portlet--head-xl .kt-portlet__head {
				min-height: 50px !important;
			}
			
.kt-notification-v2 .kt-notification-v2__item .kt-notification-v2__itek-wrapper .kt-notification-v2__item-desc {
    font-size: 1rem;
    font-weight: 300;
    color: #000;
}

.kt-notification-v2__item-desc p
{
	margin:0px;
}

.kt-notification-v2__item-desc span
{
	color:#113483;
	font-weight:600;
	padding-right:10px;
}
			
/* re-order  style -------*/
 #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.2em; min-height: 45px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }

 .card {    border:none !important; }
 .fa{font-size:13px !important; }
 #sortable li:hover { 	cursor:pointer; }

 ol li{ 	height:25px; 	font-weight:600;	color:#4646d1; }
/*--------------------------------------*/
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Courses
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
						Course List
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs" aria-expanded="false" data-toggle="modal" data-target="#kt_modal_2" >
							 Add Course
							</button>
						</li>
						
						<li class="nav-item">
							<button type="button" id="btnReOrder" class="btn-accordion btn btn-primary btn-xs" aria-expanded="false" data-toggle="modal" data-target="#kt_modal_4" >
							 Re-Order Course
							</button>
						</li>
						
					</ul>
				</div>
				
			</div>
			<div class="kt-portlet__body">
			
			<div class="row mt-2">

			@if(!empty($crs))
			@foreach($crs as $key=>$r)
						
					@php 
					if($r->course_type==1){ $color='#8b8988';}else { $color='#6fa36d';}
					@endphp
						
					<div class="col-lg-4">

								<div class="kt-portlet kt-portlet--head-xl kt-portlet--mobile" style="border:1px solid #d9efda; border-radius:5px;">
										<div class="kt-portlet__head" style="background:{{$color}};">
											<div class="kt-portlet__head-label">
												<h3 class="kt-portlet__head-title" style="font-size:14px;">
												<b><span class="kt-badge kt-badge--warning kt-badge--md">{{$r->reorder_no}}</span> {{ $r->course_name }}</b>
												</h3>
											</div>
											<div class="kt-portlet__head-toolbar" style="margin-top: 10px;margin-right: -10">
												<div class="dropdown dropdown-inline">
													<a href="#" class="btn btn-default btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background:#a7d1a9;">
														<i class="flaticon-more-1" style="color:#fff;"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right">
														<ul class="kt-nav">
															<li class="kt-nav__item">
																<a href="#" id="{{$r->id}}" class="edit kt-nav__link" data-toggle="modal">
																	<i class=" kt-nav__link-icon flaticon2-edit"></i>
																	<span class="kt-nav__link-text">Edit</span>
																</a>
															</li>
															
															<li class="kt-nav__item">
																<a href="{{url('delete_course').'/'.$r->id}}" class="kt-nav__link">
																	<i class="kt-nav__link-icon flaticon2-trash"></i>
																	<span class="kt-nav__link-text">Delete</span>
																</a>
															</li>
															
															@if($r->status==1)
							
															<li class="kt-nav__item">
																<a href="{{url('deactivate_course').'/'.$r->id}}" class="kt-nav__link">
																	<i class="kt-nav__link-icon flaticon2-cross"></i>
																	<span class="kt-nav__link-text">Deactivate</span>
																</a>
															</li>
															@else
															<li class="kt-nav__item">
																<a href="{{url('activate_course').'/'.$r->id}}" class="kt-nav__link" >
																	<i class="kt-nav__link-icon flaticon2-check-mark"></i>
																	<span class="kt-nav__link-text">Activate</span>
																</a>
															</li>
														@endif

														
															<li class="kt-nav__item">
																<a href="#" id="{{$r->id}}" data-toggle="modal"  class="fview kt-nav__link" >
																	<i class="kt-nav__link-icon flaticon2-file-1"></i>
																	<span class="kt-nav__link-text">View Features</span>
																</a>
															</li>
															
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="kt-portlet__body" style="background:#c4c4c4;">
										
										<div class="row">
											<div class="col-lg-3">
												<img src="{{ config('constants.file_path').$r->course_icon}}" style="width:50px;height:50px">
												</div>
												<div class="col-lg-7">
												
												@if($r->status==1)
													<span>Status:</span><span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span></label>
												@else
													Status:<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>
												@endif
												<label style="margin:0.3rem;">Unique Id :<b>{{ $r->unique_id }}</b></label>
												
												@if($r->subscription_end_date!="")
												<label style="margin: 0.3rem;" title="Subscription end date" >AE-Date :<b>{{date_create($r->subscription_end_date)->format('d-m-Y')}}</b></label>
												@endif
												
												</div>
										</div>
										<label style="margin-top:0.3rem;">IOS Product Id :<b>{{ $r->app_store_product_id }}</b></label>
										
										@php
											if($r->ios_subscription_type==1){ $ios_type="Subscription";}
											else if($r->ios_subscription_type==2){ $ios_type="Consumable";}
											else { $ios_type="";}
										@endphp
										
										<label >IOS Product Type:<b>{{ $ios_type }}</b></label>
										{{$r->description}}
										</div>
			
									</div>
						</div>
				@endforeach
				@endif

			</div>

				<!--Begin:: Content-->
				<!--End:: Content-->
		<!--end:: Widgets/Sale Reports-->
	  </div>
     </div>
   </div>
</div>
</div>
<!--begin::Modal-->
	<div class=" modal fade test_modal" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
	<div class="example-open modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
				
						<form method="post" action="{{ url('add_course')}}" enctype="multipart/form-data">
								@csrf

									<div class="form-group">
									<div class="row">
									<div class="col-lg-9 col-xl-9 col-xxl-9">
										<label>Course Icon (.jpg|.png only)</label>
										<input type="file" onchange="fileValidation();" id="course_icon" class="form-control" name="course_icon">
									</div>
									<div class="col-xl-2 col-xxl-2 col-lg-2">
										<img src="" id="icon_output" style="width:60px;">
									</div>
									</div>
									</div>
								
								
									<div class="form-group">
										<div class="row">
										<div class="col-xl-4 col-xxl-4 col-lg-4">
											<label>Unique Id</label>
											<input type="text" id="unique_id" class="form-control" name="unique_id" required>
										</div>
										<div class="col-xl-8 col-xxl-8 col-lg-8">
											<label>Course Name </label>
											<input type="text" id="course_name" class="form-control" name="course_name" required>
										</div>
										</div>
									</div>
									
									<div class="form-group">
									<div class="row">
										<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">Admission End Date</label>
										<div class="col-lg-4 col-xl-4 col-xxl-4">
										<input type="date"  name="subscription_end_date" class="form-control" >
									</div>
									<div class="col-lg-4 col-xl-4 col-xxl-4" style="display:flex;align-items:center;">
										<label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
											<input type="checkbox"  name="course_type" > Hidden Course	<span></span>
										</label>
									
									</div>
									</div>
									</div>

									<div class="form-group">
									<div class="row">
									<div class="col-lg-7 col-xl-7 col-xxl-7">
										<label>App Store Product Id </label>
										<input type="text" class="form-control"  name="app_product_id" required>
									</div>
									
									<div class="col-lg-5 col-xl-5 col-xxl-5">
										<label>Subscription Type(IOS) </label>
										<select name="subscription_type" class="form-control" required>
											<option value="">--select--</option>
											<option value="1">Subscription</option>
											<option value="2">Consumable</option>
										</select>
									</div>
									</div>
									</div>
									
									<div class="form-group">
										<label>Description </label>
											<textarea rows=3 class="form-control"  name="description" required></textarea>
									</div>

									<div class="form-group">
										<label>Course Features </label>
											<textarea rows=3 class="textarea2 form-control"  name="features" required></textarea>
									</div>

								<div class="modal-footer">
									<button type="submit" class="btn btn-primary btn-xs"> Submimt </button>
									<button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
								</div>

							</form>
				</div>
				
			</div>
		</div>
	</div>





<!--begin::Modal-->
	<div class="modal fade" id="kt_modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">View Features</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" aria-label="Close">Close</button>
				</div>
				
			</div>
		</div>
	</div>
	
	<!--begin::Modal- RE-ORDER------>
	
	<div class=" modal fade test_modal" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Re-Order Course</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					
				<label><b><u>Re-order Subjects</u></b> </label>

				<div class="row">
					<div class="col-lg-12 col-xl-12 col-xxl-12 ">
						<label id="smes" style="color:red;font-weight:600;padding-left:30px;"></label>
						<ul id="sortable">
						  <li class="ui-state-default" data-id="0">No Subjects</li>
						  <!--<li class="ui-state-default" data-id="2"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>
						  <li class="ui-state-default" data-id="3"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>
						  <li class="ui-state-default" data-id="5"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>-->
						</ul>
					</div>
					
				</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
					<button id="btnCOrder" class="btn btn-primary btn-xs"> Change Order </button>
				</div>

			</div>
		</div>
	</div>

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
	
	getCourses();  //for reordering
});


$(".textarea").summernote({dialogsInBody: true});
$(".textarea2").summernote({dialogsInBody: true});

$(".fview").click(function()
{
	var cid=$(this).attr('id');
	
	var Result1=$("#kt_modal_3 .modal-body");
		
		$(this).attr('data-target','#kt_modal_3');
	
			jQuery.ajax({
			type: "GET",
			url: "get_course_features"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			  Result1.html(res);
			}
		});
});

$(".edit").click(function()
{
	var cid=$(this).attr('id');
	
	var Result=$("#kt_modal_1 .modal-body");
		
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_course"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			  Result.html(res);
			}
		});
});


var table=$('#datatable').DataTable({
	"processing": true,
	'paging':true,
	'pageLength':25,
	'bDestroy':true,
	'saveState':true,
 });
 



$('#btnAdd').click(function()
{
	$("#icon_output").attr('src','');
});

   $("#course_icon").change(function() {
        var file = document.getElementById("course_icon").files[0];
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
				url: "edit_course"+"/"+cid,
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
	 var fileInput = document.getElementById('course_icon'); 
	 var allowedExtensions="";
	 
		allowedExtensions = /(\.jpg|\.png)$/i;  
      
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

$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});

/* COURSE RE-ORDER -------------------------------------------------*/

  $( function() {
    $( "#sortable" ).sortable();
  } );

$("#btnCOrder").prop('disabled',true);

 function getCourses()
 {
	jQuery.ajax({
		type: "GET",
		url: "get_course_for_reorder",
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
			if(res=='')
			{
				$("#btnCOrder").prop('disabled',true);
				$("#smes").html('No Courses.');
			}
			else
			{
				$("#btnCOrder").prop('disabled',false);
				$("#smes").html('');
			}
		  $("#sortable").html(res);
		}
	});  
 }
 
 
 var phrases ="";
$("#btnCOrder").click(function()
{
	phrases ="";
	$('#sortable').each(function(){
		$(this).find('li').each(function(){
			var current = $(this).attr('data-id');
			phrases+=","+current;
		});
	});
	
	var ids=phrases.substr(1);
	
	jQuery.ajax({
		type: "POST",
		url: "set_course_reorder",
		dataType: 'html',
		data:{_token:"{{csrf_token()}}",crsids:ids},
		success: function(res)
		{
		   alert("Course re-order successfully completed.");
		   location.reload();
		}
	}); 

});


</script

@endpush

@endsection





