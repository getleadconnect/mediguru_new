<!-- SUB COURSES------------------------------------->
@extends('admin.layouts.master')
@section('contents')

<style>
.card {
    border:none !important;
}
.fa
{
	font-size:13px !important;
}
.m-field
{
	color:red;
}
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Lessons (Chapters)
		</h3>
</div>
</div>

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

		<!--begin:: Widgets/Sale Reports-->
		<div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						Lesson
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
					
						<li class="nav-item">
							<button type="button" class="btn-accordion btn btn-primary btn-xs" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							 Add Lesson
							</button>
						</li>
						
						<li class="nav-item">
							<button type="button" class="btn-accordion-filter btn btn-primary btn-xs" data-toggle="collapse" data-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne5">
							<i class="la la-filter"></i>Filter
							</button>
						</li>
						
					</ul>
					
					
				</div>
				
			</div>
			
			
			<div class="kt-portlet__body">
	
				<div class="row">
				<div class="col-lg-12 col-xl-12 col-xxl-12">

				<div class="accordion accordion-toggle-arrow" id="accordionExample4" >
				<div class="card">
				
					<div id="collapseOne4" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample4">
						<div class="card-body" style="background:#e2f0f7;">
							<label><b><u> Add Lesson(Chapters):</u></b></label>
							
							<form method="post" action="" enctype="multipart/form-data">
							@csrf
						
							<div class="row">
							<div class="col-xl-3 col-xxl-3 col-lg-3">
							<div class="form-group">
								<label>Lesson Icon(.jpg|.png) </label>
									<input type="file" onchange="fileValidation();" id="lesson_icon" class="form-control" name="lesson_icon" required>
							</div>
							</div>
							<div class="col-xl-1 col-xxl-1 col-lg-1">
							    <img src="" id="icon_output" style="width:80px;">
							</div>
		
							
							<div class="col-xl-3 col-xxl-3 col-lg-3">
								<label>Course</label>
									<select id="course_id" class="form-control" name="course_id" required>
									<option value="">--select--</option>
									@foreach($crs as $r)
									<option value="{{$r->id}}">{{ $r->course_name }}</option>
									@endforeach
									</select>
							 </div>
							
							
							<div class="col-xl-4 col-xxl-4 col-lg-4">
								<label>Sub-Course Name<span class="m-field">*</span> </label>
								<select id="subject_id" class="form-control" name="subject_id" required>
								   <option value="">--select--</option>
								  
								</select>
							</div>
							</div>
							<div class="row">
							<div class="col-lg-4 col-xl-4 col-xxl-4">
								<label>Lesson Name<span class="m-field">*</span> </label>
								<input type="text" id="lesson_name" class="form-control" name="lesson_name" required>
							 </div>
							 
							 <div class="col-lg-2 col-xl-2 col-xxl-2">
								<label>Order No<span class="m-field">*</span> </label>
								<input type="text" id="order_no" class="form-control" name="order_no" required>
							 </div>
							 
							  <div class="col-lg-6 col-xl-6 col-xxl-6">
							  <br>
							  <button type="submit" class="btn btn-primary" style="margin-top:5px;" > Submit </button>
							 </div>

							</div>

						</form>
				
							
						</div>
					</div>
				
					
					<!--- FILTER ------------------------------------------>
					
					<div id="collapseOne5" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample4">
						<div class="card-body" style="background:#e2f0f7;">
						  <label><b><u> Filter BY:</u></b></label>
							<div class="row">
							
								<label class="col-lg-1 col-xl-1 col-xxl-1  col-form-label">Course</label>
								<div class="col-lg-3 col-xl-3 col-xxl-3 ">	
									<select id="flt_course_id" class="form-control" name="flt_course_id" required>
									<option value="">--select--</option>
									@foreach($crs as $r)
									   <option value="{{ $r->id }}">{{ $r->course_name }}</option>
									@endforeach
									</select>
								</div>
								
								
								<label class=" col-lg-1 col-xl-2 col-xxl-2 col-form-label" style="padding-right:0px;">Sub-Course</label>
								<div class="col-lg-4 col-xl-4 col-xxl-4 ">	
									<select id="flt_subject_id" class="form-control" name="flt_subject_id" required>
									<option value="">--select--</option>
									
									</select>
								</div>
							 <div class="col-lg-1 col-xl-1 col-xxl-1 ">
								<button type="button" id="btnGET" class="btn btn-primary btn-xs">Get</button>
							 </div>
							 </div>

						</div>
					</div>

				</div>
				
				<div class="row mt-3">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						
						
						
					</div>
				
				</div>
				<!--End:: Content-->
			</div>
		
			
		<label style="font-weight:600;font-size:14px;" class="mb-3" ><u>View Lessons:</u></label>

		<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
			<thead>
				<tr>
					<th>Id</th>
					<th>Icon</th>
					<th>Course</th>
					<th width="150px">Sub_Course</th>
					<th>Lesson Name</th>
					<th>Order</th>
					<th>Status</th>
					<th width="120px">Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			
			</tbody>
		</table>


</div>
</div>

</div>
</div>
		<!--end:: Widgets/Sale Reports-->

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


 var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :10,
		scrollX: true,
		
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
			url:"view_lessons",
			data: function (data) 
		    {
				data.search = $('input[type="search"]').val();
				data.searchBycourse = $("#flt_course_id").val();
				data.searchBySubcourse = $("#flt_subject_id").val();
		    },
		},
		
		columnDefs:[
				  {"width":"200px","targets":4},

				],
	
        columns: [
            {"data": "id" },
			{"data": "cicon" },
			{"data": "cname" },
			{"data": "sname" },
			{"data": "lname" },
			{"data": "ordno" },
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) 
		{
			$('input[type="search"]').val('');
		}
    });



$("#flt_course_id").change(function()
{
	var cid=$(this).val();
	jQuery.ajax({
			type: "GET",
			url: "get_subjects_by_course_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#flt_subject_id").html(res);
			}
       });
});

$("#course_id").change(function()
{
	var cid=$(this).val();
	jQuery.ajax({
			type: "GET",
			url: "get_subjects_by_course_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#subject_id").html(res);
			}
       });
});

$("#btnGET").click(function()
{
	table.draw();
});


 $("#lesson_icon").change(function() {
      var file = document.getElementById("lesson_icon").files[0];
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
			url: "edit_lesson"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
		
  });

$('#datatable tbody').on( 'click', '.btndel', function (e)
  {
	 e.preventDefault();
	 
	var lid=$(this).attr('id');
	
	if(confirm("Are you sure, delete this item?"))
	{
	    jQuery.ajax({
			type: "GET",
			url: "delete_lesson"+"/"+lid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   if(res==1)
			   {
				   toastr.success("Lesson successfully removed.");
				   table.draw();
			   }
			   else
			   {
				   toastr.error("Something wrong, Try again.");
			   }
			}
		});
	}
		
  });
  
  $('#datatable tbody').on( 'click', '.btnActDeact', function (e)
  {
	 e.preventDefault();
	 
	var lid=$(this).attr('id');
	
	    jQuery.ajax({
			type: "GET",
			url: "activate_deactivate_lesson"+"/"+lid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   if(res==1)
			   {
				   toastr.success("Promocode successfully Activated.");
				   table.draw();
			   }
			   else if(res==2)
			   {
				   toastr.success("Promocode successfully deactivated.");
				   table.draw();
			   }
			   else
			   {
				   toastr.error("Something wrong, Try again.");
			   }
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


$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});



</script>

@endpush

@endsection





