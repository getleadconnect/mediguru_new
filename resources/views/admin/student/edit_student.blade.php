<form method="post" action="{{url('update_student')}}" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="stud_id" value="{{$sts->id}}">
			<input type="hidden" name="stud_image" value="{{$sts->student_image}}">
			
			<div class="form-group">
				<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Enter Name </label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
					<input type="text" id="name" class="form-control input-default " name="name" value="{{ $sts->name }}" required>
				</div>
			</div>
			</div>
			
			<div class="row">
			<div class="col-xl-8 col-xxl-8 col-lg-8">
			 <div class="form-group">
				<label>Student Image </label>
					<input type="file" id="stud_image" class="form-control" name="stud_image" >
				</div>
			</div>
			<div class="col-xl-4 col-xxl-4 col-lg-4">
				<img src="{{ config('constants.file_path').$sts->student_image}}" id="image_output" style="width:80px;">
			</div>
			</div>
						
			<div class="form-group">
			<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Gender </label>
				<div class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">
					<input type="radio" id="name" class="st-radio" name="gender" value="Male" @if(strtoupper($sts->gender)=="MALE") {!! "checked" !!} @endif   >&nbsp;Male
				</div>
				<div class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">
					<input type="radio" id="name" class="st-radio" name="gender" value="Female" @if(strtoupper($sts->gender)=="FEMALE") {!! "checked" !!} @endif>&nbsp;Female
				</div>
			</div>
			</div>
			
			<div class="form-group">
				<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Date Of Birth </label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
					<input type="date" id="birthdate" class="form-control input-default " name="birthdate" value="{{ $sts->date_of_birth}}" required>
				</div>
			</div>
			</div>
			
			<div class="form-group">
				<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Mobile </label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
					<input type="number" id="mobile" class="form-control input-default " name="mobile" value="{{ $sts->mobile }}" required>
				</div>
			</div>
			</div>
			
			<div class="form-group">
				<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Email </label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
					<input type="email" id="email" class="form-control input-default " name="email" value="{{ $sts->email }}" required>
				</div>
			</div>
			</div>

			<div class="form-group">
				<div class="row">
				<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">State </label>
				<div class="col-lg-8 col-xl-8 col-xxl-8">
					<input type="text" id="state" class="form-control input-default " name="state" value="{{ $sts->state }}" required>
				</div>
			</div>
			</div>
			

		<div class="modal-footer">
			<button type="submit" class="btn btn-primary"> Submit </button>
			<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
		</div>
		
		</div><!-- row end -->
						
</form>
<script>
 $("#stud_image").change(function() {
      var file = document.getElementById("stud_image").files[0];
      if (file) {
          var reader = new FileReader();
        reader.onload = function() {
              $("#image_output").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
      }
 });
</script>

