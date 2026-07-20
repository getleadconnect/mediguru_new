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
		View Lesson Materials
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
						<a href="{{ url('view_all_lesson_videos')}}" class="btn btn-primary btn-xs"><i class="flaticon2-file"></i>View Lesson Videos </a>
						<a href="{{ url('view_all_lesson_materials')}}" class="btn btn-success btn-xs"><i class="flaticon2-file"></i>View Lesson Materials </a>
						<a href="{{ url('view_lesson_mcq_qpapers')}}" class="btn btn-primary btn-xs"><i class="flaticon2-file"></i>View Lesson Mock Tests </a>
						<a href="{{ url('view_lesson_live_qpapers')}}" class="btn btn-primary btn-xs"><i class="flaticon2-file"></i>View Lesson Live Tests </a>

					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<!--<a href="" class="btn-accordion btn btn-primary btn-xs"><i class="flaticon2-file"></i> View Lession Items </a>-->
						</li>
						
					</ul>
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->
								
				<div class="row">
				<div class="col-lg-12 col-xl-12 col-xxl-12">
					
					<label style="color:#2d2dcf;"><b><u>Filter:</u></b></label>
					
					<div class="row">
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label"><b>Subject</b> </label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">

						   <select id="flt_subject_id" class="form-control input-default " name="flt_subject_id" required>
							<option value="">--select--</option>
							@foreach($sub as $r)
							<option value="{{$r->id}}">{{$r->subject_name}}</option>
							@endforeach
						</select>
					</div>
					
					
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label" ><b>Lessons</b> </label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
						   <select id="flt_lesson_id" class="form-control input-default " name="flt_lesson_id" required>
							<option value="">--select--</option>
						   </select>
					</div>


					</div>
						
					</div>
				</div>

			<hr style="margin:12px 0px 3px 0px;">
				
				<!------ Row ---------->
				
				<div class="row mt-3">
				<div class="col-lg-12 col-xl-12 col-xxl-12" >

				<!--<div class="mt-3" style="overflow:auto;height:900px;width:100%">-->
					<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0;width:90%;">
						<thead>
							<tr>
								<th width="50px">SlNo</th>
								<th>Uni_Id</th>
								<th>Icon</th>
								<th>Subject</th>
								<th>Lesson</th>
								<th>Title</th>
								<th>Data</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
			
						</tbody>
					</table>
				<!--</div>-->
			</div> <!-- column end ---->

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
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">View Data</h5>
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

$(".textarea").summernote();

$('input[type="search"]').val('');


 
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
          url: "view_all_materials",
          data: function (data) {
				data.search = $('input[type="search"]').val();
				data.searchByLesson = $('#flt_lesson_id').val();
		       },
          },

		columnDefs:[
				  {"width":"40px","targets":7},
				],
	
        columns: [
			{"data": "id" },
			{"data": "uid" },
			{"data": "micon" },
			{"data": "sname" },
			{"data": "lname" },
			{"data": "title" },
			{"data": "dat" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ]
    });


$("#flt_lesson_id").change(function()
{
	table.draw();
});

$("#flt_subject_id").change(function()
{
	var sid=$(this).val();
	if(sid!="")
	{
	  jQuery.ajax({
		type: "GET",
		url: "get_lessons_by_subject_id"+"/"+sid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#flt_lesson_id").empty();
		   $("#flt_lesson_id").append(res);
		}
	  });
	}
});

$('#datatable tbody').on( 'click', '.view', function ()
  {
	var uid=$(this).attr('id');

		var Result=$("#kt_modal_1 .modal-body");
		
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "get_material_data"+"/"+uid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
  });

 $('#datatable tbody').on( 'click', '.btnDel', function(e)
  {
	e.preventDefault();
	
	if(confirm("delete this item?"))
	{
	
	var lid=$(this).attr('id');
			
  	  var qid=$(this).val();
		jQuery.ajax({
			type: "GET",
			url: "delete_lesson_material"+"/"+lid,
			dataType: 'html',
			//data: {},
			success: function(res)
			{
				alert('Item removed');
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





