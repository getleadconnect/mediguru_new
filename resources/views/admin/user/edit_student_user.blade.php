<form method="post" action="{{ url('update_student_user') }}" enctype="multipart/form-data">
	@csrf
	
	   <input type="hidden" id="ed_user_id" name="ed_user_id" value="{{ $us->id }}" required>
	    <input type="hidden" id="student_id" name="ed_student_id" value="{{ $us->student_id }}" required>
	   
		<div class="form-group">
			<label>Mobile </label>
				<input type="text" id="ed_mobile" class="form-control " name="ed_mobile" value="{{ $us->mobile }}"required>
		</div>

		<div class="form-group">
			<label>Email </label>
				<input type="text" id="ed_email" class="form-control" name="ed_email" value="{{ $us->email }}" required>
		</div>
		
		<div class="form-group">
			<label>Password (<span style="font-size:11px;color:red;">To change, type new password</span>)</label>
				<input type="text" id="ed_password" class="form-control" name="ed_password" >
		</div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-primary"> Submit </button>
		<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
	</div>

</form>