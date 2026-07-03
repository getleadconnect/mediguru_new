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
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Promocodes
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
						Promocode List
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs" aria-expanded="false" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							 Add Promocode
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
							
							
					<form method="post" action="" enctype="multipart/form-data" autocomplete=off>
							@csrf
						  
								<div class="form-group">
								<div class="row">
								<div class="col-lg-4 col-xl-4 col-xxl-4">
								<label >Select Course </label>
									<select id="course_id"  name="course_id" class="form-control" required>
									<option value="">--select--</option>
									@foreach($crs as $r)
									<option value="{{$r->id}}" >{{ $r->course_name }}</option>
									@endforeach
									</select>
								</div>
								
								<div class="col-lg-3 col-xl-3 col-xxl-3">
								<label >Promocode </label>
									<input type="text" id="promocode" class="form-control" name="promocode" required>
								</div>
								
								<div class="col-lg-1 col-xl-1 col-xxl-1 pr-0">
								<label >Amt.% </label>
									<input type="number" id="percentage" class="form-control" name="percentage" required>
								</div>
								
								<div class="col-lg-2 col-xl-2 col-xxl-2">
								  <label >Expiry Date</label>
									<input type="text" id="kt_datepicker_1" class="form-control"  name="expiry_date" required>
								</div>
								
								</div>
								<div class="row mt-2">								
								<div class="col-lg-4 col-xl-4 col-xxl-4">
								<input type="checkbox" name="user_check" id="user_check" style="margin-bottom:12px;">&nbsp;User Discount</label>
									<br>
									<select id="user_id" name="user_id" class="form-control" style="width:100% !important;" disabled>
									<option value="">---select user---</option>
									@foreach($urs as $r)
									<option value="{{$r->user_id}}" >{{ strtoupper($r->name)." (".$r->user_id.")" }}</option>
									@endforeach
									</select>
								</div>

								<div class="col-lg-4 col-xl-4 col-xxl-4">
								<label>Select course for Discount</label>
									<select id="discount_course" name="discount_course" class="form-control" style="width:100% !important;">
									<option value="">---select user---</option>
									@foreach($crs as $r)
									<option value="{{$r->id}}" >{{ $r->course_name }}</option>
									@endforeach
									</select>
								</div>
								</div>
								
								
								<div class="row mt-2">
								
								<div class="col-lg-9 col-xl-9 col-xxl-9">
								<label >Description </label>
									<textarea rows=2 id="description" class="textarea form-control" name="description"></textarea>
								</div>
								
								<div class="col-lg-2 col-xl-2 col-xxl-2">
								<label >&nbsp; </label>
									<button type="submit" class="btn btn-primary mt-5"> Submit </button>&nbsp;
								</div>
								</div>
								
							 </form>
							
						</div>
					</div>
				</div>
				
				<div class="row mt-3">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
						 <thead>
							<tr>
								<th>Id</th>
								<th >Course</th>
								<th >Promocode</th>
								<th >Amt.%</th>
								<th >Exp_Date</th>
								<th >User</th>
								<th >Disc.Course</th>
								<th >Description</th>
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

@push('scripts')
<!--<script src="{{ asset('js/pages/crud/datatables/advanced/column-rendering.js')}}" type="text/javascript"></script>-->
<script>

 $('#kt_datepicker_1').datepicker({
            format:'d-m-yyyy',
            todayHighlight: true,
            autoclose:true,
        });
		
$("#user_id").select2();

$("#user_check").click(function()
{
	$("#user_id").val('');
        if($(this).is(":checked"))
		{
          $("#user_id").prop('disabled',false);
		  
        }
        else
		{
			$("#user_id").val('');
            $("#user_id").prop('disabled',true);
        }
});



//$(".textarea").summernote({dialogsInBody: true});

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
		

        ajax: "view_promocodes",
		
		columnDefs:[
				  {"width":"100px","targets":[1,2]},
				  {"width":"110px","targets":9},
				],
	
        columns: [
            {"data": "id" },
			{"data": "cname" },
			{"data": "pcode" },
			{"data": "pvalue" },
			{"data": "expdate" },
			{"data": "usr" },
			{"data": "dcrs" },
			{"data": "desc" },
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}

    });



 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var pid=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_promocode"+"/"+pid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
		
  });
  
  $('#datatable tbody').on( 'click', '.btndel', function (e)
  {
	 e.preventDefault();
	 
	var pid=$(this).attr('id');
	
	if(confirm("Are you sure, delete this item?"))
	{
	    jQuery.ajax({
			type: "GET",
			url: "delete_promocode"+"/"+pid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   if(res==1)
			   {
				   toastr.success("Promocode successfully removed.");
				   table.draw();
			   }
			   else
			   {
				   toastr.error("Something wrong, Try again.");
			   }
			}
		});
	}
		
  });
  
   $('#datatable tbody').on( 'click', '.btnActDeact', function (e)
  {
	 e.preventDefault();
	 
	var pid=$(this).attr('id');
	
	    jQuery.ajax({
			type: "GET",
			url: "activate_deactivate_promocode"+"/"+pid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   if(res==1)
			   {
				   toastr.success("Promocode successfully Activated.");
				   table.draw();
			   }
			   else if(res==2)
			   {
				   toastr.success("Promocode successfully deactivated.");
				   table.draw();
			   }
			   else
			   {
				   toastr.error("Something wrong, Try again.");
			   }
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





