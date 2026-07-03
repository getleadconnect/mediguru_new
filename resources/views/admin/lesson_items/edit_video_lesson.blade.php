<form method="post" action="{{ url('update_video_lession') }}" enctype="multipart/form-data">
	@csrf
      <input type="hidden" name="ed_vid_id" value="{{ $vl->id }}" >
	   <input type="hidden" name="ed_vid_icon" value="{{ $vl->icon}}" >
			
			<div class="form-group">
			<div class="row">
			<div class="col-lg-9">
			 <label>Video Icon</label>
				<input type="file" id="ed_video_icon" name="ed_video_icon" class="form-control">
			 </div>
			 
			 <div class="col-lg-3">
				<label>Icon</label>
					<img src="{{ config('constants.file_path').$vl->icon }}" id="ed_icon_output" style="width:80px;">
			 </div>
			 </div>
			 </div>
			 
			 <div class="form-group">
				<label>Unique-Id</label>
					<input type="text" id="ed_unique_id" name="ed_unique_id" class="form-control" value="{{ $vl->unique_id }}" required>
			 </div>
			 
			 <div class="form-group">
				<label >Vimeo Id</label>
				   <input type="text" id="ed_vimeo_id" name="ed_vimeo_id" class="form-control" value="{{ $vl->vimeo_id }}" required>
			</div>
					
			<div class="from-group">
				<label>Title</label>
				<input type="text" id="ed_title" name="ed_title" class="form-control" value="{{ $vl->title }}" required>	
			</div>
			
			 </div>

			<div class="modal-footer">
			<button type="submit" class="btn btn-primary btn-xs"> Update </button>
			<button type="submit" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
		</div>

	</form>

<script>

//$(".textarea1").summernote({dialogsInBody: true});

</script>
