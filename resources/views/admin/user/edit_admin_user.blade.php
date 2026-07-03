<form method="post" action="{{ url('update_admin_user') }}" enctype="multipart/form-data">
	@csrf
	
	   <input type="hidden" id="auserid" name="auserid" value="{{ $au->id }}" required>
	   
		<div class="form-group">
			<label>Name </label>
				<input type="text" id="name" class="form-control " name="ed_name" value="{{ $au->name }}"required>
		</div>

		<div class="form-group">
			<label>Email </label>
				<input type="text" id="email" class="form-control" name="ed_email" value="{{ $au->email }}" required>
		</div>
		<div class="form-group">
			<label>Mobile </label>
				<input type="text" id="mobile" class="form-control" name="ed_mobile" value="{{ $au->mobile }}" required>
		</div>
		
		<div class="form-group">
			<label>Password (<span style="font-size:11px;color:red;">To change, type new password</span>)</label>
				<input type="text" id="ed_password" class="form-control" name="ed_password"  >
		</div>
		
		<div class="form-group">
			<label>Select Role </label>
				<select id="ed_role" class="form-control" name="ed_role" required>
				<option value="">--select--</option>
				@foreach($rol as $r)
				<option value="{{$r->id}}" @if($r->id==$au->role_id) {!! "selected" !!} @endif>{{$r->role_name}}</option>
				@endforeach
				</select>
		 </div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-primary"> Submit </button>
		<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
	</div>

</form>