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
		Question Bank
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
							<a href="{{ url('add_question')}}" style="width:80px;background:none !important;">
							<button type="button" class="btn-accordion btn btn-primary btn-xs" >Add</button>
							</a>
						</li>
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
								<label class="col-lg-2 col-xl-2 col-xxl-2" style="padding-top:9px;">Select Subject</label>
								<div class="col-lg-3 col-xl-3 col-xxl-3">
								   <select id="flt_subject_id" class="form-control " name="flt_subject_id" required>
									<option value="">--select--</option>
									@if(!empty($sub))
										@foreach($sub as $r)
											<option value="{{$r->id}}" @if ($r->id==Session::get('qb_sub_id')) {!! "selected" !!} @endif>{{ $r->subject_name }}</option>
										@endforeach
									@endif
									</select>
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
									<th>Subject</th>
									<th width="300px">Image/Question</th>
									<th width="250px">Answer</th>
									<th>True Answer</th>
									<th width="300px">Explanation</th>
									<th>Status</th>
									<th width="120px">Action</th>
								</tr>
							</thead>
							<tbody>
				
							</tbody>
							
						</table>
					</div>
				
				</div>

				<!--End:: Content-->
			</div>
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
	
	<!--begin::Modal-->
	<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

$(".textarea").summernote();

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


 $('#btnAdd').click(function()
 {
	$("#image_output").attr('src','');
 });


/*$("#course_id").change(function()
{
	var cid=$(this).val();

	jQuery.ajax({
			type: "GET",
			url: "get_subjects_by_course_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#subject_id").empty();
			   $("#subject_id").append(res);
			}
			});
});

$("#subject_id").change(function()
{
	var sid=$(this).val();

	jQuery.ajax({
			type: "GET",
			url: "get_question_paper_by_subject_id"+"/"+sid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#qpaper_id").empty();
			   $("#qpaper_id").append(res);
			}
			});
});
*/

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
          url: "view_questions",
          data: function (data) 
		    {
                data.searchBySubject = $('#flt_subject_id').val();
				data.search = $('input[type="search"]').val();
		    },
          },

		columnDefs:[
				      {"width":"150px","targets":2},
				   ],
	
        columns: [
            {"data": "id" },
			{"data": "subject" },
			{"data": "quest" },
			{"data": "answer" },
			{"data": "cans" },
			{"data": "expl" },
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) 
		{
			$('input[type="search"]').val('');
		}
    });

 $("#flt_subject_id").change(function()
 {
	table.draw();
 });


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	    
		var qid=$(this).attr('id');
		var Result=$("#kt_modal_1 .modal-body");
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_question"+"/"+qid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res)
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





