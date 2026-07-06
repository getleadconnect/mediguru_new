<form method="post" action="{{ url('update_mcq_qpaper') }}" enctype="multipart/form-data">
	@csrf
      <input type="hidden" name="qpaper_id" value="{{$qp->id}}" >
	  <input type="hidden" name="qpaper_icon" value="{{$qp->question_paper_icon}}" >

		<div class="row">
		<div class="col-lg-6 col-xl-6 col-xxl-6">
		
		<div class="form-group">
			<label >Course</label>
			<select name="course_id" class="form-control" required>
			<option value="">--select--</option>
			@foreach($crs as $r)
			<option value="{{$r->id }}" @if($r->id==$qp->course_id){!! "selected" !!} @endif >{{$r->course_name}}</option>
			@endforeach
			</select>
		</div>

		 <div class="form-group">
			<label>Unique Id </label>
				<input type="number" class="form-control " name="unique_id" value="{{$qp->unique_id}}" required>
		</div>
	
		<div class="form-group">
			<label>Question Paper Name </label>
				<input type="text" class="form-control " name="question_paper_name" value="{{$qp->question_paper_name}}" required>
		</div>

		<div class="form-group" style="width:150px;">
			<label >Premium/Free </label>
				<select name="premium" class="form-control" required>
				<option value="">--select--</option>
				<option value="0" @if($qp->premium==0){!! "selected" !!} @endif >Free</option>
				<option value="1" @if($qp->premium==1){!! "selected" !!} @endif >Premium</option>
				</select>
		</div>



		</div> <!-- column end --->

		<div class="col-lg-6 col-xl-6 col-xxl-6">
			<div class="form-group" style="width:175px;">	
		 	    <label ">Test Time </label>
				<div class="input-group input-primary">
				   <input type="number" name="test_time" class="form-control" value="{{$qp->test_time}}" required>
				  <div class="input-group-append">
					<span class="input-group-text">/Minutes</span>
				  </div>
				</div>
			</div>
			
			<div class="form-group">
			<div class="row">
				<label class="col-lg-12">To schedule this test, set date. Other wise leave it.</label>
				<div class="col-lg-9 col-xl-9 col-xxl-9" style="padding-right:0px;">
				
				<div class="input-group  input-primary">
					<div class="input-group-prepend">
						<span class="input-group-text">Schedule Date</span>
					</div>
				   <input type="date" class="form-control input-default" name="schedule_date" value="{{$qp->schedule_date}}">
				</div>
				</div>
				</div>
			</div>

		<div class="row">
			<div class="col-xl-8 col-xxl-8 col-lg-8">
			<div class="form-group">
				<label>Select Icon </label>
					<input type="file" id="qpaper_icon" class="form-control" name="question_paper_icon" >
				</div>
			</div>
			<div class="col-xl-4 col-xxl-4 col-lg-4">
				<img src="{{ config('constants.file_path').$qp->question_paper_icon}}" id="icon_output" style="width:70px;">
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			<label>Question Mark </label>
			<input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="question_mark" value="{{$qp->question_mark}}" required>
			</div>
		
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			<label>Negative Mark </label>
				<input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  name="negative_mark" value="{{$qp->negative_mark}}"required>
			</div>
		</div>

	</div>
	</div><!-- row end -->
	
	<hr>
	
	<div class="row">
	<div class="col-lg-12 col-xl-12 col-xxl-12">

	<div class="form-group">
			<label><strong>Instructions</strong> </label>
			<textarea class="ed_textarea"  class="form-control input-default " name="instruction" required>{{$qp->instruction}}</textarea>
	</div>
	
	
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary"> Update </button>
		<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
	</div>
							
	</form>
	
<script>

$(".ed_textarea").summernote({dialogsInBody: true});

$("#course_id").change(function()
{
	var cid=$(this).val();

	jQuery.ajax({
			type: "GET",
			url: "get_subjects_by_course_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#subject_id").empty();
			   $("#subject_id").append(res);
			}
			});
	jQuery.ajax({
			type: "GET",
			url: "get_packages_by_course_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#package_id").empty();
			   $("#package_id").append(res);
			}
			});
			
});

$("#ed_subject_icon").change(function() {
        var file = document.getElementById("ed_subject_icon").files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $("#ed_icon_output").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
   });   
   
</script>
