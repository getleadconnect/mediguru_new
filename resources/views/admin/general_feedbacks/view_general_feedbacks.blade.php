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

#tbvideo tr,td,th
{
	border:1px solid #e4e4e4;
}
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Feedbacks
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
						Feedbacks
						</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
												
						<!--<li class="nav-item">
							<button type="button" class="btn-accordion btn btn-primary btn-xs" data-toggle="collapse" data-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne5">
							<i class="flaticon2-plus"></i> Filter
							</button>-->
						</li>
					</ul>
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<div class="row">
					<label class="col-xl-1 col-xxl-1 col-lg-1 col-form-label">Date From</label>
					<div class="col-xl-2 col-xxl-2 col-lg-2">
						<input type="date" class="form-control" name="date_from" id="flt_date_from" required>
					</div>
					<div class="col-xl-2 col-xxl-2 col-lg-2">
						<input type="date" class="form-control" name="date_to" id="flt_date_to" required>
					</div>
					
					<div class="col-xl-1 col-xxl-1 col-lg-1">
						<button type="button" id="flt_get" class="btn btn-primary btn-xs;">Get</button>
					</div>
				
				</div>
				
				<hr style="margin:10px 3px;">

				<!--Begin:: Content-->
				
				<div class="row mt-3">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
					<div class="width:150%;border:1px solid red;">
						<table id="datatable" class="table table-bordered" style="width:100%;" >
							<thead>
								<tr>
									<th>SlNo</th>
									<th>Name</th>
									<th>Mobile</th>
									<th>Feedbacks</th>
									<th width="100px">Action</th>
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
		</div>
		<!--end:: Widgets/Sale Reports-->

</div>
<!--begin::Modal-->
	<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">View Contents</h5>
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

//$(".textarea").summernote({dialogsInBody: true});


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
			url:"view_general_feedbacks",
			data: function (data) 
		    {
				data.search = $('input[type="search"]').val();
				data.searchDateFrom= $('#flt_date_from').val();
				data.searchDateTo = $('#flt_date_to').val();
		    },
		},
		
		columnDefs:[
				  {"width":"50px","targets":0},
				  {"width":"150px","targets":2},
				  {"width":"60px","targets":4},
				],
	
        columns: [
            {"data": "id" },
			{"data": "name" },
			{"data": "mob" },
			{"data": "fbak" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ]
 });


$("#flt_get").click(function()
{
	table.draw();
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
			   $("#subject_id").html(res);
			}
       });
	   
	var cid=$(this).val();
	    jQuery.ajax({
			type: "GET",
			url: "get_vimeo_videos_by_course_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#video_id").html(res);
			}
       }); 
   
});

$("#flt_subject_id").change(function()
{
	var cid=$(this).val();
	jQuery.ajax({
			type: "GET",
			url: "get_chapters_by_subject_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#chapter_id").html(res);
			}
       });
});

$('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');
	
		var Result=$("#kt_modal_2 .modal-body");
		
		$(this).attr('data-target','#kt_modal_2');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_material"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
  });

 $('#datatable tbody').on( 'click', '.btnData', function ()
  {
	var cid=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "view_material_data"+"/"+cid,
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
	return confirm("Are you sure, Delete this details?");
});



</script>

@endpush

@endsection





