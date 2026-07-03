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
		Video Class - Questions
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
						Prepare Video Questions
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<button type="button" id="btnAdd" class="btn-accordion-filter btn btn-primary btn-xs" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							<i class="la la-filter"></i> Filter
							</button>
						</li>
						
					</ul>
					
					
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->
				
				<!--begin::Accordion-->
				
				<div class="row">
				<div class="col-lg-8 col-xl-8 col-xxl-8" style="border-right:1px solid #aeaeb5;">
								
				<div class="accordion  accordion-toggle-arrow" id="accordionExample4">
					<div class="card">
					<div id="collapseOne4" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample4">
						<div class="card-body" style="background:#e2f0f7;">
							
							<div class="row">
								<label class="col-lg-2 col-xl-2 col-xxl-2" style="padding-top:9px;">Select Subject</label>
								<div class="col-lg-5 col-xl-5 col-xxl-5">
								   <select id="flt_subject_id" class="form-control " name="flt_subject_id" required>
									<option value="">--select--</option>
									@if(!empty($sub))
										@foreach($sub as $r)
											<option value="{{$r->id}}">{{ $r->subject_name }}</option>
										@endforeach
									@endif
									</select>
								</div>
							
								</div>
							
						</div>
					</div>
				  </div>
				</div>
				
				<div class="row mt-3">
				<div class="col-lg-12 col-xl-12 col-xxl-12">
				<!--<div class="mt-3" style="overflow:auto;height:900px;width:100%">-->
					<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:90%;">
						<thead>
							<tr>
								<th width="50px"></th>
								<th>Id</th>
								<th>Subject</th>
								<th width="450px">Image/Question</th>
								<!--<th>Answer</th>
								<th>True Answer</th>-->
							</tr>
						</thead>
						<tbody>
			
						</tbody>
					</table>
				<!--</div>-->
				</div>
				</div>
			
			</div> <!-- column end ---->
			<div class="col-lg-4 col-xl-4 col-xxl-4">
			
				<form method="post" onsubmit=" return checkValues();" action="{{url('save_video_questions')}}" enctype="multipart/form-data">
					@csrf
							<div class="form-group">
								<label >Select Course </label>
							    	<select class="form-control"  id="course_id" name="course_id" required>
										<option value="">--select--</option>
										@foreach($crs as $r)
										<option value="{{$r->id}}">{{$r->course_name}}</option>
										@endforeach
							        </select>
							</div>
							
							<div class="form-group">
								<label >Select Subject </label>
							    	<select class="form-control"  id="subject_id" name="subject_id" required>
									<option value="">--select--</option>
							        </select>
							</div>
																					
							<div class="form-group">
								<label >Select Video </label>
								
								<select class="form-control kt-select2 video_id" id="video_id" name="video_id" required>
										<option value="">--select--</option>
										
							    </select>
								<label class="mt-2">Questions: <span id="total_quest" style="color:blue;font-weight:600;">0 Nos</span></label>
								<span class="mt-2">&nbsp;&nbsp;<a href="{{url('video_questions')}}" id="" class="btnQView">View Questions</a></span>
							</div>
							
							<label style="font-size:12px;color:#4a4ae5;"><b> Add questions and Save. </b></label>
							
							<input type="hidden" name="quest_id" id="quest_id">
							
							<label style="float:right"><span>Total Questions:&nbsp;</span><span id="totquestion1" style="font-weight:600;font-size:16px;"> </span></label>

							<div style="overflow-x:scroll;width:330px;max-height:400px;">

								<table style="width:150%" id="tb_questions" border=1>
								<tr><th>&nbsp;</th><th width="60px">id</th><th>Question</th></tr>
								<tbody id="tquestion">
									
									<!-- uestiions here --->
									
								</tbody>
							</table>
							
							</div>
							
							<label><span>Total Questions:&nbsp;</span><span id="totquestion2" style="font-weight:600;font-size:16px;"> </span></label>
							
							<div class="form-group mt-2 mb-3 ">
							   <button type="submit" id="btnSave" class="btn btn-primary"> Save Questions </button>
							</div>
						</form>
			
			
			</div>
			</div><!--row end --->
			
				<!--End:: Content-->
			</div>

		<!--end:: Widgets/Sale Reports-->
	  </div>
     </div>
   </div>
</div>
	
		

@push('scripts')
<!--<script src="{{ asset('js/pages/crud/datatables/advanced/column-rendering.js')}}" type="text/javascript"></script>-->
<script>
$(".textarea").summernote();

 $("#qpaper_icon").change(function() {
      var file = document.getElementById("qpaper_icon").files[0];
      if (file) {
          var reader = new FileReader();
        reader.onload = function() {
              $("#icon_output2").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
      }
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

$("#course_id").change(function()
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
		   $("#subject_id").empty();
		   $("#subject_id").append(res);
		}
	  });
	}
	
});

$("#subject_id").change(function()
{
	var sid=$(this).val();
	
	if(sid!="")
	{
	  jQuery.ajax({
		type: "GET",
		url: "get_videos_by_subject_id"+"/"+sid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{

		   $("#video_id").empty();
		   $("#video_id").append(res);
		}
	  });
	}
	
});


$("#video_id").change(function()
{
	var vid=$(this).val();
	jQuery.ajax({
		type: "GET",
		url: "get_video_total_questions"+"/"+vid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
			$("#total_quest").html(res);
		}
	  });
});


 var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :10,
		scrollX: true,
		
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
          url: "view_prepare_questions",
          data: function (data) {
                data.searchBySubject = $('#flt_subject_id').val();
				/*data.search = $('input[type="search"]').val();*/
				data.search =''; 
		       },
          },

		columnDefs:[
				  {"width":"150px","targets":2},
				],
	
        columns: [
			{"data": "selbtn" },
            {"data": "id" },
			{"data": "subject" },
			{"data": "quest" },
			/*{"data": "answer" },
			{"data": "cans" },*/
        ],
		
		initComplete: function(settings, json) 
		{
			$('input[type="search"]').val('');
		}
		
    });


 $("#flt_subject_id").change(function()
 {
	 table.draw();
 });

jQuery('#master').on('click', function(e)
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

  
  $('#datatable tbody').on( 'click', '.qselect', function ()
  {
	  	$(this).closest('tr').toggleClass('selected');
		   tdat='<tr><td style="padding:3px;width:40px;"><button type="button" class="delquest btn btn-danger btn-sm" style="padding: 0px 6px 1px 6px;">x</button>';
		   tdat+="</td><td style='padding:2px'>"+$(this).closest('tr').find('td').eq(1).text(); 
		   tdat+="</td><td style='padding:2px'>"+$(this).closest('tr').find('td').eq(3).html()+"</td></tr>"; 
		$("#tquestion").append(tdat);
		
		var totq=$('#tb_questions tr').length-1;
		$("#totquestion1").html(totq);
		$("#totquestion2").html(totq);
		
		$(this).removeClass('btn-primary');
		$(this).addClass('btn-success');
		
		qids=$("#quest_id").val();
		qids=qids+$(this).closest('tr').find('td').eq(1).text()+",";
		$("#quest_id").val(qids);
  });
  
  
  $("#tquestion").on('click', '.delquest', function () {
	  
      var rid=$(this).closest('tr').find('td').eq(1).text();
	  var totq=$('#tb_questions tr').length-2;
		$("#totquestion1").html(totq);
		$("#totquestion2").html(totq);
		
		var tb=$("#datatable tbody");
		tb.find("tr").each(function(index, element)
		{
		var id = $(element).find('td').eq(1).text();
		if(id==rid)
		{
		   $(element).find('button.qselect').removeClass('btn-success');
		   $(element).find('button.qselect').addClass('btn-primary');
		   $(element).closest('tr').removeClass('selected');
		}
		});
	
	$(this).closest('tr').remove();
	
	quest_ids=$("#quest_id").val();
	rmid=rid+",";
	quest_ids=quest_ids.replace(rmid,"");
	$("#quest_id").val(quest_ids);
	
});
 

function checkValues()
{
	if($("#crs_id").val()=="" && $("#qpaper_name").val()=="" && $(".qpaper_id").val()=="")
	{
		alert("Course, Question paper missing, Try again");
		return false;
	}
	else
	{
		if($("#quest_id").val()=="")
		{
		  alert("question not selected, Try again");
		  return false;
		}
		else
		{
		  return true;
		}
	}
}


function fileValidation()
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

$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});

</script

@endpush

@endsection





