
<form method="post" action="{{ url('update_class_video') }}" enctype="multipart/form-data">
	@csrf
      <input type="hidden" name="ed_cvid_id" value="{{ $cv->id }}" >
	  <input type="hidden" name="ed_cvid_icon" value="{{ $cv->video_icon }}" >
	  
		<div class="form-group">
				<label >Course</label>
				<select id="course_id" class="form-control" name="ed_course_id" required>
				<option value="">--select--</option>
				@if(!empty($crs))
					@foreach($crs as $r)
						<option value="{{$r->id}}"@if($r->id==$cv->course_id){!! "selected" !!} @endif>{{ $r->course_name }}</option>
					@endforeach
				@endif
				</select>
			</div>
		<div class="form-group">	
		<label >Sub-Course Name </label>
			<select id="flt_subject_id" class="form-control" name="ed_subject_id" required>
			<option value="">--select--</option>
			@if(!empty($sub))
					@foreach($sub as $r)
						<option value="{{$r->id}}"@if($r->id==$cv->subject_id){!! "selected" !!} @endif>{{ $r->subject_name }}</option>
					@endforeach
				@endif
			</select>
		</div>
		
		<div class="form-group">	
		<label >Chapter Name </label>
			<select id="flt_subject_id" class="form-control" name="ed_chapter_id" required>
			<option value="">--select--</option>
			@if(!empty($cha))
					@foreach($cha as $r)
						<option value="{{$r->id}}"@if($r->id==$cv->chapter_id){!! "selected" !!} @endif>{{ $r->chapter_name }}</option>
					@endforeach
				@endif
			</select>
		</div>
								
		<div class="form-group">
			<label>Video Tile </label>
				<input type="text" id="ed_video_title" class="form-control" name="ed_video_title"  value="{{$cv->video_title}}"required>
		</div>
		
		<div class="form-group">
			<label>Video Id (Vimeo) </label>
				<input type="text" id="ed_video_id" class="form-control " name="ed_video_id"  value="{{$cv->video_id }}"required>
		</div>

		<div class="form-group">
			<label>Description </label>
				<textarea rows=3 class=" form-control " name="ed_description" required>{{$cv->description}}"</textarea>
			</div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-primary btn-xs"> Update </button>
		<button type="submit" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
	</div>

</form>
