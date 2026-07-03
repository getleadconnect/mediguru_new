<!-- SUB COURSES------------------------------------->
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

#tbvideo tr,td,th
{
	border:1px solid #e4e4e4;
}
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Class Videos
		</h3>
</div>
</div>

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

		<!--begin:: Widgets/Sale Reports-->
		<div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						Video List
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							 Add Videos
							</button>
						</li>
						
						<li class="nav-item">
							<button type="button" class="btn-accordion btn btn-primary btn-xs" data-toggle="collapse" data-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne5">
							 Filter
							</button>
						</li>
						
					</ul>
					
					
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->
				
				<!--begin::Accordion-->
				<div class="accordion  accordion-toggle-arrow" id="accordionExample4">
				  <div class="card">
					<div id="collapseOne4" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample4">
 					 <div class="card-body" style="background:#e2f0f7;">
						<label><b><u> Add Video Link:</u></b></label>

  						  <!--<form method="post" id="myForm" action="" enctype="multipart/form-data">-->

							<form method="post" id="myForm" enctype="multipart/form-data">
							@csrf
							
							<div class="row mb-3">
							  <label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label" >Course</label>
							  <div class="col-lg-3 col-xl-3 col-xxl-3">
								<select id="course_id" class="form-control input-default " name="course_id" required>
								<option value="">--select--</option>
								@if(!empty($crs))
									@foreach($crs as $c)
										<option value="{{$c->id}}">{{ $c->course_name }}</option>
									@endforeach
								@endif
								</select>
							</div>
							
							<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label" style="padding:0px;margin-top:7px;">Sub-Course</label>
							<div class="col-lg-3 col-xl-3 col-xxl-3">
								<select id="subject_id" class="form-control" name="subject_id" required>
								<option value="">--select--</option>
								</select>
							</div>
							
							
							<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label" style="padding:0px;margin-top:7px;">Chapter Name </label>
							<div class="col-lg-3 col-xl-3 col-xxl-3">
								<select id="chapter_id" class="form-control" name="chapter_id" required>
								<option value="">--select--</option>
								</select>
							</div>
							
							</div>
								
							<input type="hidden" id="imgid_value" value="1">  <!-- for row increase --->
							
							<table id="tbvideo" style="width:100%;" border=1>
							<thead>
							<tr>
							<th width="350px">&nbsp;&nbsp;Video Icon(.jpg/png)</th>
							<th width="60px" align="center">&nbsp;</th>
							<th > &nbsp;&nbsp;Video Id</th>
							<th width="80px">&nbsp;</th>
							</tr>
							</thead>
							<tbody id="tbody">
							<tr>
							<td width="350px"><input type="file" id="icon1" onchange="return fileValidation(this);" class=" vid_icon form-control" name="icon[]" required></td>
							<td align="center"><img id="img_icon1" src="" ></td>
							<td><select id="video_id" class="form-control video_id" name="video_id[]" required>
								<option value="">--select--</option>
								</select></td>
							<td align="center">
							  <button type="button" class="btnAdd btn btn-primary btn-sm" style="padding: 5px 5px 5px 7px;"><i class="flaticon2-plus"></i></button>
							</td>
							</tr>
							<tbody>
						</table>
								
						<div class="row mt-3">
						<div class="col-lg-12 col-xl-12 col-xxl-12 text-right">
							<button type="submit" id="btnSubmit" class="btn btn-primary"> Submit </button>
						</div>
						</div>
						</form>
					</div>
				  </div>

					<!--- FILTER ------------------------------------------>
					
					<div id="collapseOne5" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample4">
						<div class="card-body" style="background:#e2f0f7;">
						  <label><b><u> Filter BY:</u></b></label>
							 <div class="row">
							 <div class="col-lg-3 colxl-3 col-xxl-3">
								<label>Course </label>
									<select id="flt_course_id" class="form-control input-default " name="flt_course_id" required>
									<option value="">--select--</option>
									@if(!empty($crs))
										@foreach($crs as $c)
											<option value="{{$c->id}}">{{ $c->course_name }}</option>
										@endforeach
									@endif
									</select>
							 </div>
							 
							 <div class="col-lg-3 colxl-3 col-xxl-3">
								<label >Sub-Course Name </label>

									<select id="flt_subject_id" class="form-control" name="flt_subject_id" required>
									<option value="">--select--</option>
									
									</select>
								</div>
									
							<div class="col-lg-4 colxl-4 col-xxl-4">
								<label>Chapter</label>
									<select id="flt_chapter_id" class="form-control" name="flt_chapter_id" required>
									<option value="">--select--</option>
									
									</select>
							</div>
							
							 <div class="col-xl-1 col-xxl-1 col-lg-1">
							<br>
								<button type="button" id="btnGET" class="btn btn-primary btn-xs" style="margin-top:5px;">Get</button>
							 </div>
							 </div>

						</div>
					</div>

				</div>
				
				<div class="row mt-3">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<table id="datatable" class="table table-bordered dt-responsive " >
							<thead>
								<tr>
									<th>Id</th>
									<th>Icon</th>
									<th>Course</th>
									<th width="170px">Sub_Course</th>
									<th >Chapter</th>
									<th >Title</th>
									<th >Video_Id</th>
									<th>Description</th>
									<th>Status</th>
									<th width="110px">Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								</tr>
							</thead>
							<tbody>
							
							</tbody>
						</table>
					</div>
				
				</div>

				<!--End:: Content-->
			</div>
		</div>
</div>
		<!--end:: Widgets/Sale Reports-->

</div>
<!--begin::Modal-->
	<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					
					
				</div>
				
			</div>
		</div>
	</div>

	<!--end::Modal-->

@push('scripts')
<!--<script src="{{ asset('js/pages/crud/datatables/advanced/column-rendering.js')}}" type="text/javascript"></script>-->
<script>

//$(".textarea").summernote();

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

 var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :10,
		scrollX: true,
		
		'pagingType':"simple_numbers",
        'lengthChange': true,
		
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
			url:"view_class_videos",
			data: function (data) 
		    {
				data.search = $('input[type="search"]').val();
				data.searchByCourse = $("#flt_course_id").val();
				data.searchBySubcourse = $("#flt_subject_id").val();
				data.searchByChapter = $("#flt_chapter_id").val();
		    },
		},
		
		columnDefs:[
				  {"width":"150px","targets":4},
				  {"width":"300px","targets":5},
				  {"width":"110px","targets":9},
				],
	
        columns: [
            {"data": "id" },
			{"data": "cicon" },
			{"data": "cname" },
			{"data": "sname" },
			{"data": "chname" },
			{"data": "vtit" },
			{"data": "vid" },
			{"data": "desc" },
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) 
		{
			$('input[type="search"]').val('');
		}
 });


$("#btnGET").click(function()
{
	table.draw();
});



$("#tbvideo").on('click','.btnAdd',function()
{

var no=parseInt($("#imgid_value").val())+1;	

var opt="";
var cid=$("#course_id").val();
if(cid=="")
{
	alert("Please select Course,Sub-Course and Chapter.");
}
else
{
	jQuery.ajax({
		type: "GET",
		url: "get_vimeo_videos_by_course_id"+"/"+cid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
			var row='<tr><td><input type="file" id="icon'+no+'" class="vid_icon form-control" name="icon[]" required></td>';
			   row+='<td width="70px" align="center"><img src="" id="img_icon'+no+'"> </td>';
			   row+='<td><select id="video_id" class="form-control video_id" name="video_id[]" required>';
			   row+='<option value="">--select--</option>'+res+'</select></td>';
			   row+='<td align=center><button type="button" class=" btnAdd btn btn-primary btn-elevate btn-circle btn-icon" style="width:2rem;height:2rem;"><i class="fa fa-plus"></i></button>';
			   row+='&nbsp;<button type="button" class="btnDel btn btn-danger btn-elevate btn-circle btn-icon" style="width:2rem;height:2rem;"><i class="fa fa-minus"></i></button></td>';
			   row+='</tr>';

			$("#tbody").append(row);
			$("#imgid_value").val(no);
		}
   }); 
} 

});


$("#btnSubmit").click(function()
{
    $.ajax({
        url: 'save_videos',
        type: 'post',
        dataType: 'json',
        data: $('form#myForm').serialize(),
        success: function(res)
		{
             alert(res);      // ... do something with the data...
        }
    });
});


$("#tbvideo").on('click','.btnDel',function()
{
   $(this).closest('tr').remove();
});


$("#tbvideo").on('change','.vid_icon',function(e)
{
	var no1=$("#imgid_value").val();

    var cna=e.target.id;

	var ext=e.target.files[0].name.substr(e.target.files[0].name.length-3,3);
	if(ext=='jpg' || ext=='jpeg' || ext=='jpe' || ext=='png')
	{
		var file = e.target.files[0];
		if (file) {
		  var reader = new FileReader();
			reader.onload = function() {
			  $("#img_"+e.target.id).attr("src", reader.result);
			  $("#img_"+e.target.id).css({"width":"50px","height":"50px;"});
		}
			reader.readAsDataURL(file);
		}
	}
	else
	{
	$("#"+e.target.id).val(null);
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
 });



 $('#btnAdd').click(function()
 {
	$("#icon_output").attr('src','');
 });


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
			   $("#subject_id").html(res);
			}
       });
	   
	var cid=$(this).val();
	    jQuery.ajax({
			type: "GET",
			url: "get_vimeo_videos_by_course_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#video_id").html(res);
			}
       }); 
   
});

$("#subject_id").change(function()
{
	var cid=$(this).val();
	jQuery.ajax({
			type: "GET",
			url: "get_chapters_by_subject_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#chapter_id").html(res);
			}
       });
});

 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_class_video"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
  });
  
  
  $('#datatable tbody').on( 'click', '.btnDel', function ()
  {
	if(confirm("Are you sure, Delete this?"))
	{
	
	    var cid=$(this).attr('id');
	
			jQuery.ajax({
			type: "GET",
			url: "delete_class_video"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   table.draw();
			}
		});
	}
  });


function fileValidation(file)
{
	 var fileInput = file.target.file[0]; 
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





