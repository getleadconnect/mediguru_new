<form method="post" action="{{ url('update_question') }}" enctype="multipart/form-data">
	@csrf
	
      <input type="hidden" name="quest_id" value="{{$qt->id}}" >
	  <input type="hidden" name="quest_image" value="{{$qt->question_image}}" >

			 <div class="form-group">
			 <div class="row">
			  <label class="col-lg-2 col-xl-2 xol-xxl-2">Course Name </label>
			  <div class="col-lg-6 col-xl-6 xol-xxl-6">	
				   <select id="course_id" class="form-control input-default " name="course_id" required>
					<option value="">--select--</option>
					@if(!empty($crs))
						@foreach($crs as $r)
							<option value="{{$r->id}}" @if($r->id==$qt->course_id) {!! "selected" !!} @endif>{{ $r->course_name }}</option>
						@endforeach
					@endif
				  </select>
			 </div>
			 </div>
			 </div>
			 
			 
			 <div class="form-group">
				<div class="row">
				<label class="col-lg-2 col-xl-2 xol-xxl-2">Subject Name </label>
				<div class="col-lg-6 col-xl-6 xol-xxl-6">		
					<select id="subject_id" class="form-control  " name="subject_id" required>
					<option value="">--select--</option>
					@if(!empty($sub))
						@foreach($sub as $r)
							<option value="{{$r->id}}" @if($r->id==$qt->subject_id) {!! "selected" !!} @endif>{{ $r->subject_name }}</option>
						@endforeach
					@endif
					</select>
				</div>
				</div>
			 </div>
			 
			 <div class="form-group">
				<div class="row">
				<label class="col-lg-2 col-xl-2 xol-xxl-2">Question Paper </label>
				<div class="col-lg-6 col-xl-6 xol-xxl-6">		
					<select id="qpaper_id" class="form-control  " name="qpaper_id" required>
					<option value="">--select--</option>
					@if(!empty($qps))
						@foreach($qps as $r)
							<option value="{{$r->id}}" @if($r->id==$qt->question_paper_id) {!! "selected" !!} @endif>{{ $r->question_paper_name }}</option>
						@endforeach
					@endif
					</select>
				</div>
				</div>
			 </div>
	
	  		   <div class="form-group">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-form-label">Question Type </label>
					<div class="col-lg-4 col-xl-4">	
						<select id="question_type" class="form-control input-default " name="question_type" required>
					  	  <option value="">--select--</option>
						  <option value="1" @if($qt->question_type==1){!! "selected" !!} @endif>Text</option>
						  <option value="2" @if($qt->question_type==2){!! "selected" !!} @endif>Image</option>
					</select>
				</div>
				</div>
			   </div>
				

				<div id="grp_question" class="form-group ">
					<div class="row">
					<label class="col-lg-2 col-xl-2 col-form-label">Question</label>
					<div class="col-lg-10 col-xl-10">	
					<textarea id="question" class="form-control input-default " name="question" required>{{$qt->question}}</textarea>
				</div>
				</div>
				</div>
			
							
				<div id="quest_image" class="form-group">
					<div class="row">
					<div class="col-lg-6 col-cl-6 col-xxl-6">
					<label>Question Image </label>
					<input type="file" id="question_image" class="form-control" name="question_image">
					</div>
					<div class="col-xl-4 col-xxl-4 col-lg-4">
					<img src="{{ config('constants.file_path').$qt->question_image}}" id="image_output" style="width:200px;">
				</div>
				</div>
				</div>
				
							
				<div class="form-group">
				<div class="row">
				<div class="col-lg-6">
				<label>Answer - A </label>
				<textarea  class="form-control input-default " name="answer1" required>{{$qt->answer_1}}</textarea>
				</div>
				<div class="col-lg-6">
				<label>Answer - B </label>
				<textarea class="form-control input-default " name="answer2" required>{{$qt->answer_2}}</textarea>
				</div>
				</div>
				</div>
							
				<div class="form-group">
				<div class="row">
				<div class="col-lg-6">
				<label>Answer - C </label>
				<textarea  class="form-control input-default " name="answer3" required>{{$qt->answer_3}}</textarea>
				</div>
				<div class="col-lg-6">
				<label>Answer - D </label>
				<textarea  class="form-control input-default " name="answer4" required>{{$qt->answer_4}}</textarea>
				</div>
				</div>
				</div>
				
				<div class="form-group">
						<div class="row">
							<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Correct Answer </label>
							<div class="col-lg-5 col-xl-5 col-xxl-5">
								<select id="correct_answer" class="form-control input-default " name="correct_answer" required>
										<option value="">--select--</option>
										<option value="1" @if($qt->correct_answer==1){!! "selected" !!} @endif>Answer - A</option>
										<option value="2" @if($qt->correct_answer==2){!! "selected" !!} @endif>Answer - B</option>
										<option value="3" @if($qt->correct_answer==3){!! "selected" !!} @endif>Answer - C</option>
										<option value="4" @if($qt->correct_answer==4){!! "selected" !!} @endif>Answer - D</option>
							        </select>
							</div>
						</div>
						</div>
				
				<div class="form-group">
				<div class="row">
				<div class="col-lg-12">
				<label>Explanation </label>
				<textarea  class="form-control input-default " name="explanation" required>{{$qt->explanation}}</textarea>
				</div>
				</div>
				</div>
	
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary"> Update </button>
		<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
	</div>
							
</form>

<script>
   $("#question_image").change(function() {
        var file = document.getElementById("question_image").files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $("#image_output").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
   });   
   
   $(document).ready(function()
   {
   if($("#question_type").val()==1)
   {
	   $("#grp_question").show();
		$("#question").prop('required',true);
		$("#quest_image").hide();
		$("#question_image").prop('required',false);
   }
   else
   {
	   $("#grp_question").hide();
		$("#question").prop('required',false);
		$("#quest_image").show();
		//$("#question_image").prop('required',true);
   }
   });
   
</script>
