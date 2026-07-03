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
		Question Attendees List
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
						Attendees Details
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<!--<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							<i class="flaticon2-plus"></i> Add Course
							</button>-->
						</li>
						
					</ul>
					
					
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->

				
				<div class="row">
					<div class="col-xl-6 col-xxl-6 col-lg-6">
					
							<div class="row">
								<div class="col-lg-5 col-xl-5 col-xxl-5">
								<select name="course" id="course" class="form-control">
								<option value="">--Select Course--</option>
								@foreach($crs as $r)
								<option value="{{$r->id}}">{{ $r->course_name }}</option>
								@endforeach
								</select>
								</div>
								<div class="col-lg-7 col-xl-7 col-xxl-7">
								<select name="quest_paper_id" id="quest_paper_id" class="form-control">
								<option value="">--Select Question Paper--</option>
								
								
								</select>
								</div>
								</div>
								
							<hr style="margin:7px;">

						<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							<thead>
								<tr>
									<th>Id</th>
									<th>Question</th>
									<th>Category</th>
									<th></th>
									
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
					
					<div class="col-lg-6 col-xl-6 col-xxl-6">
					
					<div class="row pl-3">
						<table width="100%"><tr style="height:25px;"><td>
						
						<span class="badge badge-success" style="padding:3px 5px 3px 5px;" ><i class="fas fa-check"></i></span>&nbsp;
						Correct:&nbsp; <span id="canswer" style="font-size:14px;font-weight:600;color:#2bc155;">0</span></td>
						<td>
						<span class="badge badge-danger" style="padding:3px 7px 3px 7px;"><i class="fas fa-times"></i></span>&nbsp;
						Wrong :&nbsp;<span id="wanswer" style="font-size:14px;font-weight:600;color:#F46B68;">0</span><td>
						<td>
						<span class="badge badge-info" style="padding:3px 7px 3px 7px;">-</span> &nbsp;
						Skipped :&nbsp;<span id="sanswer" style="font-size:14px;font-weight:600;color:#369DC9;"> 0</span><td>
						</tr>
						</table>
						</div>
						<hr>
					
						<table id="datatable1" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
								<thead>
									<tr style="font-size:13px;">
										<th width="50">Id</th>
										<th >Student</th>
										<th width="50">Answer</th>
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

var qpid=$("#quest_paper_id").val();

$('#datatable1').DataTable({
        processing: true,
		stateSave:true,
		paging     : true,
        pageLength :10,
		bDestroy:true,
		scrollX: true,
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
			url:"view_qpaper_questions",
			data: function (data) 
		    {
				data.searchByQpid=$("#quest_paper_id").val();
				data.search = $('input[type="search"]').val();
			},
		},
		
		columnDefs:[
				  {"width":"50px","targets":0},
				],
	
        columns: [
            {"data": "id" },
			{"data": "quest" },
			{"data": "qmode" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ]
    });

$("#quest_paper_id").change(function()
{
	table.draw();
});


$("#course").change(function()
{
	var cid=$(this).val();
	jQuery.ajax({
			type: "GET",
			url: "get_question_papers"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#quest_paper_id").empty();
			   $("#quest_paper_id").append(res);
			}
			});
});



 $('#datatable tbody').on( 'click', '.attendies', function(e)
  {
	e.preventDefault();
	
	var qid=$(this).attr('id');
	
	jQuery.ajax({
			type: "GET",
			url: "get_attendees_total"+"/"+qid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   var tot=res.split(',');
				$("#canswer").html(tot[0]);
				$("#wanswer").html(tot[1]);
				$("#sanswer").html(tot[2]);
			}
		});
	
	get_attendees(qid);
   
	
  });
  
 function get_attendees(qid)
 {
	 var tb=$('#datatable1').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
		bDestroy:true,
        pageLength :10,
		scrollX: true,

		'pagingType':"simple_numbers",
        'lengthChange': true,
		
        ajax: {
			url:"get_attendees",
			data: function (data) 
		    {
				data.quest_id = qid;
				data.search = $('input[type="search"]').val();
			},
		},
		
		columnDefs:[
				  {"width":"50px","targets":0},
				],
	
        columns: [
            {"data": "id" },
			{"data": "sname" },
			{"data": "answer" },
        ],
				
    });
 }

</script

@endpush

@endsection





