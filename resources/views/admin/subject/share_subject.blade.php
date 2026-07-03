 <form id="shareSubject" method="post" enctype="multipart/form-data">
	@csrf
	<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12">

		<div class="form-group">
				<label>Subject</label>
				<input type="hidden" class="form-control" id="share_subject_id" name="share_subject_id" value="{{$sub->id}}"> 
				<input type="text" class="form-control" name="share_subject_name" value="{{$sub->subject_name}}" readonly> 
		</div>

		<div class="form-group">
				<label><b>Select Course to share Subject</b></label>
				<select id="share_course_id" class="form-control" name="share_course_id"   required>
				 <option value="">--select--</option>
				 @foreach($crs as $r)
				   <option value="{{$r->id}}">{{ $r->course_name }}</option>
				 @endforeach
				</select>
		</div>

		<hr style="margin:5px 0px;">
		
		<label id="err_msg" class="text-center;">&nbsp;</label>

		<div class="row">
		<div class="col-lg-12 col-xl-12 col-xxl-12 text-right">
			<button type="submit" class="btn btn-primary"> Submit </button>
			<button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
		</div>
		</div>
	</div>
	</div>
 </form>
  
 <script>
 
 $(document).ready(function()
 {
	$("#share_subject_id").val('');
	$("#err_msg").val('');
 });
 
 
 
$("form#shareSubject").submit(function(e)
{
	e.preventDefault();    
	
	if($("#share_subject_id").val()=="" && $("#share_course_id").val()=="")
	{
		$("#err_msg").html("<span style='color:red;font-size:12px;'>please select course.!</span>");
	}
	else
	{

	  var formData = new FormData(this);
		
       $.ajax({
          url: "{{url('share_subject')}}",
          type: 'POST',
          data: formData,
		  dataType: 'JSON',
          success: function (res) 
		  {
			if(res.status=='success')
			{
				$("#err_msg").html("<span style='color:green;font-size:14px;'>"+res.msg+".</span>");
				//window.location.reload();
			}
			else
			{
				$("#err_msg").html("<span style='color:red;font-size:14px;'>"+res.msg+".</span>");
			}
          },
		  cache: false,
		  contentType: false,
  		  processData: false
		});
	}
});

 
</script>