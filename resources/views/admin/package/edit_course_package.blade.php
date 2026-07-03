<style>
.note-editable
{
	min-height:100px !important;
}
</style>
<form method="post" action="{{ url('update_course_package')}}" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="ed_pkgid" value="{{$pkg->id}}">

	    <div class="form-group">
		<label>Course Name</label>
			<select name="ed_course_id" class="form-control" required>
				<option value="">--select--</option>
				@foreach($crs as $r)
				<option value="{{$r->unique_id}}" @if($r->unique_id==$pkg->course_unique_id){!! "selected" !!} @endif>{{$r->course_name}}</option>
				@endforeach
			</select>
		</div>
		
		<div class="form-group">
			<label>Package Name </label>
			<input type="text" name="ed_package_name" class="form-control" value="{{$pkg->package_name}}" required>
		</div>
		
		<!--<div class="form-group">
			<div class="row">
				<div class="col-lg-6 col-xl-6 col-xxl-6">
				<label>Start_date </label>
				<input type="date" name="ed_start_date" class="form-control" value="{{$pkg->start_date}}" required>
				</div>
				<div class="col-lg-6 col-xl-6 col-xxl-6">
				<label>Start_date </label>
				<input type="date" name="ed_expiry_date" class="form-control" value="{{$pkg->expiry_date}}" required>
				</div>
			</div>
		</div>-->
		
		
		<div class="form-group">
		<label><b><u>Android Rate</u></b> </label>
			<div class="row">
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label>1 Year </label>
				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text">₹</span></div>
					<input type="number" class="form-control" id="ed_package_rate" name="ed_package_rate" placeholder="rate" value="{{$pkg->rate}}" required>
				</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label>6 Months </label>
				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text">₹</span></div>
					<input type="number" class="form-control" id="ed_rate_6_months" name="ed_rate_6_months" placeholder="rate" value="{{$pkg->rate_6_months}}" required>
				</div>
				</div>
				
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label>3 Months </label>
				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text">₹</span></div>
					<input type="number" class="form-control" id="ed_rate_3_months" name="ed_rate_3_months" placeholder="rate" value="{{$pkg->rate_3_months}}" required>
				</div>
				</div>
			</div>
		</div>
		
		
		<div class="form-group">
		<label><b><u>IOS Rate</u></b> </label>
			<div class="row">
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label> 1 Year </label>
				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text">₹</span></div>
					<input type="number" class="form-control" id="ed_ios_rate" name="ed_ios_rate" placeholder="rate" value="{{$pkg->ios_rate}}" required>
				</div>
				</div>
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label>6 Months </label>
				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text">₹</span></div>
					<input type="number" class="form-control" id="ed_ios_6_months" name="ed_ios_6_months" placeholder="rate" value="{{$pkg->ios_6_months}}" required>
				</div>
				</div>
				<div class="col-lg-4 col-xl-4 col-xxl-4">
				<label>3 Months </label>
				<div class="input-group">
					<div class="input-group-prepend"><span class="input-group-text">₹</span></div>
					<input type="number" class="form-control" id="ed_ios_3_months" name="ed_ios_3_months" placeholder="rate" value="{{$pkg->ios_3_months}}" required>
				</div>
				</div>
			</div>
		</div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-primary"> Submit </button>
		<button type="button" class="btn btn-danger" data-dismiss="modal"><span>Close</span></button>
	</div>
	</form>
	
	
<script>
//$(".textarea1").summernote({dialogsInBody: true});
</script>