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
	min-height:110px !important;
}

.kt-portlet.kt-portlet--head-xl .kt-portlet__head {
				min-height: 50px !important;
			}
			
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Set Course Schedule
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
						Schedule List
					</h3>
				</div>
				
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs" aria-expanded="false" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							 Add Schedule
							</button>
						</li>
					</ul>

				</div>
				
			</div>
			<div class="kt-portlet__body">
			
			 <div class="accordion  accordion-toggle-arrow" id="accordionExample4">
			  <div class="card">
				<div id="collapseOne4" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample4">
 				 <div class="card-body" style="background:#e2f0f7;">
					<label><b><u> Add Course Schedule:</u></b></label>

						<form method="post" action="{{url('save_course_schedule')}}" enctype="multipart/form-data">
						@csrf

						<div class="form-group">
						<div class="row">
							<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Select Course</label>
							<div class="col-lg-4 col-xl-4 col-xxl-4">
							<select class="form-control" name="course_unique_id" id="course_unique_id" style="width:100%">
							<option value="">--select--</option>
							@foreach($crs as $r)
							  <option value="{{$r->unique_id}}">{{ strtoupper($r->course_name)}}</option>
							@endforeach
							
							</select>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Schedule Details</label>
						<textarea class="text_area form-control" name="course_schedule"></textarea>
						</div>
						</div>
						</div>
						
						<div class="form-group mb-2 text-right">
							   <button type="submit" class="btn btn-primary btn-xs">Submit </button>
						</div>
					</form>	
				</div>
			  </div>

			</div>
		</div>
			


		<div class="row mt-3">
		<div class="col-lg-12 col-xl-12 col-xxl-12">
			<label><b><u>Course Schedule List </u></b></label>
					<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							<thead>
								<tr>
									<th>No</th>
									<th>Course</th>
									<th>Schedule</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							@if(!empty($csh))
							@foreach($csh as $key=>$r)
							<tr>
								<td width="60px">{{++$key}}</td>
								<td >{{$r->course_name}}</td>
								<td ><b>{!! substr($r->course_schedule,0,450)!!}</b>
								<a href="#" id="{{ $r->id }}" class="csView kt-badge kt-badge--info  kt-badge--inline kt-badge--pill" data-toggle="modal"  title="View Schedule">More</a>
								</td>
								<td width="90px">
								<a href="#" id="{{ $r->id }}" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal"  title="Edit"><i class="fa fa-edit"></i></a>
								<a href="{{url('delete_course_schedule').'/'.$r->id}}" id="conf" class="btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a> 
							</td>
							</tr>
							@endforeach
							@endif
							</tbody>
						</table>
			
			</div>
			</div>
				<!--Begin:: Content-->
				<!--End:: Content-->
		<!--end:: Widgets/Sale Reports-->
	  </div>
     </div>
   </div>
</div>
</div>


<!--begin::Modal-->
	<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" >
		<div class="modal-dialog modal-lg" role="document">
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
	<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" >
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">View Schedule</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body" style="padding:10px 25px;">

				</div>
				
				<div class="modal-footer">
				   <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" >Close</button>
				</div>
			</div>
		</div>
	</div>

	<!--end::Modal-->



@push('scripts')
<!--<script src="{{ asset('js/pages/crud/datatables/advanced/column-rendering.js')}}" type="text/javascript"></script>-->
<script>

$(".text_area").summernote({dialogsInBody: true});

$("#course_unique_id").select2();


var table=$('#datatable').DataTable({
	"processing": true,
	'paging':true,
	'pageLength':25,
	'bDestroy':true,
	'saveState':true,
 });
 
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
});

 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var csid=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
			$(this).attr('data-target','#kt_modal_1');

				jQuery.ajax({
				type: "GET",
				url: "edit_course_schedule"+"/"+csid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   Result.html(res);
				}
			});
  });


$('#datatable tbody').on( 'click', '.csView', function ()
  {
	var csid=$(this).attr('id');
	
		var Result=$("#kt_modal_2 .modal-body");
		
			$(this).attr('data-target','#kt_modal_2');
		
				jQuery.ajax({
				type: "GET",
				url: "view_course_schedule_by_id"+"/"+csid,
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





