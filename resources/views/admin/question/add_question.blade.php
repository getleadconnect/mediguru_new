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
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Question Bank
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
						Add Question
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<a href="{{url('questions')}}" class="btn-accordion btn btn-primary btn-xs"><i class="flaticon2-left-arrow"></i> Back </a>
						</li>
					</ul>
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->
				
				<!--begin::Accordion-->
				
				<div class="row">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<form method="post" action="{{url('save_question')}}" enctype="multipart/form-data">
							@csrf

						    <div class="form-group">
								<div class="row">
								<label class="col-lg-2 col-xl-2 col-form-label">Question Type </label>
							    <div class="col-lg-2 col-xl-2">	
									<select id="question_type" class="form-control input-default " name="question_type" required>
										<option value="">--select--</option>
										<option value="1">Text</option>
										<option value="2">Image</option>
							        </select>
							</div>
							
							<label class="col-lg-2 col-xl-2 col-form-label">Question Mode </label>
							    <div class="col-lg-2 col-xl-2">	
								 <select id="question_mode" class="form-control input-default " name="question_mode" required>
									 <option value="">--select--</option>
									 <option value="1">Easy</option>
									 <option value="2">Medium</option>
									 <option value="3">Difficult</option>
							     </select>
							</div>
							
							<label class="col-lg-1 col-xl-1 col-form-label">Subject </label>
							    <div class="col-lg-3 col-xl-3">	
								 <select id="subject_id" class="form-control input-default " name="subject_id" required>
									 <option value="">--select--</option>
									  @if(!empty($sub))
									    @foreach($sub as $r)
										  <option value="{{$r->id}}">{{ $r->subject_name }}</option>
									    @endforeach
								      @endif
							     </select>
							</div>
							
							
							
							
							</div>
							</div>
						
						    <div id="grp_question" class="form-group ">
								<div class="row">
								<label class="col-lg-2 col-xl-2 col-form-label">Question</label>
							    <div class="col-lg-10 col-xl-10">	
								<textarea id="question" class="form-control input-default " name="question" required></textarea>
							</div>
							</div>
							</div>
							
							<div id="quest_image" class="form-group">
								<div class="row">
								<div class="col-lg-6 col-cl-6 col-xxl-6">
								<label>Question Image </label>
								<input type="file" id="question_image" class="form-control" name="question_image" required>
								</div>
								<div class="col-xl-4 col-xxl-4 col-lg-4">
							    <img src="" id="image_output" style="width:200px;">
							</div>
							</div>
							</div>
							
							<div class="form-group">
							<div class="row">
							<div class="col-lg-6">
							<label>Answer - A </label>
							<textarea  class="form-control input-default " name="answer1" required></textarea>
							</div>
							<div class="col-lg-6">
							<label>Answer - B </label>
							<textarea class="form-control input-default " name="answer2" required></textarea>
							</div>
							</div>
							</div>
							
							<div class="form-group">
							<div class="row">
							<div class="col-lg-6">
							<label>Answer - C </label>
							<textarea  class="form-control input-default " name="answer3" required></textarea>
							</div>
							<div class="col-lg-6">
							<label>Answer - D </label>
							<textarea  class="form-control input-default " name="answer4" required></textarea>
							</div>
							</div>
							</div>
						
						<div class="form-group">
						<div class="row">
							<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Correct Answer </label>
							<div class="col-lg-5 col-xl-5 col-xxl-5">
								<select id="correct_answer" class="form-control input-default " name="correct_answer" required>
										<option value="">--select--</option>
										<option value="1">Answer - A</option>
										<option value="2">Answer - B</option>
										<option value="3">Answer - C</option>
										<option value="4">Answer - D</option>
							        </select>
							</div>
						</div>
						</div>

						<div class="form-group">
							<label>Explanation </label>
								<textarea rows=3 class="textarea1 form-control input-default " name="explanation" required></textarea>
						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-primary"> Submit </button>
						</div>
						
						</form>
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

$(".textarea1").summernote();

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


 $('#btnAdd').click(function()
 {
	$("#icon_output").attr('src','');
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
			   $("#subject_id").empty();
			   $("#subject_id").append(res);
			}
			});
});

$("#subject_id").change(function()
{
	var sid=$(this).val();

	jQuery.ajax({
			type: "GET",
			url: "get_question_paper_by_subject_id"+"/"+sid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#qpaper_id").empty();
			   $("#qpaper_id").append(res);
			}
			});
});


$("#question_type").change(function()
{
	var qtype=$(this).val();
	if(qtype==1)
	{
		$("#grp_question").show();
		$("#question").prop('required',true);
		$("#quest_image").hide();
		$("#question_image").prop('required',false);
	}
	else
	{
		$("#grp_question").hide();
		$("#question").prop('required',false);
		$("#quest_image").show();
		$("#question_image").prop('required',true);
	}

});


 $("#question_image").change(function() {
      var file = document.getElementById("question_image").files[0];
      if (file) {
          var reader = new FileReader();
        reader.onload = function() {
              $("#image_output").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
      }
 });


 $("#qpaper_icon").change(function() {
      var file = document.getElementById("qpaper_icon").files[0];
      if (file) {
          var reader = new FileReader();
        reader.onload = function() {
              $("#icon_output").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
      }
 });



$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});




</script

@endpush

@endsection





