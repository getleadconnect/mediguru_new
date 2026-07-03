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

.note-editable
{
	min-height:100px !important;
}

.st-radio{
	width:2rem;
	height:2rem;
	margin-top: -1px;
	vertical-align: middle;
}

#sh-course
{
	display:block;
}


</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Packages
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
						Prepare Package
					</h3>
				</div>
				
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<button type="button" id="btnCrsAdd" class="btn-accordion btn btn-primary btn-xs" aria-expanded="false" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							 Add Packages
							</button>
						</li>
						
					</ul>
				</div>
				
			</div>
			<div class="kt-portlet__body">
			
			<div class="accordion  accordion-toggle-arrow" id="accordionExample4">
			  <div class="card">
				<div id="collapseOne4" class="collapse " aria-labelledby="headingOne" data-parent="#accordionExample4">
				<div class="card-body" style="background:#e2f0f7;">
					
				 <form method="POST" id="myForm"  enctype="multipart/form-data"> 
				 @csrf
				<input type="hidden" id="pkgstatus" >
				<input type="hidden" id="package_type" name="package_type" value="2">
								

						<div class="row">
							<div class="col-lg-5">
							
							<div class="form-group">
							<div class="row">
							<div class="col-lg-6">
								<input type="radio" class="pkg_option st-radio" name="package_option"  required><span style="color:#000;"><b> Course Package</b></span>
							</div>
							<div class="col-lg-6">
								<input type="radio" class="pkg_option st-radio" name="package_option"  value="2" checked required ><span style="color:#000;"><b> Sub-Course Package</b></span>
							</div>
							</div>
							</div>
							
							<div class="form-group"  id="course">
							  <label>Select Course</label>
								<select id="course_id" name="course_id" class="form-control">
								<option value="">--select--</option>
								@foreach($crs as $r)
								<option value="{{$r->id}}">{{ $r->unique_id."-".$r->course_name }}</option>
								@endforeach
								</select>
							</div>
							
							<div class="form-group" id="subject">   <!-- sub courses ------------->
							  <label>Select Sub-Course</label>
								<select id="subject_id" name="subject_id" class="form-control" >
								<option value="">--select--</option>
								
								</select>
							</div>

							<div class="form-group">
								<label>Package Name <span id="pkgna"> </span> </label>
								<input type="text" id="package_name" name="package_name" class="form-control" required>
							</div>
							
							
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
						</div>
						
						
						<div class="col-lg-7">
						
							<div class="form-group">
							<label>Package Rate </label>
							<input type="number" style="width:200px;" id="package_rate" name="package_rate" class="form-control" required>
							</div>
							
							<div class="form-group">
							<label>Description </label>
							<textarea name="description" id="description" class="textarea form-control" required></textarea>
							</div>

						   <div class="form-group text-right">
						   <label>&nbsp; </label>
							<button type="submit" id="btnSave" class="btn btn-primary"> Submit </button>
						   </div>
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
						
						 <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							
							<thead>
								<tr>
									<th>Id</th>
									<th>Course/Subject</th>
									<th>Package</th>
									<th>Period</th>
									<th>Rate</th>
									<th>Status</th>
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
	
	<!--end::Modal-->

@push('scripts')
<!--<script src="{{ asset('js/pages/crud/datatables/advanced/column-rendering.js')}}" type="text/javascript"></script>-->
<script>


$(".textarea").summernote({dialogsInBody: true});

$("#subject_id").prop("required",true);
$("#btnSave").prop('disabled',true);

 $(document).ready(function()
 {

    $("#pkgna").html("[SUB-COURSE]");
 
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
 


$(".pkg_option").change(function()
{
	if($(this).val()==1)
	{
		$("#subject").hide();
		$("#course_id").prop("required",true);
		$("#subject_id").prop("required",false);
		$("#package_type").val('1');
		$("#pkgna").html("[FULL COURSE]");
		
	}
	else
	{
		$("#subject").show();
		$("#course_id").prop("required",false);
		$("#subject_id").prop("required",true);
		$("#package_type").val('2');
		$("#pkgna").html("[SUB-COURSE]");
	}
	
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
				data.search = $('input[type="search"]').val();
		    },
          },

		columnDefs:[
				      {"width":"50px","targets":0},
					  {"class":"text-right","targets":4},
					  {"width":"60px","targets":[4,5]},
					  {"width":"90px","targets":6},
				   ],
	
        columns: [
            {"data": "id" },
			{"data": "cname" },
			//{"data": "sname" },
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
	
$("#course_id").change(function()
{
	var popt=$("input[name='package_option']:checked").val();
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
		   $("#subject_id").empty();
		   $("#subject_id").append(res);
		}
	  });
	}
	if(popt==1)
	{
	check_package();
	}
	
});

$("#subject_id").change(function()
{
	check_package();
});


function check_package()
{
	var popt=$("input[name='package_option']:checked").val();
	
	var cid=$("#course_id").val();
	var scid=$("#subject_id").val();
		
	if(popt==1)
	{
		id=cid;
		op=1;
	}
	else
	{
		id=scid;
		op=2;
	}
		
		jQuery.ajax({
			type: "GET",
			url: "check_package_exist"+"/"+id+"/"+op,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
				if(res==1)
				{
					$("#btnSave").prop('disabled',true);
					$("#pkgstatus").val(res);
					alert("Package already added.");
				}
				else
				{
					$("#pkgstatus").val(res);
					$("#btnSave").prop('disabled',false);
				}
				
			}
		});
}


$("form#myForm").submit(function(e)
{
	e.preventDefault();    

		if($("#pkgstatus").val()==0)
		{
		
			var check='';
			var id='';
			var op=1;
			var cid=$("#course_id").val();
			var scid=$("#subject_id").val();
			
			if(cid!='' && scid!='')
			{
				id=scid;
				op=2;
			}
			else
			{
				id=cid;
				op=1;
			}

			var formData = new FormData(this);
			$.ajax({
				url: "save_package",  
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
						$("#start_date").val('');
						$("#expiry_date").val('');
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
			$("#btnSave").prop('disabled',true);
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
			url: "edit_package"+"/"+id,
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





