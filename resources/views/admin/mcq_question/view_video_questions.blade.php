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
		Video Questions
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
						Questions
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
					
						<li class="nav-item">
							<a href="{{ url('prepare_video_questions')}}" class="btn-accordion btn btn-primary btn-xs"><i class="flaticon2-plus"></i>&nbsp;Add</a>
						</li>
						
						<li class="nav-item">
							<button type="button" class="btn-accordion-filter btn btn-primary btn-xs" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
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
					<div id="collapseOne4" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample4">
						<div class="card-body" style="background:#e2f0f7;">
						<div class="row">
							<div class="col-lg-3 col-xl-3 col-xxl-3">
							<label>Course</label>
							
							   <select id="flt_course_id" class="form-control " name="flt_course_id" required>
								<option value="">--select--</option>
								@foreach($crs as $r)
								<option value="{{$r->id}}">{{$r->course_name}}</option>
								@endforeach
								</select>
							</div>
							<div class="col-lg-3 col-xl-3 col-xxl-3">
							<label >Subject</label>
							
							   <select id="flt_subject_id" class="form-control " name="flt_subject_id" required>
								<option value="">--select--</option>
								
								</select>
							</div>
							<div class="col-lg-3 col-xl-3 col-xxl-3">
							<label >Videos</label>
							
							   <select id="flt_video_id" class="form-control " name="flt_video_id" required>
								<option value="">--select--</option>
								
								</select>
							</div>
							
							<div class="col-lg-3 col-xl-3 col-xxl-3">
							<button id="btnGet" class="btn btn-primary btn-xs btn-sm" style="margin-top:28px;">Get</button>
							</div>
						</div>
							
					</div>
				  </div>
			   </div>
				
			   <div class="row mt-3">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0;" width="100%">
							<thead>
								<tr>
									<th>Id</th>
									<th>Q_Type</th>
									<th>Q_Mode</th>
									<th width="300px">Image/Question</th>
									<th width="250px">Answer</th>
									<th>True Answer</th>
									<th width="300px">Explanation</th>
									<th width="60px">Action</th>
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

$("#flt_course_id").change(function()
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
		   $("#flt_subject_id").empty();
		   $("#flt_subject_id").append(res);
		}
	  });
	}
});


$("#flt_subject_id").change(function()
{
	var sid=$(this).val();
	if(sid!="")
	{
	  jQuery.ajax({
		type: "GET",
		url: "get_videos_by_subject_id"+"/"+sid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{

		   $("#flt_video_id").empty();
		   $("#flt_video_id").append(res);
		}
	  });
	}
});



 var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :50,
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
          url: "view_video_questions",
          data: function (data) 
		    {
                data.searchByVideoId = $('#flt_video_id').val();
				data.search = $('input[type="search"]').val();
		    },
         },

		columnDefs:[
				      {"width":"250px","targets":3},
				   ],
	
        columns: [
            {"data": "id" },
			{"data": "qtype" },
			{"data": "qmode" },
			{"data": "quest" },
			{"data": "answer" },
			{"data": "cans" },
			{"data": "expl" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) 
		{
			$('input[type="search"]').val('');
		}
		
    });

 $("#btnGet").click(function()
 {
	 var vid=$("#flt_video_id").val();
	 if(vid!="")
	 {
		table.draw();
	 }
	 else
	 {
		 alert("Select video to display questions."); 
	 }
 });


$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});


</script

@endpush

@endsection





