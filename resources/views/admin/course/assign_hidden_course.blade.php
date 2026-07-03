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
		Assign Hidden Course To User
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
						Course List
					</h3>
				</div>
				
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<!-- button here ----->
						</li>
					</ul>

				</div>
				
			</div>
			<div class="kt-portlet__body">

			<div class="row mt-2">

			@if(!empty($crs))
			@foreach($crs as $key=>$r)
						
					<div class="col-lg-4">

								<div class="kt-portlet kt-portlet--head-xl kt-portlet--mobile" style="border:1px solid #d9efda; border-radius:5px;">
										<div class="kt-portlet__head" style="background:#8b8988;">
											<div class="kt-portlet__head-label">
												<h3 class="kt-portlet__head-title" style="font-size:14px;">
												<b> {{ $r->course_name }}</b>
												</h3>
											</div>
											<div class="kt-portlet__head-toolbar" style="margin-top: 10px;margin-right: -10">
												<div class="dropdown dropdown-inline">
													<a href="#" class="btn btn-default btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background:#a7d1a9;">
														<i class="flaticon-more-1" style="color:#fff;"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right">
														<ul class="kt-nav">
																													
															<li class="kt-nav__item">
																<a href="#" id="{{$r->unique_id}}" data-toggle="modal"  class="assign_to_user kt-nav__link" >
																	<i class="kt-nav__link-icon flaticon2-file-1"></i>
																	<span class="kt-nav__link-text">Assign To User</span>
																</a>
															</li>
															
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="kt-portlet__body" style="background:#c4c4c4;">
										
										<div class="row">
											<div class="col-lg-3">
												<img src="{{ config('constants.file_path').$r->course_icon}}" style="width:50px;height:50px">
												</div>
												<div class="col-lg-7">
												
												@if($r->status==1)
													<span>Status:</span><span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span></label>
												@else
													Status:<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>
												@endif
												<label style="margin: 0.3rem;">Unique Id :<b>{{ $r->unique_id }}</b></label>
												</div>
										</div>
											
										{{$r->description}}
										</div>
			
									</div>
						</div>
				@endforeach
				@endif

			</div>

			<div class="row mt-3">
			<div class="col-lg-12 col-xl-12 col-xxl-12">
			<label><b><u>Course Assigned User List </u></b></label>
					<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							<thead>
								<tr>
									<th>No</th>
									<th>User</th>
									<th>Course</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							@if(!empty($hcrs))
							@foreach($hcrs as $key=>$r)
							<tr>
								<td width="60px">{{++$key}}</td>
								<td >{{$r->name}}</td>
								<td ><b>{{$r->course_name}}</b></td>
								<td width="90px">
								<a href="{{url('delete_user_hidden_course').'/'.$r->id}}" id="conf" class="btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a> 
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
	<div class="example-open modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Course</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
				
					<form method="post" action="{{url('course_assign_to_user')}}" enctype="multipart/form-data">
						@csrf
	
						<input type="hidden" name="assign_course_unique_id" id="assign_course_unique_id">
							
						<div class="form-group">
						<div class="row">
 							<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Select User</label>
							<div class="col-lg-9 col-xl-9 col-xxl-9">
							<select class="form-control" name="assign_student_id" id="assign_student_id" style="width:100%">
							<option value="">--select--</option>
							@foreach($usr as $r)
							  <option value="{{$r->student_id}}">{{ strtoupper($r->name)." (".$r->id.")"}}</option>
							@endforeach
							
							</select>
					  	</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
 							<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Select Package</label>
							<div class="col-lg-9 col-xl-9 col-xxl-9">
							<select class="form-control" name="assign_package_id" id="assign_package_id" style="width:100%">
							<option value="">--select--</option>
							@foreach($hpkg as $r)
							  <option value="{{$r->id}}">{{ strtoupper($r->package_name) }}</option>
							@endforeach
							
							</select>
					  	</div>
						</div>
						</div>
						
						<div class="form-group mb-2 text-right">
							   <button type="submit" class="btn btn-primary btn-xs">Submit </button>
							   <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" aria-label="Close">Close</button>
						</div>
					</form>	

				</div>
				
			</div>
		</div>
	</div>




@push('scripts')
<!--<script src="{{ asset('js/pages/crud/datatables/advanced/column-rendering.js')}}" type="text/javascript"></script>-->
<script>

$(".textarea").summernote({dialogsInBody: true});

$("#assign_student_id").select2();

$(".assign_to_user").click(function()
{
	var cid=$(this).attr('id');
	$("#assign_course_unique_id").val(cid);
	var Result1=$("#kt_modal_1 .modal-body");
	$(this).attr('data-target','#kt_modal_1');
	
});

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
	var cid=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
			$(this).attr('data-target','#kt_modal_1');
		
				jQuery.ajax({
				type: "GET",
				url: "edit_course"+"/"+cid,
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





