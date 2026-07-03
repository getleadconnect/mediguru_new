<form method="post" action="{{ url('update_banner') }}" enctype="multipart/form-data">
	@csrf
      <input type="hidden" name="bnr_id" value="{{ $bnr->id }}" >
	  <input type="hidden" name="bnr_image" value="{{ $bnr->banner_image }}" >
		<div class="row">
		<div class="col-xl-8 col-xxl-8 col-lg-8">
		<div class="form-group">
			<label>Course Icon (.jpg|.png only)</label>
				<input type="file" onchange="fileValidation();" id="ed_banner_image" class="form-control" name="banner_image" equired>
			</div>
		</div>
		<div class="col-xl-4 col-xxl-4 col-lg-4">
			<img src="{{ config('constans.file_path').$bnr->banner_image }}" id="ed_bnr_output" style="width:130px;">
		</div>
		</div>
	
	
		<div class="form-group">
			<label>Bannser Section </label>
			<select name="banner_section" class="form-control" required>
					<option value="1" @if($bnr->banner_section==1) {!! "selected" !!} @endif>Dashboard Banner</option>
					<option value="2" @if($bnr->banner_section==2) {!! "selected" !!} @endif>Subject Banner</option>
			</select>
			</div>


	<div class="modal-footer">
		<button type="submit" class="btn btn-primary"> Update </button>
		<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
	</div>

</form>

<script>
$("#ed_banner_image").change(function() {
        var file = document.getElementById("ed_banner_image").files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $("#ed_bnr_output").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
   }); 

function fileValidation()
{
	 var fileInput = document.getElementById('ed_banner_image'); 
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
