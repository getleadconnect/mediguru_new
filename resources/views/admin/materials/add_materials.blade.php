<!-- SUB COURSES------------------------------------->
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
	 min-height:300px !important;
 }
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Add Class Materials
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
						Add Material 
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<a href="{{ url('materials') }}" class="btn-accordion btn btn-primary btn-xs"><i class="flaticon2-file"></i> View Materials</a>
						</li>
												
					</ul>
					
					
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->
				
				<!--begin::Accordion-->
				<div class="accordion  accordion-toggle-arrow" id="accordionExample4">
			
				  <div class="row mt-3">
					<div class="col-xl-12 col-xxl-12 col-lg-12">

					<form method="post" action="{{ url('save_materials')}}" enctype="multipart/form-data">
					@csrf
					       							 
						  <div class="row">
						   <div class="col-lg-2 col-xl-2 col-xxl-2">
						   <label>Unique Id</label>
							<input type="number" class="form-control" name="unique_id"  required>
						   </div>
						   
						   <div class="col-lg-3 col-xl-3 col-xxl-3">
						   <label>Material Icon(jpg/png only)</label>
						   <input type="file" id="material_icon" onchange="return fileValidation();" class="form-control" name="material_icon" required>
						   </div>
						   <div class="col-lg-1 col-xl-1 col-xxl-1">
						   <img src="" id="icon_output" style="width:60px;">
						   </div>
						    <div class="col-lg-6 col-xl-6 col-xxl-6">
							<label>Material Title</label>
							<input type="text" name="material_title" class="form-control"></textarea>
						   </div>
						   </div>
					 
						 <div class="row mt-3">
							 <div class="col-lg-12 col-xl-12 col-xxl-12">
							<textarea rows=10 class="textarea form-control" name="material_data" ></textarea>
							 </div>
							 </div>
							 
							<div class="row mt-3">
							<div class="col-lg-12 col-xl-12 col-xxl-12 text-right">
							<button type="submit" class="btn btn-primary btn-xs" style="padding:10px 25px 10px 25px;">Submit </button>
							</div>
							</div>
						</form>
					</div>
				
				</div>

				<!--End:: Content-->
			</div>
		</div>
</div>
		<!--end:: Widgets/Sale Reports-->

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
 });
 
   $("#material_icon").change(function() {
        var file = document.getElementById("material_icon").files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $("#icon_output").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
   });

$("#course_id").change(function()
{
	var cid=$(this).val();
	jQuery.ajax({
			type: "GET",
			url: "get_subjects_by_course_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#subject_id").html(res);
			}
       });
	   
	var cid=$(this).val();
	    jQuery.ajax({
			type: "GET",
			url: "get_vimeo_videos_by_course_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#video_id").html(res);
			}
       }); 
   
});

$("#subject_id").change(function()
{
	var cid=$(this).val();
	jQuery.ajax({
			type: "GET",
			url: "get_chapters_by_subject_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#chapter_id").html(res);
			}
       });
});
  

$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});



</script>

@endpush

@endsection





