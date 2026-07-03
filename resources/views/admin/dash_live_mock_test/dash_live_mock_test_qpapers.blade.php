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
		Set Live Mock test Question Papers (Dashboard)
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
						Add Question Paper
					<h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<!--- content here ---------------->
						</li>
						
					</ul>
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->
				
				<!--begin::Accordion-->
				<label style="color:#2d2dcf;"><b><u>Add Question Paper</u></b></label>
				
				<form method="POST" id="addQpForm"  enctype="multipart/form-data"> 
						@csrf
				
				<div class="row">
				<div class="col-lg-3 col-xl-3 col-xxl-3">
					<label><b>Course</b> </label>
						   <select id="courseid" class="form-control" name="courseid" required>
							<option value="">--select--</option>
							@foreach($crs as $r)
							<option value="{{$r->id}}">{{$r->course_name}}</option>
							@endforeach
						</select>
						</div>
					
					<div class="col-lg-4 col-xl-4 col-xxl-4">
					<label ><b>Subject</b> </label>
						   <select id="subjectid" class="form-control input-default " name="subjectid" required>
							<option value="">--select--</option>
							
						</select>
					</div>
					
					<div class="col-lg-4 col-xl-4 col-xxl-4">
					<label ><b>Select question paper</b> </label>
						   <select id="qp_unique_id" class="form-control input-default " name="qp_unique_id" required>
							<option value="">--select--</option>
							
							</select>
					</div>
					
					<div class="col-lg-1 col-xl-1 col-xxl-1">
					<br>
					<button type="submit" name="btnAdd" class="btn btn-primary btn-xs" style="margin-top:5px;">Add </button>
					</div>

				</div>
				</form>	

			<hr style="margin:7px 0px 3px 0px;">
				
				<!------ Row ---------->
				
			<div class="row">
			<div class="col-lg-12 col-xl-12 col-xxl-12">
			
				<label class="mt-3" style="color:#2d2dcf;"><b><u>Question Paper List : <span id="ltitle"> </span></u></b></label>
				
					<!--<div style="overflow-x:scroll;width:500px;max-height:400px;">-->

						<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0;">
						<thead>
							<tr>
							<th>Id</th>
							<th>Unique_Id</th>
							<th>Course</th>
							<th>Subject</th>
							<th>Icon</th>
							<th>Question Paper</th>
							<th>Date/Time</th>
							<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
					
					<!--</div>-->
							
				<!--<label><span>Total Questions:&nbsp;</span><span id="totquestion2" style="font-weight:600;font-size:16px;"> </span></label>-->
			
			</div>
			</div><!--row end --->
			
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
					<h5 class="modal-title" id="exampleModalLabel">Add Subject</h5>
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

$("#qp_unique_id").select();
$("#subjectid").select();


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
          url: "view_dash_live_mock_tests",
          data: function (data) {
				data.search = $('input[type="search"]').val();
				data.searchByCourse = $('#courseid').val();
		       },
          },

		columnDefs:[
				  {"width":"100px","targets":2},
				],
	
        columns: [
			{"data": "id" },
			{"data": "uid" },
			{"data": "cname" },
			{"data": "sname" },
			{"data": "icon" },
			{"data": "qpaper" },
			{"data": "tdate" },
			{"data": "action" },
        ]
  });
	

$("form#addQpForm").submit(function(e)
{
	e.preventDefault();    
    var formData = new FormData(this);
    $.ajax({
        url: "save_live_mock_test",
        type: 'POST',
        data: formData,
        success: function (res) 
		{
			if(res>=1)
			{
				alert("Subject successfully added.");
				$("#courseid").val('');
				$("#subjectid").val('');
				$("#qp_unique_id").val(''); 
			}
			else
			{
				alert("Details missing, Try again.");	
			}
        },
        cache: false,
        contentType: false,
        processData: false
    });
});



$("#courseid").change(function()
{
	var cid=$(this).val();
	if(cid!="")
	{
	  jQuery.ajax({
		type: "GET",
		url: "get_subjects_by_course_id"+"/"+cid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#subjectid").empty();
		   $("#subjectid").append(res);
		}
	  });
	  
	  jQuery.ajax({
		type: "GET",
		url: "get_live_mock_test_qpapers"+"/"+cid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#qp_unique_id").empty();
		   $("#qp_unique_id").append(res);
		}
	  });
	}
});
  

 $('#datatable tbody').on( 'click', '.btnDel', function (e)
  {
	e.preventDefault();
	
	if(confirm("delete this item?"))
	{
	
	var lid=$(this).attr('id');
			
  	  var qid=$(this).val();
		jQuery.ajax({
			type: "GET",
			url: "delete_dash_live_test"+"/"+lid,
			dataType: 'html',
			//data: {},
			success: function(res)
			{
				alert('Test removed');
				table.draw();
			}
		 });
	}
  });
  
  

$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});

</script>

@endpush

@endsection





