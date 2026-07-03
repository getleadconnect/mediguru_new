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

#datattable1 > input[type="search"]
{
	width: 150px !important;
}
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Students Attended Test Details
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
						Attended Test Details
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<!--<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							<i class="flaticon2-plus"></i> Add Course
							</button> -->
						</li>
						
					</ul>
					
					
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->

			<div class="row">
				<div class="col-xl-4 col-xxl-4 col-lg-4" style="background:#efefef;padding:15px;">
				
				<label>Select Course</label>
					<div class="row mb-3">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<select class="form-control" id="flt_course" name="flt_course" style="height:35px !important;" >
						<option value="">--Select--</option>
						@foreach($crs as $r)
						<option value="{{ $r->unique_id}}">{{ $r->course_name}}</option>
						@endforeach
						</select>
					  </div>
					</div>
					
				<label>Select Student</label>
					<div class="row mb-3">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<select class="form-control" id="flt_student" name="flt_student" style="height:35px !important;" >
						<option value="">--Select--</option>
						
						</select>
					  </div>
					</div>	
							
					
				    <!--<label><u><b>Students</b></u> </label>
					<table id="datatable1" class="table table-bordered dt-responsive" width="100%">
						<thead>
						  <tr>
							<th>No</th>
							<th>Name</th>
						  </tr>
						</thead>
					  <tbody>

					  </tbody>
					  
					</table>  -->

				</div>
				<style>
				
				</style>
				
				<div class="col-xl-8 col-xxl-8 col-lg-8">
				
				<div class="table-responsive">
					<table id="datatable2" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Subject</th>
								<th>Question Paper</th>
								<th>Times</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				
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
					<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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


$("#flt_student").select2();

$(document).ready(function()
{
	//$('input[type="search"]').val("");
	
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

var table = $('#datatable2').DataTable({
        processing: true,
        stateSave:true,
		paging     : true,
		bDestroy:true,
        pageLength :50,

		scrollX: true,
});


$("#flt_course").change(function()
{
	var crsid=$(this).val();
	if(crsid!='')
	{
		jQuery.ajax({
			type: "GET",
			url: "view_student_names"+"/"+crsid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#flt_student").empty();
			   $("#flt_student").append(res);
			}
		});
		
	}
});

$("#flt_student").change(function(e)
{
	e.preventDefault();
	var stid=$(this).val();

	var table2 = $('#datatable2').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
		bDestroy:true,
        pageLength :50,
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
			url:"view_test_details",
			data: {stid: stid},
			/*data: function (data) 
		    {
				data.search = $('input[type="search"]').val();
		    },*/
		},
		
		columnDefs:[
				  {"width":"50px","targets":0},
				  {"width":"50px","targets":3},
				],
	
        columns: [
            {"data": "no" },
			{"data": "subject" },
			{"data": "qpaper" },
			{"data": "ntimes" },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').text('');
		}
		
		
    });
});

$



$("#btnAll").click(function()
{
	$("#date_range").val('');
	$("#flt_course").val('');
	$("#flt_year").val('');
	table.draw();
});

$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});




</script

@endpush

@endsection





