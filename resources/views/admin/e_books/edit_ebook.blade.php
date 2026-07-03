<form method="post" action="{{ url('update_ebook') }}" enctype="multipart/form-data">
	@csrf
       <input type="hidden" name="ed_ebook_id" value="{{ $eb->id }}" >
	   <input type="hidden" name="ed_ebk_icon" value="{{ $eb->ebook_icon}}" >
			
			<div class="form-group">

			
			 <div class="row">
			 <div class="col-lg-11 col-cl-11 col-xxl-11">
			  <label>E-book Title</label>
				<input type="text" id="ed_title" name="ed_ebook_title" class="form-control" value="{{$eb->ebook_title}}" required>
			 </div>
		     </div>
			</div>		

			<div class="row">
			 <div class="col-lg-9 col-cl-9 col-xxl-9">
			  <label>E-book Icon</label>
				<input type="file" id="ed_ebook_icon" name="ed_ebook_icon" class="form-control" required>
			 </div>
			 <div class="col-lg-3 col-cl-3 col-xxl-3 text-center">
			  <label>Icon</label>
				<img src="{{config('constants.image_path').$eb->ebook_icon}}" id="ed_icon_output" style="width:60px;">
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

   $("#ed_ebook_icon").change(function() {
      var file = document.getElementById("ed_ebook_icon").files[0];
      if (file) {
          var reader = new FileReader();
        reader.onload = function() {
              $("#ed_icon_output").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
      }
 });



</script>
