<form method="post" action="{{ url('update_subject') }}" enctype="multipart/form-data">
	@csrf
      <input type="hidden" name="ed_subject_id" value="{{ $sub->id }}" >
	  <input type="hidden" name="ed_sub_icon" value="{{ $sub->subject_icon }}" >
	  
		<div class="form-group">
		<div class="row">
		<div class="col-xl-8 col-xxl-8 col-lg-8">
			<label>Subject Icon (.jpg|.png only)</label>
				<input type="file" onchange="fileValidation();" id="ed_subject_icon" class="form-control" name="ed_subject_icon">
			</div>

		<div class="col-xl-4 col-xxl-4 col-lg-4 text-center">
			<img src="{{ config('constants.file_path').$sub->subject_icon }}" id="ed_icon_output" style="width:80px;">
		</div>
		</div>
		</div>
		
		<div class="form-group">
		<div class="row">
		<div class="col-lg-7 col-xl-7 col-xxl-7" >
			<label>Course </label>
			<select id="ed_course_id" class="form-control" name="ed_course_id" required>
				<option value="">--select--</option>
				@foreach($crs as $r)
				<option value="{{$r->id}}" @if($r->id==$sub->course_id){!! "selected" !!} @endif>{{ $r->course_name }}</option>
				@endforeach
			</select>
		</div>
		
		<div class="col-lg-5 col-xl-5 col-xxl-5">
			<label>Subject Type </label>
				<select id="ed_subject_type" class="form-control input-default " name="ed_subject_type" required>
				<option value="">--select--</option>
				<option value="MCQ" @if($sub->subject_type=="MCQ"){!! "selected" !!} @endif>MCQ</option>
				<option value="OTHERS" @if($sub->subject_type=="OTHERS"){!! "selected" !!} @endif>OTHERS</option>
			</select>
		</div>
		</div>
		</div>
				
		
		<div class="form-group">
			<label>Subject Name </label>
				<input type="text" id="ed_subject_name" class="form-control input-default " name="ed_subject_name"  value="{{$sub->subject_name}}" required>
		</div>
		
		<div class="form-group row">
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Question Mark </label>
			<div class="col-lg-3 col-xl-3 col-xxl-3">
			<input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="ed_question_mark" value="{{ $sub->question_mark}}" required>
  		    </div>
			
		 <label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Negative Mark </label>
			<div class="col-lg-3 col-xl-3 col-xxl-3">
				<input type="text" class=" textarea form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="ed_negative_mark"  value="{{ $sub->negative_mark}}" required>
			</div>
		</div>
		

	   
	   <div class="form-group">
		 <div class="row">
		 <div class="col-lg-7 col-xl-7 col-xxl-7">
			<label class="">App Store Product Id </label>
			<input type="text" class="form-control" name="ed_app_store_product_id" value="{{ $sub->app_store_product_id }}" required>
		</div>
		<div class="col-lg-5 col-xl-5 col-xxl-5">
		<label class="">Subscription Type(IOS)</label>
				<select name="ed_subscription_type" class="form-control" required>
					<option value="">--select--</option>
					<option value="1" @if($sub->ios_subscription_type==1){{__('selected')}}@endif>Subscription</option>
					<option value="2" @if($sub->ios_subscription_type==2){{__('selected')}}@endif>Consumable</option>
				</select>
		</div>
		</div>
		</div>
		
		<label style="color:blue;">To set subscription end date</label>  
		   <div class="row">
		   
			<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Select Date </label>
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			<div class="input-group" style="width:150px;">
				<input type="date" class="form-control" style="width:150px;" name="ed_subscription_end_date" value="{{ $sub->subscription_end_date }}" required>
			</div>
		   </div>
		   </div>

		<div class="form-group mt-3">
			<label>Description </label>
				<textarea rows=3 class=" form-control input-default " name="ed_description" required>{{$sub->description}}"</textarea>
			</div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-primary"> Update </button>
		<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
	</div>

</form>

<script>

//$(".textarea1").summernote({dialogsInBody: true});

$("#ed_subject_icon").change(function() {
        var file = document.getElementById("ed_subject_icon").files[0];
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
	 var fileInput = document.getElementById('ed_subject_icon'); 
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
