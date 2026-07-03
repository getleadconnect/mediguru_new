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
		Fee Discount Report
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
						Fee Discount Report
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
							<label><b><u> Filter By: </u></b>(<span >Select promocode/referral code and click get to list details)</span></label>
							
							<div class="form-group row">
								 <label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label">Promocode</label>
								 <div class="col-lg-3 col-xl-3 col-xxl-3">
								 <select class="form-control" name="flt_procode" id="flt_procode" >
									<option value="-1">--select--</option>
									  @foreach($pcod as $r)
									    <option value="{{$r->promocode}}">{{ $r->promocode }}</option>
									  @endforeach
								 </select>
								 </div>
								
								<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label">Ref.Code</label>
								<div class="col-lg-3 col-xl-3 col-xxl-3">
								 <select class="form-control" name="flt_refcode" id="flt_refcode" >
									<option value="-1">--select--</option>
									@foreach($sta as $r)
									    <option value="{{$r->referral_code}}">{{ $r->referral_code }}</option>
									  @endforeach
								 </select>
									
								</div>
								
								<div class="col-lg-1 col-xl-1 col-xxl-1 text-right" style="padding-top:2px;">
								   <button id="btnGet" class=" btn btn-primary btn-sm">Get</a>
							   </div>
								
								<div class="col-lg-3 col-xl-3 col-xxl-3 text-right" style="padding-top:5px;">
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
								<th>Package</th>
								<th>Code</th>
								<th>Value</th>
								<th>Amount</th>
								<th>Net_Amount</th>
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
 
 
$("#flt_procode").change(function()
{
	$("#flt_refcode").val('-1');
});

$("#flt_refcode").change(function()
{
	$("#flt_procode").val('-1');
});

$("#btnGet").change(function()
{
	table.draw();
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
			url:"view_discount_list",
			data: function (data) 
		    {
				data.search = $('input[type="search"]').val();	
				data.searchPcode = $('#flt_procode').val();	
				data.searchRcode = $('#flt_refcode').val();	
			},
		},
		
		columnDefs:[
				  {"width":"150px","targets":2},

				],

        columns: [
            {"data": "id" },
			{"data": "rdate" },
			{"data": "name" },
			{"data": "pkg" },
			{"data": "pcode" },
			{"data": "pamt" },
			{"data": "amt" },
			{"data": "namt" },
			//{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
    });

$("#btnGet").click(function()
{
	table.draw();
});



$("#exportToExcel").click(function()
{
	var prc=$("#flt_procode").val();
	var rfc=$("#flt_refcode").val();
	if(prc!='-1')
	{	
	   var lnk="{{url('export_discount_list/1')}}"+"/"+prc+"/"+rfc;
	   $("#exportToExcel").attr('href',lnk);
	}
	else if(rfc!='-1')
	{	
	   var lnk="{{url('export_discount_list/2')}}"+"/"+prc+"/"+rfc;
	   $("#exportToExcel").attr('href',lnk);
	}
	else
	{
		alert("Please select promocode/refrral code!");
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





