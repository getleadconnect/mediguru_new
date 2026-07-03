<form method="post" action="{{ url('update_chapter') }}" enctype="multipart/form-data">
	@csrf
      <input type="hidden" name="ed_cha_id" value="{{ $cha->id }}" >
	  <input type="hidden" name="ed_cha_icon" value="{{ $cha->chapter_icon }}" >
		<div class="row">
		<div class="col-xl-8 col-xxl-8 col-lg-8">
		<div class="form-group">
			<label>chapter Icon (.jpg|.png only)</label>
				<input type="file" onchange="fileValidation();" id="ed_chapter_icon" class="form-control" name="ed_chapter_icon">
			</div>
		</div>
		<div class="col-xl-4 col-xxl-4 col-lg-4">
			<img src="{{ url('uploads')."/".$cha->chapter_icon }}" id="ed_icon_output" style="width:60px;">
		</div>
		</div>
		
		<div class="form-group">
			<label>Course Name </label>
			<select name="ed_course_id" class="form-control" required>
			<option value="">--select--</option>
			@foreach($crs as $r)
			<option value="{{$r->id}}" @if($r->id==$cha->course_id){!! "selected" !!} @endif>{{ $r->course_name}}</option>
			@endforeach
			</select>
		</div>
		
		<div class="form-group">
			<label>Sub-Course Name </label>
			<select name="ed_subject_id" class="form-control" required>
			<option value="">--select--</option>
			@foreach($sub as $r)
			<option value="{{$r->id}}" @if($r->id==$cha->subject_id){!! "selected" !!} @endif>{{ $r->subject_name}}</option>
			@endforeach
			</select>
		</div>
	
		
		<div class="form-group">
			<label>Chapter Name </label>
				<input type="text" id="ed_chapter_name" class="form-control input-default " name="ed_chapter_name"  value="{{$cha->chapter_name}}"required>
		</div>

		<div class="form-group">
			<label>Description </label>
				<textarea rows=3 class="form-control input-default " name="ed_description" required>{{$cha->description}}"</textarea>
			</div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-primary"> Update </button>
		<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
	</div>

</form>

<script>

//$(".textarea1").summernote();

$("#ed_chapter_icon").change(function() {
        var file = document.getElementById("ed_chapter_icon").files[0];
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
