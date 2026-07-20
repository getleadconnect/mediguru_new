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
		Student Users
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
						User List
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<!--<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs" data-toggle="modal" data-target="#kt_modal_1" >
							<i class="flaticon2-plus"></i> Add User
							</button>-->
						</li>
						
					</ul>
					
					
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->

				<div class="row mt-3">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							  <thead>
								<tr>
									<th>Id</th>
									<th >Name</th>
									<th >Mobile</th>
									<th >Email</th>
									<th >Status</th>
									<th width="80px">Action</th>
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
          url: "view_student_users",
          data: function (data) 
		    {
				data.search = $('input[type="search"]').val();
				/*data.searchByCourse = $('#flt_course_id').val();
				data.searchBySCourse = $('#flt_subject_id').val();*/
		    },
          },

		columnDefs:[
				      {"width":"250px","targets":3},
					  {"width":"100px","targets":5},
				   ],
	
        columns: [
            {"data": "id" },
			{"data": "sname" },
			{"data": "mobile" },
			{"data": "email" },
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) 
		{
			$('input[type="search"]').val('');
		}
				
    });

 /*$("#flt_course_id").change(function()
 {
	 table.draw();
 });*/

$("#flt_course_id").change(function()
{
	var cid=$(this).val();
	jQuery.ajax({
			type: "GET",
			url: "get_subjects_by_course_unique_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#flt_subject_id").html(res);
			}
       });
});

$('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_student_user"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
		
  });
    

 
$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});



</script

@endpush

@endsection





