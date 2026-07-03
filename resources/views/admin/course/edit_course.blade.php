<style>
.note-editable
{
	height:100px !important;
}
</style>
<form method="post" action="{{ url('update_course') }}" enctype="multipart/form-data">
	@csrf
      <input type="hidden" name="ed_course_id" value="{{ $crs->id }}" >
	  <input type="hidden" name="ed_crs_icon" value="{{ $crs->course_icon }}" >
	  
		<div class="form-group">
		<div class="row">
		<div class="col-lg-9 col-xl-9 col-xxl-9">
			<label>Course Icon (.jpg|.png only)</label>
			<input type="file" onchange="fileValidation();" id="ed_course_icon" class="form-control" name="ed_course_icon">
		</div>
		<div class="col-xl-2 col-xxl-2 col-lg-2">
			<img src="{{ config('constants.file_path').$crs->course_icon }}" id="ed_icon_output" style="width:60px;">
		</div>
		</div>
		</div>
	
	
		<div class="form-group">
			<div class="row">
			<div class="col-xl-4 col-xxl-4 col-lg-4">
				<label>Unique Id</label>
				<input type="text" id="ed_unique_id" class="form-control" name="ed_unique_id"  value="{{$crs->unique_id}}" required>
			</div>
			<div class="col-xl-8 col-xxl-8 col-lg-8">
				<label>Course Name </label>
				<input type="text" id="ed_catname" class="form-control" name="ed_course_name"  value="{{$crs->course_name}}" required>
			</div>
			</div>
		</div>
		
		<div class="form-group">
		<div class="row">
			<label class="col-lg-4 col-xl-4 col-xxl-4 col-form-label">Subscription End Date</label>
			<div class="col-lg-4 col-xl-4 col-xxl-4">
			<input type="date"  name="ed_subscription_end_date" class="form-control"  value="{{$crs->subscription_end_date}}" >
		</div>
		<div class="col-lg-4 col-xl-4 col-xxl-4 col-form-label ">
			<label class="kt-checkbox kt-checkbox--bold kt-checkbox--success">
				<input type="checkbox"  name="ed_course_type" @if($crs->course_type==1){{__('checked')}} @endif > Hidden Course	<span></span>
			</label>
		</div>
		</div>
		</div>

		<div class="form-group">
			<div class="row">
			<div class="col-lg-7 col-xl-7 col-xxl-7">
				<label>App Store Product Id </label>
				<input type="text" class="form-control"  name="ed_app_product_id" value="{{$crs->app_store_product_id}}" required>
			</div>
			
			<div class="col-lg-5 col-xl-5 col-xxl-5">
				<label>Subscription Type(IOS) </label>
				<select name="ed_subscription_type" class="form-control" required>
					<option value="">--select--</option>
					<option value="1" @if($crs->ios_subscription_type==1){{__('selected')}}@endif>Subscription</option>
					<option value="2" @if($crs->ios_subscription_type==2){{__('selected')}}@endif>Consumable</option>
				</select>
			</div>
			</div>
		</div>
				
		<div class="form-group">
			<label>Description </label>
				<textarea rows=3 class="form-control"  name="ed_description" required>{{$crs->description}}</textarea>
		</div>
		
		<div class="form-group">
		<div class="row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Re-Order No</label>
			<div class="col-lg-2 col-xl-2 col-xxl-2">
			<input type="number"  name="ed_reorder_no" class="form-control"  value="{{$crs->reorder_no}}" >
		</div>
		
		</div>
		</div>
		
		
		<div class="form-group">
			<label>Course Features </label>
				<textarea rows=3 class="textarea1 form-control"  name="ed_features" required>{{$crs->features}}</textarea>
		</div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-primary btn-xs"> Update </button>
		<button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
	</div>

</form>

<script>

$(".textarea1").summernote({dialogsInBody: true});

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
