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
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Subscriptions
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
						Subscription List
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<!--<li class="nav-item">
						<a href="{{url('add_student')}}" class="btn-accordion btn btn-primary btn-xs" ><i class="flaticon2-plus"></i> Add Students</a>
						</li>-->
						
						<li class="nav-item">
							<button type="button" id="btnAdd" class="btn-accordion-filter btn btn-primary btn-xs" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							<i class="la la-filter"></i> Filter
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
						<div class="card-body" style="background:#e2f0f7;">
							
							<div class="row">
								<div class="col-lg-4 col-xl-4 col-xxl-4">
								<label class="col-lg-12 col-xl-12 col-xxl-12" style="padding-top:9px;">Select Course</label>
								<div class="col-lg-12 col-xl-12 col-xxl-12">
								   <select id="flt_course_id" class="form-control " name="flt_course_id" required>
									<option value="">--select--</option>
									@if(!empty($crs))
										@foreach($crs as $r)
											<option value="{{$r->unique_id}}" @if ($r->id==Session::get('mcq_course_id')) {!! "selected" !!} @endif>{{ $r->course_name }}</option>
										@endforeach
									@endif
									</select>
								</div>
								</div>
								<div class="col-lg-2 col-xl-2 col-xxl-2">
								<label class="col-lg-12 col-xl-12 col-xxl-12" style="padding-top:9px;">Select Year</label>
								<div class="col-lg-12 col-xl-12 col-xxl-12">
								   <select id="flt_year" class="form-control " name="flt_year" required>
									<option value="">--select--</option>
									@php
									  $x=2022;date('Y')-10;
									@endphp
									@for($x=2022;$x<=date('Y');$x++)
										<option value="{{$x}}">{{$x}}</option>
									@endfor
									</select>
								</div>
								</div>
								
								<div class="col-lg-2 col-xl-2 col-xxl-2">
								<label class="col-lg-12 col-xl-12 col-xxl-12" style="padding-top:9px;">&nbsp;</label>
								<div class="col-lg-12 col-xl-12 col-xxl-12">
								   <button type="button" id="btnGet" class="btn btn-primary">Get</button>
								</div>
								</div>
																						
							</div>
							
						</div>
					</div>
				  </div>
			</div>
				
				<div class="row mt-3">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
					

						<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							<thead>
								<tr>
									<th>Id</th>
									<th>Image</th>
									<th>Date</th>
									<th>Name</th>
									<th>Course</th>
									<th>Package</th>
									<th>Status</th>
									<th width="50px">Action</th>
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

$("#submit").prop("disabled",true);

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

        ajax:{
		url:"view_subscriptions",
		data: function (data) 
		    {
                data.searchByCourse = $('#flt_course_id').val();
				data.searchByYear = $('#flt_year').val();
				data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  {"width":"150px","targets":2},

				],
	
        columns: [
            {"data": "id" },
			{"data": "simage" },
			{"data": "date" },
			{"data": "name" },
			{"data": "course" },
			{"data": "package" },
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
		
		
    });

$("#btnGet").click(function()
 {
	 table.draw();
 });



$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});


</script

@endpush

@endsection





