<form  method="post" action="{{url('update_staff')}}" enctype="multipart/form-data">
	@csrf
		
		<input type="hidden" id="staff_id" class="form-control" name="staff_id" value="{{$stf->id}}" >
		
		<div class="form-group">
		<label >Staff Name </label>
		<input type="text" id="staff_name" class="form-control" name="staff_name" value="{{$stf->staff_name}}"required>
		</div>
		
		<div class="form-group">
		<div class="row">
		<label class="col-lg-1 col-xl-1 col-xxl-1 pr-0">Gender</label>
			<div class="col-lg-3 col-xl-3 col-xxl-3 text-right">
				<input type="radio" class="gender st-radio" name="gender" value="Male" @if(strtoupper($stf->gender)=="MALE"){{ __('checked')}}@endif >&nbsp;Male
			</div>
			<div class="col-lg-3 col-xl-3 col-xxl-3">
				<input type="radio" class="gender st-radio" name="gender" value="Female" @if(strtoupper($stf->gender)=="FEMALE"){{ __('checked')}}@endif>&nbsp;Female
			</div>
		</div>
		</div>
		
		<div class="form-group">
		<label >Mobile </label>
			<input type="number" id="mobile" class="form-control" name="mobile" value="{{$stf->mobile}}" required>
		</div>
		

		<div class="form-group">
		<label >Email </label>
			<input type="email" id="email" class="form-control" name="email" value="{{$stf->email}}" required>
		</div>

		<div class="form-group">
		<div class="row">
		<div class="col-lg-6 col-xl-6 col-xxl-6">
		<label >Referral Code </label>
		<input type="text" id="referral_code" class="form-control" name="referral_code" value="{{$stf->referral_code}}" required>
		</div>
		
		<div class="col-lg-6 col-xl-6 col-xxl-6">
			<label >Referral Value </label>
			<input type="number" id="referral_value" class="form-control" name="referral_value"  value="{{$stf->referral_value}}" required>
		</div>
		</div>
		
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary" > Submit </button>
			<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
		</div>
		</div>
	</form>
						