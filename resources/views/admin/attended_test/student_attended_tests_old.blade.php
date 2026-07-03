@extends('admin.layouts.master')
@section('title','Categories')
@section('contents')
<style>

.btn-s-menu {
	margin-top:8px;
    padding: 0.3rem 0.75rem !important;
    font-size: 0.75rem;
	/*width:100%;*/
	margin-left:20px;
	text-align: left;
	background-color:#73b0cb;
	border-color:#73b0cb;
}

table.dataTable thead th, table.dataTable tfoot th {
    font-size: 13px !important;
    font-weight: 600 !important;
}

.accor_head
{
border-color:#ebebeb !important;
background-color:#ebebeb !important;
padding:7px 10px 7px 10px;
width:200px !important;
}
.accordion-solid-bg .accordion__body {
	border-color: transparent;
	background-color: #ebebeb;
	border-bottom-left-radius: 0.75rem;
	border-bottom-right-radius: 0.75rem;
}

.accordion__item {
	margin-bottom: 0.25rem;
}

.accordion__body--text {
		padding: 0.5rem 1.25rem;
}

#datatable1 tbody tr:hover {
    background-color: #e4e4e4 !important;
}

</style>
	<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

		<div class="container-fluid">
			<div class="row">
			  <div class="col-lg-10 col-xl-10 col-xxl-10">
				<div class="form-head d-flex align-items-start" >
					<div class="mr-auto d-none d-lg-block mb-0" >
						<h3 class="text-black-light font-w600 fs-18">&nbsp;&nbsp;&nbsp;Students Attended Test Details</h3>
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
				</div>
				<div class="col-lg-2 col-xl-2 col-xxl-2">
				
				</div>
				</div>
				
				
				<hr style="margin:3px 10px 3px 10px;">

				<div class="row">	
				
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<div class="card">	
							<!--<div class="card-header d-sm-flex d-block border-0 pb-0">
								<h3 class="fs-16 mb-3 mb-sm-0 text-black">Students and Test Details</h3>
								<div class="card-action card-tabs mt-3 mt-sm-0 mt-3 mt-sm-0">
									<!-- right side navigation here ------->
									<!--<button class="btn btn-primary btn-xs" id="btnAdd" data-toggle="modal" data-target="#basicModal-1"><i class="fa fa-plus"></i>Add</button>-->
								<!--</div>
								
							</div> -->
							
							<div class="card-body" style="padding:10px 20px 10px 20px;">
							
							  <div class="row">
								<div class="col-xl-4 col-xxl-4 col-lg-4">
								
								<label>Select Course</label>
									<div class="row mb-3">
										<div class="col-lg-12 col-xl-12 col-xxl-12">
										<select class="form-control" id="flt_course" name="flt_course" style="height:35px !important;" >
										<option value="">--Select--</option>
										@foreach($crs as $r)
										<option value="{{ $r->id}}">{{ $r->course_name}}</option>
										@endforeach
										</select>
									  </div>
									</div>
								<label><u><b>Students</b></u> </label>
									<table id="datatable1" class="display min-w850" width="100%">
                                        <thead>
										  <tr>
											<th>No</th>
											<th>Name</th>
										  </tr>
                                        </thead>
                                      <tbody>

 									  </tbody>
									  
									</table>

								</div>
								
								<div class="col-xl-8 col-xxl-8 col-lg-8">
								
								<div class="table-responsive">
									<table id="datatable2" class="display min-w850" width="100%" >
                                        <thead>
                                            <tr>
                                                <th>No</th>
												<th>Subject</th>
												<th>Question Paper</th>
												<th>Times</th>
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
					</div>
	
				</div>
            </div>
		
			
			<div class="modal fade " id="basicModal-2">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit</h5>
							<button type="button" class="close" data-dismiss="modal"><span>&times;</span>
							</button>
						</div>

						<div class="modal-body" style="padding:1rem !important;">
						
							

						</div>
					</div>
				</div>
			</div>
			
@push('scripts')

<script>
$(document).ready(function()
{
	//$('input[type="search"]').val("");
	
	var mes=$('#view_message').val().split('#');
	if(mes[0]=="success")
	{	
	    toastr.success(mes[1]);
	}
	else if(mes[0]=="danger")
	{
		toastr.error(mes[1]);
	}
});

var table = $('#datatable2').DataTable({
        processing: true,
        stateSave:true,
		paging     : true,
		bDestroy:true,
        pageLength :50,
		scrollX: true,
});

$("#flt_course").change(function()
{
	var crsid=$(this).val();
	 var table = $('#datatable1').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
		bDestroy:true,
		bInfo:false,
        pageLength :50,
		scrollX: true,
		
		'pagingType':"simple_numbers",
        'lengthChange': false,
		
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
			url:"view_student_names",
			data: function (data) 
		    {
				data.search = $('input[type="search"]').val();
				data.course = crsid;
		    },
		},
		
		columnDefs:[
				  {"width":"50px","targets":0},
				],
	
        columns: [
            {"data": "no" },
			{"data": "sname" },
        ]
   });
  

	
});
		





$("#datatable1").on('click','.lnkId',function()
{
	
	var stid=$(this).attr('id');

	var table2 = $('#datatable2').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
		bDestroy:true,
        pageLength :50,
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
			url:"view_test_details",
			data: {stid: stid},
			/*data: function (data) 
		    {
				data.search = $('input[type="search"]').val();
		    },*/
		},
		
		columnDefs:[
				  {"width":"50px","targets":0},
				  {"width":"50px","targets":3},
				],
	
        columns: [
            {"data": "no" },
			{"data": "subject" },
			{"data": "qpaper" },
			{"data": "ntimes" },
        ]
    });
});

$("#btnAll").click(function()
{
	$("#date_range").val('');
	$("#flt_course").val('');
	$("#flt_year").val('');
	table.draw();
});

$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});


</script>

@endpush

@endsection
