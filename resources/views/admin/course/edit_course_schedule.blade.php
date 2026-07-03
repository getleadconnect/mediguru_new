<style>
.text_area2 .note-editable
{
	min-height:110px !important;
}

.modal-header {
    padding: 0.5rem 1.25rem !important;
}
.modal-body {
    padding: 0.5rem 1.25rem !important;
}

</style>

		<form method="post" action="{{url('update_course_schedule')}}" enctype="multipart/form-data">
						@csrf

					<input type="hidden" name="ed_schedule_id" value="{{ $csh->id }}" >
 
						<div class="form-group">
						<div class="row">
							<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Select Course</label>
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							<select class="form-control" name="ed_course_unique_id" id="ed_course_unique_id" style="width:100%" required>
							<option value="">--select--</option>
							@foreach($crs as $r)
							  <option value="{{$r->unique_id}}" @if($r->unique_id==$csh->course_unique_id ){{ __('selected')}} @endif >{{ strtoupper($r->course_name)}}</option>
							@endforeach
							
							</select>
						</div>
						</div>
						</div>
						
						<div class="form-group">
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Schedule Details</label>
						<textarea class="text_area2 form-control" name="ed_course_schedule" required >{{ $csh->course_schedule }}</textarea>
						</div>
						</div>
						</div>
						
						<div class="form-group mb-2 text-right" style="margin-right:30px;">
							   <button type="submit" class="btn btn-primary btn-xs"> Update </button>
							   <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" >Close</button>
						</div>
					</form>	

<script>

$(".text_area2").summernote({dialogsInBody: true});

$("#ed_course_icon").change(function() {
        var file = document.getElementById("ed_course_icon").files[0];
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
	 var fileInput = document.getElementById('ed_course_icon'); 
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
