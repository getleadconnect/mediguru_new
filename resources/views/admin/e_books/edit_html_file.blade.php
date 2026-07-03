<form method="post" action="{{ url('update_html_file') }}" enctype="multipart/form-data">
	@csrf
       <input type="hidden" name="ed_file_id" value="{{ $eb->id }}" >
	   <input type="hidden" name="ed_old_file" value="{{ $eb->html_file}}" >
			
			<div class="form-group">

			 <div class="row">
			 <div class="col-lg-11 col-cl-11 col-xxl-11">
			  <label>E-Book</label>
				<select name="ed_ebook_id" id="ed_ebook_id" class="form-control" required>	
				<option value="">--select--</option>
				@foreach($ebts as $key=>$r)
				   <option value="{{$r->id}}" @if($r->id==$eb->ebook_id){{__('selected')}}@endif>{{$r->ebook_title}}</option>
				@endforeach
				</select>
			 </div>
		     </div>
			</div>		 
			
			 <div class="row">
			 <div class="col-lg-11 col-cl-11 col-xxl-11">
			  <label>Title</label>
				<input type="text" id="ed_title" name="ed_title" class="form-control" value="{{$eb->title}}" required>
			 </div>
		     </div>
			</div>		 
			
			<div class="form-group mt-2">
			 <div class="row">
			 <div class="col-lg-11 col-cl-11 col-xxl-11">
			  <label>Html File(.html/xhtml only)</label>
				<input type="file" id="ed_html_file" name="ed_html_file" class="form-control" >
				@php
				$pos =strrpos($eb->html_file,'/')+1;
				$flName = substr($eb->html_file, $pos);
				@endphp
				<label style="color:blue;">Existing File: <span style="color:blue;font-weight:600;">{{$flName}}</span></label>
			 </div>
		     </div>
			</div>
			
			 
			<div class="form-group">
			<div class="row">
			<div class="col-lg-11 col-cl-11 col-xxl-11">
			 <label>Html File link (Just file name only)</label>
				<input type="text" id="ed_html_file_link" name="ed_html_file_link" class="form-control" >
			 </div>
				
			 </div>
			 </div>

			<div class="modal-footer">
			<button type="submit" class="btn btn-primary btn-xs"> Update </button>
			<button type="submit" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
		</div>

	</form>

<script>

//$(".textarea1").summernote({dialogsInBody: true});

$("#ed_html_file").change(function()
{
	$("#ed_html_file_link").val('');
});


</script>
