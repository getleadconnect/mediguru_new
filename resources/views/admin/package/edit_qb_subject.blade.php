<form method="post" action="" enctype="multipart/form-data">
		@csrf
		<input type="text" name="pkgid" value="{{$pkg->id}}">

	   <div class="form-group">
		
		<label>Course </label>
			<select name="course_id" class="form-control">
			<option name="">--select--</option>
			@foreach($crs as $r)
			<option name="{{$r->id}}" @if($r->id==$pkg->course_id){!! "selected" !!} @endif>{{$r->course_name}}</option>
			@endforeach
			</select>
		</div>
		
		<div class="form-group">
			<label>Package Name </label>
			<input type="text" name="package_name" class="form-control" value="{{$pkg->package_name}}" required>
		</div>
		
		<div class="form-group">
			<label>Start_date </label>
			<input type="date" name="start_date" class="form-control" value="{{$pkg->start_date}}" required>
		</div>
		
		<div class="form-group">
			<label>Expiry Date </label>
			<input type="date" name="expiry_date" class="form-control" value="{{$pkg->expiry_date}}" required>
		</div>
		
		<div class="form-group">
			<label>Package Rate </label>
			<input type="number" name="package_rate" class="form-control"  value="{{$pkg->rate}}" required>
		</div>
	<hr>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary"> Submit </button>
		<button type="button" class="btn btn-danger" data-dismiss="modal"><span>Close</span></button>
	</div>
	</form>
	
	
	