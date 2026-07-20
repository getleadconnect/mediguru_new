@extends('admin.layouts.master')
@section('contents')

<style>
.btn-accordion
{
	margin-top: 10px;
	padding: 5px 10px 5px 10px !important;
    height: 35px;
}
.card {
    border:none !important;
}
.fa
{
	font-size:13px !important;
}

</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Set Lesson Live Question Papers
	</h3>
</div>
</div>

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

<div class="row">
<div class="col-lg-12 col-xl-12 col-xxl-12">

		<!--begin:: Widgets/Sale Reports-->
		<div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						<a href="{{ url('lesson_videos')}}" class="btn btn-primary btn-xs"><i class="flaticon2-plus"></i> Videos </a>
						<a href="{{ url('lesson_materials')}}" class="btn btn-primary btn-xs"><i class="flaticon2-plus"></i> Materials </a>
						<a href="{{ url('lesson_mcq_tests')}}" class="btn btn-primary btn-xs"><i class="flaticon2-plus"></i> Mock Test </a>
						<a href="{{ url('lesson_live_tests')}}" class="btn btn-success btn-xs"><i class="flaticon2-plus"></i> Live Test </a>

					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<a href="{{url('view_lesson_live_qpapers')}}" class="btn-accordion btn btn-primary btn-xs"><i class="flaticon2-file"></i> View Lesson Items </a>
						</li>
						
					</ul>
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->
				
				<!--begin::Accordion-->
				
				
				<div class="row">
				<div class="col-lg-12 col-xl-12 col-xxl-12">
					
					<label style="color:#2d2dcf;"> Step-1 : Select Course, Subject and Lesson</label>
					
					<div class="row">
					<!--<div class="col-lg-3">
					<label>Lesson Type</label>
						   <select id="lesson_type" class="form-control" name="lesson_type" required>
							<option value="">--select--</option>
							<option value="1">Video Lessons</option>
							<option value="2">Audio Lessons</option>
							<option value="3">Materials</option>
							<option value="4">Mock Test</option>
							<option value="5">Live Test</option>
						</select>
					</div> -->
										
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label"><b>Course</b> </label>
					<div class="col-lg-2 col-xl-2 col-xxl-2">
						   <select id="courseid" class="form-control" name="courseid" required>
							<option value="">--select--</option>
							@foreach($crs as $r)
							<option value="{{$r->id}}">{{$r->course_name}}</option>
							@endforeach
						</select>
						</div>
					
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label"><b>Subject</b> </label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
						<div class="input-group input-primary">
						   <select id="subjectid" class="form-control input-default " name="subjectid" required>
							<option value="">--select--</option>
							
						</select>
						   
						  <div class="input-group-append">
							<span class="input-group-text" style="padding:0px 5px;"><button type="button" class="btn btn-info" style="padding:2px 7px;" data-toggle="modal" data-target="#kt_modal_1" >+</button></span>
						  </div>
						</div>
						
					</div>
					
					
					<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label" ><b>Lessons</b> </label>
					<div class="col-lg-3 col-xl-3 col-xxl-3">
						<div class="input-group input-primary">
						   <select id="lessonid" class="form-control input-default " name="lessonid" required>
							<option value="">--select--</option>
						   </select>
						   
						  <div class="input-group-append">
							<span class="input-group-text" style="padding:0px 5px;"><button type="button" class="btn btn-info" style="padding:2px 7px;" data-toggle="modal" data-target="#kt_modal_2" >+</button></span>
						  </div>
						</div>
					</div>

					</div>
						
					</div>
				</div>

			<hr style="margin:7px 0px 3px 0px;">
				
				<!------ Row ---------->
				
				<div class="row">
				<div class="col-lg-6 col-xl-6 col-xxl-6" style="border-right:1px solid #a3a3a5;">
				
				<label class="mt-3" style="color:#2d2dcf;"> Step-2 : Click [<i class="flaticon2-plus"></i>] button to add live question paper into the lesson</label>

				<div class="row mt-3">
				<div class="col-lg-12 col-xl-12 col-xxl-12">
				<!--<div class="mt-3" style="overflow:auto;height:900px;width:100%">-->
					<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0;width:90%;">
						<thead>
							<tr>
								<th width="50px"></th>
								<th>Unique_Id</th>
								<th>Question Paper</th>
							</tr>
						</thead>
						<tbody>
			
						</tbody>
					</table>
				<!--</div>-->
				</div>
				</div>
			
			</div> <!-- column end ---->
			<div class="col-lg-6 col-xl-6 col-xxl-6">
			
				<label class="mt-3" style="color:#2d2dcf;"><b><u>Question Paper List : <span id="ltitle"> </span></u></b></label>
				
					<!--<div style="overflow-x:scroll;width:500px;max-height:400px;">-->

						<table id="datatable2" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0;">
						<thead>
							<tr>
							<th>&nbsp;</th>
							<th>Id</th>
							<th>icon</th>
							<th>Unique_id/Question Paper</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
					
					<!--</div>-->
							
				<!--<label><span>Total Questions:&nbsp;</span><span id="totquestion2" style="font-weight:600;font-size:16px;"> </span></label>-->
			
			</div>
			</div><!--row end --->
			
				<!--End:: Content-->
			</div>

		<!--end:: Widgets/Sale Reports-->
	  </div>
     </div>
   </div>
</div>
<!--begin::Modal-->
	<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Subject</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					
					<form method="POST" id="subForm"  enctype="multipart/form-data"> 
						@csrf
						      <div class="form-group">
								<label >Course Name </label>
								<select id="course_id" class="form-control " name="course_id" required>
									<option value="">--select--</option>
									@if(!empty($crs))
										@foreach($crs as $r)
											<option value="{{$r->id}}">{{ $r->course_name }}</option>
										@endforeach
									@endif
									</select>
								</div>
											
							   <div class="form-group">
								<label >Subject Name </label>
							    	<input type="text" id="subject_name" class="form-control " name="subject_name" required>
								</div>
								
							  <div class="row">
								<div class="col-xl-8 col-xxl-8 col-lg-8">
								<div class="form-group">
									<label>Subject Icon(.jpg|.png only) </label>
										<input type="file" onchange="fileValidation1();" id="subject_icon" class="form-control" name="subject_icon" required>
									</div>
								</div>
													
								<div class="col-xl-4 col-xxl-4 col-lg-4">
									<img src="" id="icon_output1" style="width:100px;">
								</div>
							  </div>
							  
							  <div class="form-group">
								<label >Description </label>
							    	<textarea rows=3  id="description" class="form-control " name="description" required></textarea>
								</div>
								
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary"> Submit </button>
							<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
						</div>
						</form>
					
				</div>
				
			</div>
		</div>
	</div>
	
	
	<!--end::Modal-->
	
		<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Lesson</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					
					<form method="POST" id="lesForm"  enctype="multipart/form-data"> 
						@csrf
						       <div class="form-group">
								<label >Course Name </label>
								<select id="les_course_id" class="form-control " name="les_course_id" required>
									<option value="">--select--</option>
									@if(!empty($crs))
										@foreach($crs as $r)
											<option value="{{$r->id}}">{{ $r->course_name }}</option>
										@endforeach
									@endif
									</select>
								</div>
								
								<div class="form-group">
								<label >Subject Name </label>
								<select id="subject_id" class="form-control " name="subject_id" required>
									<option value="">--select--</option>
									
									</select>
								</div>
								
							   <div class="form-group">
								<label >Lesson Name </label>
							    	<input type="text" id="lesson_name" class="form-control " name="lesson_name" required>
								</div>
								
							  <div class="row">
								<div class="col-xl-8 col-xxl-8 col-lg-8">
								<div class="form-group">
									<label>Lesson Icon(.jpg|.png) </label>
										<input type="file" onchange="fileValidation2();" id="lesson_icon" class="form-control" name="lesson_icon" required>
									</div>
								</div>
													
								<div class="col-xl-4 col-xxl-4 col-lg-4">
									<img src="" id="icon_output2" style="width:100px;">
								</div>
							  </div>
							  
						<div class="modal-footer">
							<button type="submit"  class="btn btn-primary"> Submit </button>
							<button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
						</div>
						</form>
					
				</div>
				
			</div>
		</div>
	</div>
	
	<!--begin::Modal-->
	<!--end::Modal-->
	
	

@push('scripts')
<!--<script src="{{ asset('js/pages/crud/datatables/advanced/column-rendering.js')}}" type="text/javascript"></script>-->
<script>
$(".textarea").summernote({dialogsInBody: true});

 $(document).ready(function()
 {
	
	var mes=$('#view_message').val().split('#');
	if(mes[0]=="success")
	{	
	    toastr.success(mes[1]);
	}
	else if(mes[0]=="danger")
	{
		toastr.error(mes[1]);
	}
	
		
		$("input[type='search']").wrap("<form>");  //for datatable search box fill remove
  $("input[type='search']").closest("form").attr("autocomplete","off");
  
 });


 $("#subject_icon").change(function() {
      var file = document.getElementById("subject_icon").files[0];
      if (file) {
          var reader = new FileReader();
        reader.onload = function() {
              $("#icon_output1").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
      }
 });
 
$("#lesson_icon").change(function() {
      var file = document.getElementById("lesson_icon").files[0];
      if (file) {
          var reader = new FileReader();
        reader.onload = function() {
              $("#icon_output2").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
      }
 });


 var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :10,
		scrollX: true,
		ordering:false,
		
		language: {
                    searchPlaceholder: 'Search',
                    sSearch: '',
                    lengthMenu: '_MENU_ page',
                },
                lengthMenu: [
                    [10, 25, 50, 100, 150, -1],
                    [10, 25, 50, 100, 150, "All"]
                ],
		
		ajax: {
          url: "view_lesson_live_tests",
          data: function (data) {
				data.search = $('input[type="search"]').val();
				data.searchByCourse = $('#courseid').val();
		       },
          },

		columnDefs:[
				  {"width":"100px","targets":1},
				],
	
        columns: [
			{"data": "selbtn" },
			{"data": "uid" },
			{"data": "title" },
        ],
		
		initComplete: function(settings, json) 
		{
			$('input[type="search"]').val('');
		}
    });


var table1 = $('#datatable2').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : false,
        pageLength :50,
		scrollX: true,
		ordering:false,
		
		ajax: {
          url: "get_lesson_live_tests",
            data: function (data) {
				
				data.search = $('input[type="search"]').val();
				data.searchByLesson = $('#lessonid').val();
		       },
          },

		columnDefs:[
				  {"width":"350px","targets":3},
				],
	
        columns: [
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
			{"data": "id" },
			{"data": "icon" },
			{"data": "dat" },
        ],
		
		initComplete: function(settings, json) 
		{
			$('input[type="search"]').val('');
		}
    });

$("#lessonid").change(function()
{
	table1.draw();
});

$("form#subForm").submit(function(e)
{
	e.preventDefault();    
    var formData = new FormData(this);
    $.ajax({
        url: "save_subject",
        type: 'POST',
        data: formData,
        success: function (res) 
		{
			alert(res);
			if(res>=1)
			{
				alert("Subject successfully added.");
				$("#subject_id").append("<option value='"+res+"'>"+$("#subject_name").val()+"</option>"); 
			}
			else
			{
				alert("Details missing, Try again.");	
			}
        },
        cache: false,
        contentType: false,
        processData: false
    });
});


$("form#lesForm").submit(function(e)
{
	e.preventDefault();    
    var formData = new FormData(this);
    $.ajax({
        url: "save_lesson",
        type: 'POST',
        data: formData,
        success: function (res) 
		{
			alert(res);
			if(res>=1)
			{
				alert("Lesson successfully added.");
				$("#subject_id").append("<option value='"+res+"'>"+$("#subject_name").val()+"</option>"); 
			}
			else
			{
				alert("Details missing, Try again.");	
			}
        },
        cache: false,
        contentType: false,
        processData: false
    });
});




$("#courseid").change(function()
{
	var cid=$(this).val();
	if(cid!="")
	{
	  jQuery.ajax({
		type: "GET",
		url: "get_subjects_by_course_id"+"/"+cid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#subjectid").empty();
		   $("#subjectid").append(res);
		}
	  });
	  
	table.draw();  
	  
	}

});


$("#subjectid").change(function()
{
	var sid=$(this).val();
	if(sid!="")
	{
	  jQuery.ajax({
		type: "GET",
		url: "get_lessons_by_subject_id"+"/"+sid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#lessonid").empty();
		   $("#lessonid").append(res);
		}
	  });
	}
});


$("#les_course_id").change(function()
{
	var cid=$(this).val();
	if(cid!="")
	{
	  jQuery.ajax({
		type: "GET",
		url: "get_subjects_by_course_id"+"/"+cid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#subejct_id").empty();
		   $("#subject_id").append(res);
		}
	  });
	}
});


/*jQuery('#master').on('click', function(e)
  {
	 if($(this).is(':checked',true))  
	 {
		 $(".sub_chk").prop('checked', true);  
		 $(".sub_chk").closest('tr').toggleClass('selected');
	 }  
	 else  
	 {  
		 $(".sub_chk").prop('checked',false);  
		 $(".sub_chk").closest('tr').removeClass('selected');
	 }  

  });
*/
  
 $('#datatable tbody').on( 'click', '.mselect', function ()
  {
	
		var sid=$("#subjectid").val();
		var lid=$("#lessonid").val();
		
		if(sid!="" && lid!="")
		{
			$(this).closest('tr').toggleClass('selected');
			
			uid=$(this).closest('tr').find('td').eq(1).text();
			
			var qid=$(this).val();
				jQuery.ajax({
					type: "POST",
					url: "set_lesson_live_test",
					dataType: 'html',
					data: {_token:"{{csrf_token()}}",subject_id:sid,lesson_id:lid,unique_id:uid},
					success: function(res)
					{
							alert('Data added');
							table1.draw();
					}
				 });
		}
		else
		{
			alert("Please Select Subject and Lesson.");
		}
		
  });
   
  $('#datatable2 tbody').on( 'click', '.btnDel', function (e)
  {
	e.preventDefault();
	
	if(confirm("delete this item?"))
	{
	
	var lid=$(this).attr('id');
			
  	  var qid=$(this).val();
		jQuery.ajax({
			type: "GET",
			url: "delete_lesson_live_test"+"/"+lid,
			dataType: 'html',
			//data: {},
			success: function(res)
			{
				alert('Test removed');
				table1.draw();
			}
		 });
	}
  });
  
function fileValidation1()
{
	 var fileInput = document.getElementById('subject_icon'); 
	 var allowedExtensions="";

		allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	          
		 var filePath = fileInput.value; 
					
            if (!allowedExtensions.exec(filePath)) { 
                alert('Invalid file type, Try again.'); 
                fileInput.value = ''; 
                return false; 
			}
			else
			{
				return true;
			}
}

function fileValidation2()
{
	 var fileInput = document.getElementById('lesson_icon'); 
	 var allowedExtensions="";

		allowedExtensions = /(\.jpg|\.jpeg|\.jpe|\.png)$/i; 
	          
		 var filePath = fileInput.value; 
					
            if (!allowedExtensions.exec(filePath)) { 
                alert('Invalid file type, Try again.'); 
                fileInput.value = ''; 
                return false; 
			}
			else
			{
				return true;
			}
}  
  
  
   

$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});

</script>

@endpush

@endsection





