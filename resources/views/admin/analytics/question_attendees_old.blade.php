@extends('admin.layouts.master')
@section('title','Dashboard')
@section('contents')
<style>
table.dataTable thead th, table.dataTable tfoot th {
    font-size: 12px !important;
    font-weight: bold;
}
</style>
<div class="container-fluid">
				<div class="form-head d-flex align-items-start" >
					<div class="mr-auto d-none d-lg-block mb-0" >
						<h3 class="text-black-light font-w600 fs-16">Question Attendees List</h3>
						<!--<p class="mb-0 fs-18">Hospital Admin Dashboard Template</p>-->
					</div>
					
					<!--<div class="input-group search-area ml-auto d-inline-flex">
						<input type="text" class="form-control" placeholder="Search here">
						<div class="input-group-append">
							<button type="button" class="input-group-text"><i class="flaticon-381-search-2"></i></button>
						</div>
					</div>
					<a href="javascript:void(0);" class="settings-icon  ml-3"><i class="flaticon-381-settings-2 mr-0"></i></a>
					-->
				</div>
				<hr style="margin-top:0px;">
			
					<div class="row">
					<div class="col-xl-6 col-xxl-6 col-lg-6">
						<div class="card">	
							<div class="card-header d-sm-flex d-block border-0 pb-0">
								<!--<h3 class="fs-18 mb-3 mb-sm-0 text-black">Details</h3>-->
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
																
								<!--<div class="card-action card-tabs mt-3 mt-sm-0 mt-3 mt-sm-0 pl-3">
								</div> -->
								
							</div>
							<hr style="margin:7px;">
							<div class="card-body" style="padding:10px 20px 10px 20px;">
								
								<table id="datatable" class="display min-w850" width="100%">
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
						</div>
					</div>
					
					<div class="col-xl-6 col-xxl-6 col-lg-6">
						<div class="card">	
							<div class="card-header d-sm-flex d-block border-0 pb-0">
								<h3 class="fs-14 mb-3 mb-sm-0 text-black">Question Attendies List</h3>
								<div class="card-action card-tabs mt-3 mt-sm-0 mt-3 mt-sm-0">
									<!-- right side navigation here ------->
								</div>
							</div>
							<hr style="margin:7px;">
							<div class="card-body" style="padding:10px 20px 10px 20px;">
							
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
							
								<table id="datatable1" class="display min-w850" width="100%">
                                        <thead>
                                            <tr style="font-size:13px;">
                                                <th>Id</th>
												<th>Student</th>
												<th width="50px">Answer</th>
                                            </tr>
                                        </thead>
                                        <tbody>

										</tbody>
									</table>
								
							</div>
						</div>
					</div>
	
				</div>
            </div>
@push('scripts')
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

$("#quest_paper_id").click(function()
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


 $('#datatable tbody').on( 'click', '.attendies', function ()
  {
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
	
  });
  
 

</script>

@endpush

@endsection
