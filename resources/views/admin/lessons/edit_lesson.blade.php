<form method="post" action="{{ url('update_lesson') }}" enctype="multipart/form-data">
	@csrf
      <input type="hidden" name="ed_les_id" value="{{ $les->id }}" >
	  <input type="hidden" name="ed_les_icon" value="{{ $les->lesson_icon }}" >
	  
		<div class="row">
		<div class="col-xl-8 col-xxl-8 col-lg-8">
		<div class="form-group">
			<label>Lesson Icon (.jpg|.png only)</label>
			  <input type="file" onchange="fileValidation();" id="ed_lesson_icon" class="form-control" name="ed_lesson_icon">
			</div>
		</div>
		<div class="col-xl-4 col-xxl-4 col-lg-4">
			<img src="{{config('constants.file_path').$les->lesson_icon }}" id="ed_icon_output" style="width:100px;">
		</div>
		</div>
		
		<div class="form-group row ">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Course Name </label>
			<div class="col-lg-9 col-xl-9 col-xxl-9">
			<select name="ed_course_id" id="ed_course_id" class="form-control" required>
			<option value="">--select--</option>
			@foreach($crs as $r)
			<option value="{{$r->id}}" @if($r->id==$les->course_id){!! "selected" !!} @endif>{{ $r->course_name}}</option>
			@endforeach
			</select>
		</div>
		</div>
		
		<div class="form-group row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 ">Sub-Course Name </label>
			<div class="col-lg-9 col-xl-9 col-xxl-9">
			<select name="ed_subject_id" id="ed_subject_id"  class="form-control" required>
			<option value="">--select--</option>
			@foreach($sub as $r)
			<option value="{{$r->id}}" @if($r->id==$les->subject_id){!! "selected" !!} @endif>{{ $r->subject_name}}</option>
			@endforeach
			</select>
		</div>
		</div>
		
		<div class="form-group row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Lesson Name </label>
			<div class="col-lg-9 col-xl-9 col-xxl-9">
				<input type="text" id="ed_lesson_name" class="form-control" name="ed_lesson_name"  value="{{$les->lesson_name}}"required>
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Order No </label>
			<div class="col-lg-9 col-xl-9 col-xxl-9">
				<input type="number" id="ed_order_no" class="form-control" style="width:100px;" name="ed_order_no"  value="{{$les->order_no}}"required>
			</div>
		</div>


	<div class="modal-footer">
		<button type="submit" class="btn btn-primary"> Update </button>
		<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
	</div>

</form>

<script>

//$(".textarea1").summernote({dialogsInBody: true});

$("#ed_lesson_icon").change(function() {
	var file = document.getElementById("ed_lesson_icon").files[0];
	if (file) {
		var reader = new FileReader();
		reader.onload = function() {
			$("#ed_icon_output").attr("src", reader.result);
		}
		reader.readAsDataURL(file);
	}
 });   
 
 
 $("#ed_course_id").change(function()
{
	var cid=$(this).val();

	jQuery.ajax({
			type: "GET",
			url: "get_subjects_by_course_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#ed_subject_id").html(res);
			}
       });
});

  
function fileValidation()
{
	var fileInput = document.getElementById('ed_chapter_icon'); 
	var allowedExtensions="";

	allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
		  
	 var filePath = fileInput.value; 
				
		if (!allowedExtensions.exec(filePath)) { 
			alert('Invalid file type, Try again.'); 
			fileInput.value = ''; 
			return false; 
		}
		else
		{
			return true;
		}
}
</script>
