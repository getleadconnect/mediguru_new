<form method="post" action="{{ url('update_material')}}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="ed_mat_id" value="{{ $mat->id }}">
<input type="hidden" name="ed_mat_icon" value="{{ $mat->material_icon }}">

	<div class="form-group">
   <div class="row">
	   <div class="col-lg-3 col-xl-3 col-xxl-3">
	   <label>Unique Id</label>
	   <input type="number" id="ed_unique_id" class="form-control" name="ed_unique_id" value="{{$mat->unique_id}}">
	   </div>

	   <div class="col-lg-5 col-xl-5 col-xxl-5">
	   <label>Material Icon(jpg/png only)</label>
	   <input type="file" id="ed_material_icon" onchange="return fileValidation();" class="form-control" name="ed_material_icon" >
	   </div>
	   <div class="col-lg-1 col-xl-1 col-xxl-1">
	   <img src="{{ config('constants.file_path').$mat->material_icon }}" id="ed_icon_output" style="width:60px;">
	   </div>
   </div>
   </div>
   
   <div class="form-group">
   <div class="row mt-2">
	<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Material Title</label>
	<div class="col-lg-7 col-xl-7 col-xxl-7">
	<input type="text" name="ed_material_title" class="form-control" value="{{ $mat->material_title }}">
	</div>
	</div>
	</div>

 <div class="row mt-3">
	 <div class="col-lg-12 col-xl-12 col-xxl-12">
	   <textarea rows=10 class="textarea1 form-control" name="ed_material_data" >{!! $mat->material_data !!}</textarea>
	 </div>
	 </div>
	 
	<div class="row mt-3">
	<div class="col-lg-12 col-xl-12 col-xxl-12 text-right">
	<button type="submit" class="btn btn-primary btn-xs" style="padding:10px 25px 10px 25px;">Submit </button>
	<button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
	</div>
	</div>
</form>

<script>
$(".textarea1").summernote({dialogsInBody: true});

  $("#ed_material_icon").change(function() {
        var file = document.getElementById("ed_material_icon").files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $("#ed_icon_output").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
   });
   
</script>