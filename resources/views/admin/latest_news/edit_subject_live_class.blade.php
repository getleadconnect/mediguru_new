<style>
.note-editable
{
	min-height:150px !important;
}
</style>
<form method="post" action="{{ url('update_subject_live_class') }}" enctype="multipart/form-data">
	@csrf
      <input type="hidden" name="ed_live_class_id" value="{{ $slc->id }}" >
	  				
		<div class="form-group">
		<div class="row">
		  <label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Course</label>
		  <div class="col-lg-9 col-xl-9 col-xxl-9">
			  <select id="ed_course_id" class="form-control" name="ed_course_id" required>
			  <option value="">--select--</option>
			  @foreach($crs as $r)
			  <option value="{{$r->id}}"  @if($r->id==$slc->course_id) {!! "selected" !!} @endif  >{{$r->course_name }}</option>
			  @endforeach
			  </select>
		  </div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		  <label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Subject</label>
		  <div class="col-lg-9 col-xl-9 col-xxl-9">
			  <select id="ed_subject_id" class="form-control" name="ed_subject_id" required>
			  <option value="">--select--</option>
			  @foreach($subj as $r)
			  <option value="{{$r->id}}" @if($r->id==$slc->subject_id) {!! "selected" !!} @endif >{{$r->subject_name }}</option>
			  @endforeach
			  </select>
		  </div>
		</div>
		</div>
		
		
		<div class="form-group">
			<div class="row">
			  <label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Title </label>
			  <div class="col-lg-9 col-xl-9 col-xxl-9">
				  <input type="text" id="ed_class_title" class="form-control" name="ed_class_title" value="{{$slc->title }}" required>
			</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Display Order </label>
			<div class="col-lg-2 col-xl-2 col-xxl-2">
			<input type="number" id="ed_display_order" class="form-control" name="ed_display_order" value="{{$slc->display_order}}" required>
		</div>
		</div>
		</div>


		<div class="form-group" id="lnkid">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Specify Link (Vimeo-Event) </label>
		<div class="col-lg-9 col-xl-9 col-xxl-9">
			<input type="text" id="ed_class_link" class="form-control" name="ed_class_link" value="{{$slc->class_link}}">
		</div>
		</div>
		</div>
		
		<div class="form-group" id="chaid">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Chat Link (Vimeo) </label>
		<div class="col-lg-9 col-xl-9 col-xxl-9">
			<input type="text" id="ed_chat_link" class="form-control" name="ed_chat_link" value="{{$slc->chat_link}}">
		</div>
		</div>
		</div>
							
		<div class="form-group" id="cladate">
		<div class="row">
		<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Class Date </label>
		<div class="col-lg-5 col-xl-5 col-xxl-5">
			<input type="date" id="ed_class_date" class="form-control" name="ed_class_date" value="{{$slc->class_date}}">
		</div>
		</div>
		</div>

		<div class="form-group">
			<label>Description/News Details </label>
		<textarea rows=3 class="textarea2 form-control"  name="ed_description" required>{{$slc->description}}</textarea>
		</div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-primary btn-xs"> Update </button>
		<button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
	</div>

</form>

<script>

$(".textarea2").summernote({dialogsInBody: true});

$("#ed_course_id").change(function()
{
	var cid=$(this).val();
	alert(cid);
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
 
$("#ed_news_type").change(function()
{
	var ntype=$(this).val();
	
	if(ntype==2) /*Other option*/
	{
		
	}
	else
	{
		$("#ed_event_link").prop('disabled',false);
		$("#ed_event_link").prop('required',true);
		$("#ed_chat_link").prop('disabled',false);
		$("#ed_chat_link").prop('required',true);
		$("#ed_class_date").prop('disabled',false);
		$("#ed_class_date").prop('required',true);
	}
	
});
 
 if($("#ed_news_type").val()==2)
 {
		$("#lnkid").hide(); 
		$("#chaid").hide(); 
		$("#cladate").hide(); 
 }
 else
 {
	$("#lnkid").show(); 
	$("#chaid").show(); 
	$("#cladate").show(); 
 }
 
 

$("#ed_news_icon").change(function() {
       var file = document.getElementById("ed_news_icon").files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $("#ed_icon_output").attr("src", reader.result);
            }
        reader.readAsDataURL(file);
     }
}); 

function fileValidation()
{
	 var fileInput = document.getElementById('ed_news_icon'); 
	 var allowedExtensions="";
	 
		allowedExtensions = /(\.jpg|\.png)$/i;  
      
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
