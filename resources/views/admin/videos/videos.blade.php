<!-- SUB COURSES------------------------------------->
@extends('admin.layouts.master')
@section('contents')

<style>
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
		Videos
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
						Videos
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs" aria-expanded="true" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
							 Add Videos
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
					<div id="collapseOne4" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample4">
 					 <div class="card-body" style="background:#e2f0f7;">
						<label><b><u> Add Video Link:</u></b></label>

  						  <!--<form method="post" id="myForm" action="" enctype="multipart/form-data">-->

							<form method="POST" id="myForm" enctype="multipart/form-data">
							@csrf
							
							<div class="form-group">
							<div class="row">
							<label class="col-lg-1 col-xl-2 col-xxl-2 col-form-label">Video Icon</label>
							<div class="col-lg-4 col-xl-4 col-xxl-4">
									<input type="file" id="video_icon" onchange="return fileValidation();" name="video_icon" class="form-control" required>
							</div>
						 
							<div class="col-lg-1 col-xl-1 col-xxl-1">
								<img src="" id="icon_output" style="width:80px;">
							 </div>
							</div>
							</div>
							
							<div class="form-group">
							<div class="row">
							<div class="col-lg-2 colxl-2 col-xxl-2">
							<label>Unique-Id</label>
								<input type="number" id="unique_id" name="unique_id" class="form-control" required>
							</div>
							 <div class="col-lg-2 col-xl-2 col-xxl-2">
							 <label>Free/Premium</label>
							   <select id="premium" name="premium" class="form-control" required>
								   <option value="">--select--</option>
								   <option value="0">FREE</option>
								   <option value="1">PREMIUM</option>
							   </select>
							   
							</div>

							<div class="col-lg-2 col-xl-2 col-xxl-2">
							<label>Vimeo Id</label>
							   <input type="text" id="vimeo_id" name="vimeo_id" class="form-control" required>
							</div>
							
							<div class="col-lg-5 col-xl-5 col-xxl-5">
							<label >Title</label>
								<input type="text" id="title" name="title" class="form-control" required>	
							</div>
							
							 <div class="col-xl-1 col-xxl-1 col-lg-1">
								<br>
								<button type="submit" id="btnSubmit" class="btn btn-primary btn-xs" style="margin-top:5px;">Submit</button>
							 </div>
							 </div>
							 </div>
						</form>
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
									<th>Free/Premium</th>
									<th>Video_Id</th>
									<th width="450px">Title</th>
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
	
<!--begin::Modal-->
	<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<!--<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Play Video</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div> -->
				<div class="modal-body" style="padding:0px;margin:0 auto;align-items:center;">
					
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-xs" data-dismiss="modal" aria-label="Close">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!--end::Modal-->
	
	

@push('scripts')

<script src="https://player.vimeo.com/api/player.js"></script>

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
		ordering:false,
		
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
			url:"view_videos",
			data: function (data) 
		    {
				data.search = $('input[type="search"]').val();
		    },
		},
		
		columnDefs:[
				  {"width":"80px","targets":5},
				  {"width":"450px","targets":4},
				],
	
        columns: [
            {"data": "id" },
			{"data": "vicon" },
			{"data": "pre" },
			{"data": "vid" },
			{"data": "title" },
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


$("form#myForm").submit(function(e)
{
	e.preventDefault();    
    var formData = new FormData(this);
    $.ajax({
        url: "save_video",
        type: 'POST',
        data: formData,
        success: function (res) 
		{
			if(res==1)
			{
				alert("Video successfully added.");
				
				$("#unique_id").val('');
				$("#vimeo_id").val('');
				$("#title").val('');
				$("#video_icon").val(''); 
				$("#icon_output").attr('src',''); 
				table.draw();
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

 $("#video_icon").change(function() {
        var file = document.getElementById("video_icon").files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $("#icon_output").attr("src", reader.result);
				$("#icon_output").css({"width":"50px"});
            }
            reader.readAsDataURL(file);
        }
   });


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_video"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
  });
    
  
  $('#datatable tbody').on( 'click', '.view_video', function ()
  {
	var lnk=$(this).attr('res');
	
		var Result=$("#kt_modal_2 .modal-body");
		$(this).attr('data-target','#kt_modal_2');
		var vurl='<iframe src="'+lnk+'?h=ff80487f6b&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="margin:0px;width:400px;height:350px;" title="Nature (1)"></iframe>';
		Result.html(vurl);
  });
  
  
  $('#datatable tbody').on( 'click', '.btnDel', function (e)
  {
	e.preventDefault();
	if(confirm("Are you sure, Delete this?"))
	{
	
	    var cid=$(this).attr('id');
	
			jQuery.ajax({
			type: "GET",
			url: "delete_video"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   table.draw();
			   alert("Video successfully removed.");
			}
		});
	}
  });


function fileValidation()
{
	 var fileInput = document.getElementById('video_icon'); 
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





