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
	min-height:110px !important;
}
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Notifications
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
						Notification List
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs" aria-expanded="false" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							 Add Notification
							</button>
						</li>
						
					</ul>
					
					
				</div>
				
			</div>
			
			<div class="kt-portlet__body">

				<!--Begin:: Content-->
				
				<!--begin::Accordion-->
				<div class="accordion  accordion-toggle-arrow" id="accordionExample4">
					<div class="card">
					<div id="collapseOne4" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample4">
						
						<ul class="nav nav-tabs" role="tablist" style="margin: 0px 0 2px 0">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#" data-target="#kt_tabs_1_1" style="color:#07435e;"><b>Course</b></a>
								</li>
								
								<li class="nav-item">
									<a class="nav-link " data-toggle="tab" href="#" data-target="#kt_tabs_1_2" style="color:#07435e;"><b>Subject</b></a>
								</li>
								
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#kt_tabs_1_3" style="color:#07435e;"><b>General</b></a>
								</li>
								
							</ul>
						
						<div class="card-body" style="background:#e2f0f7;">
						
						<div class="tab-content">
							<div class="tab-pane active" id="kt_tabs_1_1" role="tabpanel">

									<form method="post" action="" enctype="multipart/form-data">
									@csrf
									
									<input type="hidden" name="subject_id">
									<input type="hidden" name="message_type" value="3"> <!--- Course wise --->
			
									<div class="row">
									<div class="col-lg-5 col-xl-5 col-xxl-5">

									<div class="form-group row">
									<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Course<span style="color:red;">*</span> </label>
									<div class="col-lg-9 col-xl-9 col-xxl-9">
									<select id="course_unique_id" class="form-control" name="course_unique_id" required>
									<option value=''>--select--</option>
									  @foreach($crs as $r)
										<option value="{{ $r->unique_id }}">{{ $r->course_name }}</option>
									  @endforeach
									</select>
									</div>
									</div>

						
									<div class="form-group row">
									  <label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Title<span style="color:red;">*</span> </label>
									  <div class="col-lg-9 col-xl-9 col-xxl-9">
										  <input type="text" id="title" class="form-control" name="title" required>
									  </div>
									</div>
							
									
									</div>

									<div class="col-lg-7 col-xl-7 col-xxl-7">
																
									<div class="form-group">
										<label>Message<span style="color:red;">*</span></label>
											<textarea rows=3 class="form-control content1" name="message"  required></textarea>
									</div>
									
									<div class="form-group text-right">
										<button type="submit" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp; </button>
									</div>
									
									</div>
									</div>
									
								</form>	
							</div>
							<div class="tab-pane" id="kt_tabs_1_2" role="tabpanel">
								<form method="post" action="" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="message_type" value="2"> <!--- Subject --->
			
									<div class="row">
									<div class="col-lg-5 col-xl-5 col-xxl-5">

									<div class="form-group row">
									<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Course<span style="color:red;">*</span> </label>
									<div class="col-lg-9 col-xl-9 col-xxl-9">
									<select id="course_uid" class="form-control" name="course_unique_id" required>
									<option value=''>--select--</option>
									  @foreach($crs as $r)
										<option value="{{ $r->unique_id }}">{{ $r->course_name }}</option>
									  @endforeach
									</select>
									</div>
									</div>
										
									<div class="form-group row">
									<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Subject </label>
									<div class="col-lg-9 col-xl-9 col-xxl-9">
									<select id="sub_subject_id" class="form-control" name="subject_id" >
									 <option value=''>--select--</option>
									  
									</select>
									</div>
									</div>
																
									<div class="form-group row">
									  <label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Title<span style="color:red;">*</span> </label>
									  <div class="col-lg-9 col-xl-9 col-xxl-9">
										  <input type="text"  class="form-control" name="title" required>
									  </div>
									</div>
									
									</div>

									<div class="col-lg-7 col-xl-7 col-xxl-7">
																
									<div class="form-group">
										<label>Message<span style="color:red;">*</span></label>
											<textarea rows=3 class="form-control content1" name="message"  required></textarea>
									</div>
									
									<div class="form-group text-right">
										<button type="submit" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp; </button>
									</div>
									
									</div>
									</div>
									
								</form>	
							</div>
							<div class="tab-pane" id="kt_tabs_1_3" role="tabpanel">
							
							<form method="post" action="" enctype="multipart/form-data">
									@csrf
			
			
									<input type="hidden" name="subject_id">
									<input type="hidden" name="course_unique_id">
									<input type="hidden" name="message_type" value="1">  <!--- General --->
						
									<div class="row">
									<div class="col-lg-12 col-xl-12 col-xxl-12">
																
									<div class="form-group row">
									  <label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label">Title<span style="color:red;">*</span> </label>
									  <div class="col-lg-4 col-xl-4 col-xxl-4">
										  <input type="text"  class="form-control" name="title" required>
									  </div>
									</div>
									
									<div class="form-group row">
									  <label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label">Message<span style="color:red;">*</span> </label>
									  <div class="col-lg-9 col-xl-9 col-xxl-9">
										 <textarea rows=3 class="form-control content1" name="message"  required></textarea>
									  </div>
						
									  <div class="col-lg-2 col-xl-2 col-xxl-2">
										<br>
										 <button type="submit" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp; </button>
									  </div>
									</div>				
									</div>
									</div>
									
								</form>	
								
							</div>
							
						</div>

							<!--<label><b><u>Add Notification </u></b>(<span style="color:red;">*:Mandatory</span>)</label>-->

					</div>
				  </div>
			</div>
			</div>
				
				<div class="row mt-3">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<table id="datatable" class="table table-bordered " style="border-collapse:collapse; border-spacing:0; width:100%;">
							<thead>
								<tr>
									<th>No</th>
									<th>Date</th>
									<th>Course</th>
									<th>Subject</th>
									<th>Title</th>
									<th>Message</th>
									<th>Type</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							
							</tbody>
						</table>
					</div>
				
				</div>

				<!--End:: Content-->
		<!--end:: Widgets/Sale Reports-->
	  </div>
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

$(".textarea").summernote({dialogsInBody: true});

 
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

 var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :10,
		scrollX: true,
		
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
          url: "view_notifications",
          data: function (data) {
				data.search = $('input[type="search"]').val();
				data.searchCourse = $('#flt_course').val();
		       },
          },

		columnDefs:[
				  {"width":"80px","targets":1},
				  {"width":"40px","targets":6},
				  {"width":"70px","targets":8},
				],
	
        columns: [
			{"data": "id" },
			{"data": "adt" },
			{"data": "cname" },
			{"data": "sub" },
			{"data": "tit" },
			{"data": "mes" },
			{"data": "type" },
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) 
		{
			$('input[type="search"]').val('');
		}
    });




$('#btnAdd').click(function()
{
	$("#icon_output").attr('src','');
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
  
  $('#datatable tbody').on( 'click', '.btnActDeact', function (e)
  {
		e.preventDefault();  
		var nid=$(this).attr('id');
			var op=$(this).attr('rel');
	
				jQuery.ajax({
				type: "GET",
				url: "act_deact_notification"+"/"+nid+"/"+op,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					   table.draw();
					   alert("Notification Activate");
				   }
				   else if(res==2)
				   {
					   table.draw();
					   alert("Notification Deactivated");
				   }
				   else
				   {
					   alert("Please try again");
				   }
				}
			});
  });
  
  
  $('#datatable tbody').on( 'click', '.btnDel', function (e)
  {
			e.preventDefault();
			
			var nid=$(this).attr('id');
			
				jQuery.ajax({
				type: "GET",
				url: "delete_notification"+"/"+nid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					   table.draw();
					   alert("Notification removed");
				   }
				   else
				   {
					   alert("Please try again");
				   }
				}
			});
  });

$("#course_uid").change(function()
{
	var cuid=$(this).val();
	if(cuid!="")
	{
	  jQuery.ajax({
		type: "GET",
		url: "get_subjects_by_course_unique_id"+"/"+cuid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#sub_subject_id").empty();
		   $("#sub_subject_id").append(res);
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





