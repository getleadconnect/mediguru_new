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


</style>
	<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

		<div class="container-fluid">
				<div class="form-head d-flex align-items-start" >
					<div class="mr-auto d-none d-lg-block mb-0" >
						<h3 class="text-black-light font-w600 fs-18">Packages</h3>
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
	
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<div class="card">	
							<div class="card-header d-sm-flex d-block border-0 pb-0">
								<h3 class="fs-18 mb-3 mb-sm-0 text-black">Packages</h3>
								<div class="card-action card-tabs mt-3 mt-sm-0 mt-3 mt-sm-0">
																									
								      <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#basicModal-1"><i class="fa fa-plus"></i>&nbsp;Add</button>
								   
								</div>
								
							</div>
							<hr style="margin:7px;">
							<div class="card-body" style="padding:10px 20px 10px 20px;">

								<div class="table-responsive">
									<table id="datatable" class="display min-w850" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
												<th >Course</th>
												<th >Package_Name</th>
												<th >Period</th>
												<th >Rate</th>
												<th >Status</th>
                                                <th width="80px">Action</th>
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

			
		<div class="modal fade " id="basicModal-1">
			<div class="modal-dialog modal-lg" role="document">
			   <div class="modal-content">
				  <div class="modal-header">
						<h5 class="modal-title">Edit</h5>
						<button type="button" class="close" data-dismiss="modal"><span>&times;</span>
						</button>
					</div>

					<div class="modal-body" style="padding:10px 25px 10px 25px !important;">
					
					<div class="row">
					<div class="col-lg-12 col-xl-12 col-xxl-12">

						<form method="post" action="" enctype="multipart/form-data">
									@csrf

									<div class="form-group row">
										<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Package Name</label>
										<div class="col-lg-10 col-xl-10 col-xxl-10">
										  <input type="text" name="package_name" class="form-control" required>
									  </div>
									</div>  
									
									<div class="form-group">
									 <div class="row">
									  
										<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Start Date </label>
										<div class="col-lg-4 col-xl-4 col-xxl-4">
										<input type="date" name="start_date" class="form-control"  required>
										</div>

										<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">End Date </label>
										<div class="col-lg-4 col-xl-4 col-xxl-4">
										<input type="date" name="expiry_date" class="form-control" required>
										</div>

									   </div>
									</div>
									
									<div class="form-group">
									<div class="row">
										<div class="col-lg-12 col-xl-12">
											<label style="margin-top:10px;"> Select Packages </label>
											
											<div style="width:100%;height:200px;overflow:auto;">
											 <table id="tbl_packages" class="tbl_pkgs" border=1 style="width:100%">
												<tr><th>Id</th><th>Package Name</th><th>Rate</th><th>&nbsp;</th></tr>
												@if(!empty($pkgs))
												@foreach($pkgs as $r)
												
												<tr><td>{{ $r->id }}</td><td>{{ $r->package_name }}</td><td width="100px">{{ $r->rate }}</td>
												<td width="100px">  
												  <button type="button" class="pselect btn btn-primary btn-xs" style="padding:2px 10px 2px 10px;">Select</button>
												</td></tr>
												@endforeach
												@endif
																							
											</table>
										</div>
										</div>
									</div>
									</div>
									
									<div class="form-group" >
									<div class="row" style="margin-top:10px;">
									<label class="col-lg-3 col-xl-3 col-form-label"> Selected Packages </label>
										<div class="col-lg-9 col-xl-9">
										<input type="text"  class="form-control" name="sel_packages" id="sel_packages" readonly>
										</div>
									</div>
									</div>
									
									<div class="form-group">
									<div class="row">
									<label class="col-lg-3 col-xl-3 col-form-label"> Amount </label>
										<div class="col-lg-5 col-xl-5">
										<input type="text"  class="form-control" name="amount" id="amount" readonly>
										</div>
									</div>
									</div>
	
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary"> Submit </button>
								    <button type="button" class="btn btn-danger" data-dismiss="modal"><span>Close</span></button>
								</div>
								</form>
							</div>
							<div class="row">
							  <div class="col-lg-6 col-xl-6 col-xxl-6">

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
          url: "view_packages",
          data: function (data) 
		    {
                data.searchByCourse = $('#flt_course_id').val();
				data.search = $('input[type="search"]').val();
		    },
          },

		columnDefs:[
				      {"width":"250px","targets":3},
				   ],
	
        columns: [
            {"data": "id" },
			{"data": "cname" },
			{"data": "pname" },
			{"data": "period" },
			{"data": "rate" },
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) 
		{
			$('input[type="search"]').val('');
		}
    });

 $("#flt_course_id").change(function()
 {
	 table.draw();
 });

 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');
	
		var Result=$("#basicModal-2 .modal-body");
		
		$(this).attr('data-target','#basicModal-2');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_package"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
		
  });

$("#tbl_packages").on('click','.pselect',function()
{
	var spkg="";
	var amount=0;
	if($(this).closest('tr').is(':selected',true))    //unselect item
	 {
		$(this).closest('tr').prop('selected',false); 
		$(this).closest('tr').css('background','#fff'); 
		var id=$(this).closest('tr').find('td').eq(0).text();
		//alert(id);
		var amt=parseInt($(this).closest('tr').find('td').eq(2).text());
		
		if($("#amount").val()==""){ amount=0;}else{	amount=parseInt($("#amount").val())}

		amount-=amt;
		$("#amount").val(amount);
		
		var id1=id+",";	
		var id2=","+id;	
		
		if($("#sel_packages").val().includes(id1))
		{
		var sids=$("#sel_packages").val().replace(id1, '');
		}
		else if($("#sel_packages").val().includes(id2))
		{
			var sids=$("#sel_packages").val().replace(id2, '');
		}
		else
		{
			var sids=$("#sel_packages").val().replace(id, '');
		}
		
		$("#sel_packages").val(sids);
		//$("#subids").val(sids);
	 }  
	 else  											//select item
	 {  
		$(this).closest('tr').prop('selected',true); 
		$(this).closest('tr').css('background','#c4c4c4'); 
		
		var id=$(this).closest('tr').find('td').eq(0).text();
		//alert(id);
		var amt=parseInt($(this).closest('tr').find('td').eq(2).text());
		if($("#amount").val()==""){ amount=0;}else{	amount=parseInt($("#amount").val())}
		amount+=amt;
		$("#amount").val(amount);

		if($("#sel_packages").val()=="")
		{
		   var sids=$("#sel_packages").val()+id;
		}
		else
		{
			var sids=$("#sel_packages").val()+","+id;
		}
		
		/*$.each($("#tbl_package tr.selected"),function()
		{ 
			spkg+=","+$(this).find('td').eq(0).text(); 
		});*/
		
		$("#sel_packages").val(sids);
		//$("#subids").val(sids);
	 }  

});

 

$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});


</script>

@endpush

@endsection
