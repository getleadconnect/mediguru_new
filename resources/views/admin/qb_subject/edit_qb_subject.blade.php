<form method="post" action="{{ url('update_qb_subject') }}" enctype="multipart/form-data">
	@csrf
      <input type="hidden" name="ed_subject_id" value="{{ $sub->id }}" >
	 
		
		<div class="form-group">
			<label>Subject Name </label>
				<input type="text" id="ed_subject_name" class="form-control input-default " name="ed_subject_name"  value="{{$sub->subject_name}}"required>
		</div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-primary"> Update </button>
		<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
	</div>

</form>

