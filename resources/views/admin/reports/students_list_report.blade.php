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
		Students list report
	</h3>
</div>
</div>

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

<div class="row">
<div class="col-lg-12 col-xl-12 col-xxl-12">

		<!--begin:: Widgets/Sale Reports-->
		<div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
			<div class="kt-portlet__head" style="min-height: 45px !important;">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						Registred Students
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
					
						<!--<li class="nav-item">
							<button type="button" id="btnAdd" class="btn-accordion-filter btn btn-primary btn-xs" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							<i class="la la-filter"></i> Filter
							</button>
						</li> -->
						
					</ul>
					
				</div>
				
			</div>
			<div class="kt-portlet__body">
			
				<div class="accordion  accordion-toggle-arrow" id="accordionExample4">
					<div class="card">
					<div id="collapseOne4" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample4">
						<div class="card-body" style="background:#e2f0f7;padding:5px 10px;">
							<label><b><u> Filter By:</u></b></label>
							
							<div class="form-group row">
								<label class="col-form-label col-lg-2 col-xl-2 col-xxl-2">Select Date Range</label>
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<div class="input-group pull-right" id="kt_daterangepicker_6">
										<input type="text" id="date_range" class="form-control" readonly="" placeholder="Select date range">
										<div class="input-group-append">
											<span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
										</div>
									</div>
								</div>
								<div class="col-lg-1 col-xl-1 col-xxl-1 text-right" style="padding-top:5px;">
								   <button id="btnGet" class=" btn btn-primary btn-sm">Get</a>
							   </div>
								
								<div class="col-lg-5 col-xl-5 col-xxl-5 text-right" style="padding-top:5px;">
								   <a href="javascript:void()" id="exportToExcel" class=" btn btn-primary btn-sm"> <i class="fa fa-download"></i>Export to Excel</a>
								</div>

							</div>
						</div>
					</div>
				  </div>
				</div>
			

				<!--Begin:: Content-->
				<div class="row mt-3">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							<thead>
							<tr>
								<th>Id</th>
								<th>Reg_Date</th>
								<th>Name</th>
								<th>Gender</th>
								<th>Dob</th>
								<th>Mobile</th>
								<th>Email</th>
								<th>State</th>
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
$("#submit").prop("disabled",true);

$("#flt_course").select2();

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

$("#btnGet").click(function()
{
	var dt=$("#date_range").val();
	var res = dt.replaceAll("/", "-");
});


 var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :100,
		scrollX: true,
		
		'pagingType':"simple_numbers",
        'lengthChange': true,
		
		/*dom: 'Blfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			],*/
		
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
			url:"view_student_list",
			data: function (data) 
		    {
				var dt=$("#date_range").val();
				var res = dt.replaceAll("/", "-");
				
				data.search = $('input[type="search"]').val();			
				data.searchByDate = res;
		    },
		},
		
		columnDefs:[
				  {"width":"150px","targets":2},

				],

        columns: [
            {"data": "id" },
			{"data": "rdate" },
			{"data": "name" },
			{"data": "gender" },
			{"data": "dob" },
			{"data": "mobile" },
			{"data": "email" },
			{"data": "state" },
			
			//{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val("");
		}
    });

$("#btnGet").click(function()
{
	table.draw();
});



$("#exportToExcel").click(function()
{
	var dtr=$("#date_range").val();
	if(dtr!="")
	{
		var fdt = dtr.replaceAll("/", "-");
		var lnk="{{url('export_student_list')}}"+"/"+fdt;
	    $("#exportToExcel").attr('href',lnk);	
	}
	else
	{
		var fdt='0';
		var lnk="{{url('export_student_list')}}"+"/"+fdt;
	    $("#exportToExcel").attr('href',lnk);
	}
});


/*
$("#flt_course").change(function()
{
	var cuid=$(this).val();
	if(cuid!="")
	{
	  jQuery.ajax({
		type: "GET",
		url: "get_students_by_course_unique_id"+"/"+cuid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#flt_student").empty();
		   $("#flt_student").append(res);
		}
	  });
	}
	
});*/



$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});



</script

@endpush

@endsection





