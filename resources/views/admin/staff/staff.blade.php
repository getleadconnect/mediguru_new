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

.st-radio{
	width:2rem;
	height:2rem;
	margin-top: -1px;
	vertical-align: middle;
}

</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Staffs
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
						Staff List
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						
						<li class="nav-item">
							<button type="button" id="btnCrsAdd" class="btn-accordion btn btn-primary btn-xs" aria-expanded="false" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							 Add Staff
							</button>
						</li>
						
						<!--<li class="nav-item">
							<button class="btn-accordion btn btn-primary btn-xs" data-toggle="modal" data-target="#kt_modal_1"><i class="flaticon2-plus"></i>&nbsp;Add</button>
						</li>-->
						
					</ul>
	
				</div>
				
			</div>
			<div class="kt-portlet__body">
			
			<div class="accordion  accordion-toggle-arrow" id="accordionExample4">
			  <div class="card">
				<div id="collapseOne4" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample4">
				<div class="card-body" style="background:#e2f0f7;">
					
					<form  method="post" onsubmit="return check_gender();" action="" enctype="multipart/form-data">
					@csrf
						
						<div class="row">
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label >Staff Name </label>
						<input type="text" id="staff_name" class="form-control" name="staff_name" required>
						</div>
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						
							<label>Gender </label>
						<div class="row">
							<div class="col-lg-4 col-xl-4 col-xxl-4 text-right">
								<input type="radio" class="gender st-radio" name="gender" value="Male">&nbsp;Male
							</div>
							<div class="col-lg-4 col-xl-4 col-xxl-4">
								<input type="radio" class="gender st-radio" name="gender" value="Female">&nbsp;Female
							</div>
						</div>
						<label id="gerr" style="color:red;font-size:11px;"></label>
						</div>
						
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label >Mobile </label>
							<input type="number" id="mobile" class="form-control" name="mobile" required>
						</div>
						
						</div>
						
						
						<div class="row">
						<div class="col-lg-4 col-xl-4 col-xxl-4">
						<label >Email </label>
							<input type="email" id="email" class="form-control" name="email" required>
						</div>
						
						<div class="col-lg-2 col-xl-2 col-xxl-2">
						<label >Referral Code </label>
						<input type="text" id="referral_code" class="form-control" name="referral_code" required>
						</div>
						<div class="col-lg-2 col-xl-2 col-xxl-2">
							<label >Referral Value </label>
							<input type="number" id="referral_value" class="form-control" name="referral_value" required>
							</div>
							<label id="rf_err" style="color:red;font-size:11px;"></label>
						
						<div class="col-lg-2 col-xl-2 col-xxl-2col-form-label">
						<br>
							<button type="submit" class="btn btn-primary" style="margin-top:5px;"> Submit </button>
						</div>
						</div>
					</form>
						
					</div>
				</div>
			  </div>
			</div>

				<!--Begin:: Content-->
			
				<div class="row mt-3">
				<div class="col-xl-12 col-xxl-12 col-lg-12">
					<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							<thead>
								<tr>
									<th>Id</th>
									<th >Name</th>
									<th >Gender</th>
									<th >Mobile</th>
									<th >Email</th>
									<th >Ref-Code</th>
									<th >Ref-Value</th>
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
					<h5 class="modal-title" id="exampleModalLabel">Add Staff</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					<form  method="post" onsubmit="return check_gender();" action="" enctype="multipart/form-data">
							@csrf
								
								<div class="form-group">
								<label >Staff Name </label>
									<input type="text" id="staff_name" class="form-control" name="staff_name" required>
								</div>
								
								<div class="form-group">
								<div class="row">
									<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Gender </label>
									<div class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">
										<input type="radio" class="gender st-radio" name="gender" value="Male">&nbsp;Male
									</div>
									<div class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">
										<input type="radio" class="gender st-radio" name="gender" value="Female">&nbsp;Female
									</div>
								</div>
								<label id="gerr" style="color:red;font-size:11px;"></label>
								</div>
								
								<div class="form-group">
								<label >Mobile </label>
									<input type="number" id="mobile" class="form-control" name="mobile" required>
								</div>
								<div class="form-group">
								<label >Email </label>
									<input type="email" id="email" class="form-control" name="email" required>
								</div>
								
								<div class="form-group">
								
								<div class="row">
									<div class="col-lg-7 col-xl-7 col-xxl-7 col-form-label">
									<label >Referral Code </label>
									<input type="text" id="referral_code" class="form-control" name="referral_code" required>
									</div>
									<div class="col-lg-5 col-xl-5 col-xxl-5 col-form-label">
									<label >Referral Value </label>
									<input type="number" id="referral_value" class="form-control" name="referral_value" required>
									</div>
									<label id="rf_err" style="color:red;font-size:11px;"></label>
								</div>
	
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary"> Submit </button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								</div>
						</form>

					
				</div>
				
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
		
        ajax: "view_staffs",
		
		columnDefs:[
				  {"width":"150px","targets":1},
				  {"width":"110px","targets":8},

				],
	
        columns: [
            {"data": "id" },
			{"data": "sname" },
			{"data": "gender" },
			{"data": "mobile" },
			{"data": "email" },
			{"data": "rcode" },
			{"data": "rvalue" },
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) 
		{
			$('input[type="search"]').val('');
		}
		
    });


function check_gender()
{

	result=false;

	var isChecked = $('.gender:checked').val()?true:false;
	if(isChecked==true)
	{	
		$("#gerr").html("");
		res=true;
	}
	else
	{
		$("#gerr").html("Gender required");
		res=false;
	}

	var rfcode=$("#referral_code").val();
	
		jQuery.ajax({
				type: "GET",
				url: "check_referral_code"+"/"+rfcode,
				dataType: 'html',
				success: function(dat)
				{
				   if(dat==1)
				   {
					   $("#rf_err").html("Referral code already Exists");
					   res=false;
				   }
				   else
				   {
					   $("#rf_gerr").html("");
					   res=true;
				   }
				}
		});

return res;

}


$('#datatable tbody').on( 'click', '.edit', function ()
  {
	var sid=$(this).attr('id');
	
		var Result=$("#kt_modal_2 .modal-body");
		
		$(this).attr('data-target','#kt_modal_2');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_staff"+"/"+sid,
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





