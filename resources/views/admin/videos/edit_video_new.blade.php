<form method="post" action="{{ url('update_video') }}" enctype="multipart/form-data">
	@csrf
      <input type="hidden" name="ed_vid_id" value="{{ $vl->id }}" >
	   <input type="hidden" name="ed_vid_icon" value="{{ $vl->video_icon}}" >
	   <input type="hidden" name="ed_vid_file" value="{{ $vl->video_file}}" >
			
			<div class="form-group">
			<div class="row">
			<div class="col-lg-9">
			 <label>Video Icon</label>
				<input type="file" id="ed_video_icon" name="ed_video_icon" class="form-control" >
			 </div>
			 
			 <div class="col-lg-3">
				<label>Icon</label><br>
				<img src="{{ config('constants.file_path').$vl->video_icon }}" id="ed_icon_output" style="width:60px;">
			 </div>
			 </div>
			 </div>
			 
			<div class="form-group">
			 <div class="row">
			 <div class="col-lg-9">
			  <label>Video File</label>
				<input type="file" id="ed_video_file" name="ed_video_file" class="form-control">
			 </div>
		     </div>
			</div>
			 
			<div class="form-group">
			<div class="row">
			<div class="col-lg-9">
			 <label>Video File link (Just file name only)</label>
				<input type="text" id="ed_video_file_link" name="ed_video_file_link" class="form-control" value="{{ substr($vl->video_file,strpos($vl->video_file,"/",strpos($vl->video_file,"/")+1)+1) }}">
			 </div>
		
			 </div>
			 </div>
			 
			 <div class="form-group">
				<label>Unique-Id</label>
					<input type="text" id="ed_unique_id" name="ed_unique_id" class="form-control" value="{{ $vl->unique_id }}" required>
			 </div>

			
			 <div class="form-group">
				<label>Free/Premium</label>
					<select name="ed_premium" class="form-control" required>
					<option value="">--select--</option>
					<option value="0" @if($vl->premium==0) {!!"selected"!!} @endif >FREE</option>
					<option value="1" @if($vl->premium==1) {!!"selected"!!} @endif>PREMIUM</option>
					</select>
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

$("#ed_video_file").change(function()
{
	$("#ed_video_file_link").val('');
});


</script>
