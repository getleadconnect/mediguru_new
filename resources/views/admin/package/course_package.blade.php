@extends('admin.layouts.master')
@section('contents')

<style>

.card { border:none !important; }
.fa{	font-size:13px !important; }
.note-editable{ min-height:100px !important; }
.st-radio{	width:2rem;	height:2rem; margin-top: -1px;	vertical-align: middle; }
#sh-course{ display:block; }

</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Course Packages
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
						Package List
					</h3>
				</div>
				
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<button type="button" id="btnCrsAdd" class="btn-accordion btn btn-primary btn-xs" aria-expanded="false" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							 Add 
							</button>
						</li>
						
						<li class="nav-item">
							<a href="{{url('packages')}}" type="button" id="btnCrsAdd" class="btn-accordion btn btn-brand btn-xs" aria-expanded="false" >
							<i class="fa fa-arrow-left"></i> Subject Package</a>
						</li>
						
					</ul>
				</div>
				
			</div>
			<div class="kt-portlet__body">
			
			<div class="accordion  accordion-toggle-arrow" id="accordionExample4">
			  <div class="card">
				<div id="collapseOne4" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample4">
				<div class="card-body" style="background:#e2f0f7; padding-top:0.7rem;">
				<label><u><b>Add Course Package</b></u></label>	
				<form method="POST" id="crsMyForm" enctype="multipart/form-data"> 
				 @csrf
				 
				<input type="hidden" id="pkgstatus" >
					
						<div class="row">
							<div class="col-lg-5">

							<div class="form-group">
							  <label>Select Course</label>
								<select id="course_id" name="course_id" class="form-control" required>
								<option value="">--select--</option>
								@foreach($crs as $r)
								<option value="{{$r->id}}">{{ $r->unique_id."-".$r->course_name }}</option>
								@endforeach
								</select>
							</div>
							</div>
							<div class="col-lg-7">

							<div class="form-group">
								<label>Package Name </span> </label>
								<input type="text" id="package_name" name="package_name" class="form-control" required>
							</div>
							</div>
							
							<!--<div class="col-lg-4">
								<div class="form-group">
									<div class="row">
									<div class="col-lg-6 col-xl-6 col-xxl-6">
									<label>Start_date </label>
									<input type="date" id="start_date" name="start_date" class="form-control"  required>
									</div>
									<div class="col-lg-6 col-xl-6 col-xxl-6">
									<label>Expiry_date </label>
									<input type="date" id="expiry_date" name="expiry_date" class="form-control" required>
									</div>
								</div>
								</div> 
							</div> -->
							</div>
							
							<div class="row">
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<fieldset style="border:1px solid #b4bbdf;" class="p-2">
							<legend style="font-size:13px;width:100px;"><b>&nbsp;&nbsp;Android Rate</b></legend>
								<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label>1 Year </label>
										<div class="input-group">
											<div class="input-group-prepend"><span class="input-group-text">₹</span></div>
											<input type="number" class="form-control" id="package_rate" name="package_rate" placeholder="rate" required>
										</div>

									</div>
								</div>
								
								<div class="col-lg-4">
									<div class="form-group">
										<label>6 Months </label>
										<div class="input-group">
											<div class="input-group-prepend"><span class="input-group-text">₹</span></div>
											<input type="number" class="form-control" id="rate_6_months" name="rate_6_months" placeholder="rate" required>
										</div>

									</div>
								</div>
								
								<div class="col-lg-4">
									<div class="form-group">
										<label>3 Months </label>
										<div class="input-group">
											<div class="input-group-prepend"><span class="input-group-text">₹</span></div>
											<input type="number" class="form-control" id="rate_3_months" name="rate_3_months" placeholder="rate" required>
										</div>

									</div>
								</div>
							</div>
							</fieldset>
							</div>
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<fieldset style="border:1px solid #b4bbdf;" class="p-2">
							<legend style="font-size:13px;width:80px;"><b>&nbsp;&nbsp;IOS Rate</b></legend>
							<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<label>1 year </label>
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text">₹</span></div>
										<input type="number" class="form-control" id="ios_rate" name="ios_rate" placeholder="rate" required>
									</div>
								</div>
							</div>
							
							<div class="col-lg-4">
								<div class="form-group">
									<label>6 Months </label>
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text">₹</span></div>
										<input type="number" class="form-control" id="ios_6_months" name="ios_6_months" placeholder="rate" required>
									</div>
								</div>
							</div>
							
							<div class="col-lg-4">
								<div class="form-group">
									<label>3 Months </label>
									<div class="input-group">
										<div class="input-group-prepend"><span class="input-group-text">₹</span></div>
										<input type="number" class="form-control" id="ios_3_months" name="ios_3_months" placeholder="rate" required>
									</div>

								</div>
							</div>
						</div>
						</fieldset>
						</div>
						</div>
						<div class="row mt-2">
							<div class="col-lg-12 col-xl-12 col-xxl-12 text-right">
								<button type="submit" id="btnSave" class="btn btn-primary pl-5 pr-5"> Submit </button>
							</div>
						</div>
					</form>
			</div>
		</div>
	  </div>
	</div>

				<!--Begin:: Content-->

				<div class="row mt-3 ">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						 
						 <!--<table id="datatable" class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer" style="width:170% !important;">-->
						 <table id="datatable" class="table table-bordered">	
							<thead>
								<tr>
									
									<th>Id</th>
									<th>Course</th>
									<th>Package</th>
									<th>Subjects{{str_pad("",50," ",STR_PAD_RIGHT)}}</th>
									<!--<th>Period</th>-->
									<th>Andriod_Rate&nbsp;&nbsp;&nbsp;</th>
									<th>IOS_Rate&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
									<!--<th>Status</th>-->
									<th >Action</th>
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
	<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add/Delete Subjects</h5>
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


$(".textarea").summernote({dialogsInBody: true});


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
		scrollCollapse: true,
		
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
          url: "view_course_packages",
          data: function (data) 
		    {
				data.search = $('input[type="search"]').val();
		    },
          },

	  columnDefs:[
					 {"width":"50px","targets":0},
				   ],

      columns: [
		
			
            {"data": "id" },
			{"data": "cname" },
			//{"data": "sname" },
			{"data": "pname" },
			{"data": "subname" },
			//{"data": "period" },
			{"data": "rate" },
			{"data": "ios_rate" },
			//{"data": "status" },
			{"data": "action" ,orderable: false, searchable: false },
			
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
	
    });
	
	
$("#course_id").change(function()
{
	var cid=$(this).val();
			
	jQuery.ajax({
		type: "GET",
		url: "check_course_package_exist"+"/"+cid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
			if(res==1)
			{
				$("#pkgstatus").val('1');
				alert("Package already added.");
			}
			else
			{
				$("#pkgstatus").val('0');
			}
		}
	});

});


$("form#crsMyForm").submit(function(e)
{
	e.preventDefault();    

		if($("#pkgstatus").val()==0)
		{

			var formData = new FormData(this);
			$.ajax({
				url: "save_course_package",  
				type: 'POST',
				data: formData,
				success: function (res) 
				{
					if(res>=1)
					{
						alert("Package successfully added.");
						
						$("#subject_id").val('');
						$("#course_id").val('');
						$("#package_name").val('');
						$("#package_rate").val('');
						$("#rate_6_months").val('');
						$("#rate_3_months").val('');
						$("#ios_rate").val('');
						$("#ios_6_months").val('');
						$("#ios_3_months").val('');
						//$("#start_date").val('');
						//$("#expiry_date").val('');
						$(".note-editable").html('');
						table.draw();
					}
					else
					{
						alert("Details missing, Try again.");	
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
		}
		else
		{
			alert("Package already added.");
		}
});
	
	
	
	
 $("#flt_course_id").change(function()
 {
	 table.draw();
 });

 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_course_package"+"/"+id,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
		
  });
  
  $('#datatable tbody').on( 'click', '.btnADsub', function ()
  {
	var id=$(this).attr('id');
	var uid=$(this).attr('res');
	
		var Result=$("#kt_modal_2 .modal-body");
		
		$(this).attr('data-target','#kt_modal_2');
	
			jQuery.ajax({
			type: "GET",
			url: "get_add_delete_subjects"+"/"+id+"/"+uid,
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





