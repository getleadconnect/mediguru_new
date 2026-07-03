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
		E-book Html Files
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
						Html File list
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
					  <li class="nav-item">
						<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs" aria-expanded="true" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">
						 Add Html File
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
						<label><b><u> Add E-book Html Files:</u></b></label>

  						  <!--<form method="post" id="myForm" action="" enctype="multipart/form-data">-->

							<form method="POST"  id="myForm"  enctype="multipart/form-data">
							@csrf
							
							<div class="form-group">
								<div class="row">
								
								<label class="col-lg-1 col-xl-1 col-xxl-1 col-form-label text-right">E-book</label>
								<div class="col-lg-4 col-xl-4 col-xxl-4">
								<select name="ebook_id" id="ebook_id" class="form-control" required>	
								<option value="">--select--</option>
								@foreach($ebts as $key=>$r)
								   <option value="{{$r->id}}">{{$r->ebook_title}}</option>
								@endforeach
								</select>
								</div>
								
								<label class="col-lg-1 col-xl-1 col-xxl-1 text-right col-form-label">Title</label>	
								<div class="col-lg-5 col-xl-5 col-xxl-5">
								<input type="text" id="title" name="title" class="form-control" required>	
								</div>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
								<div class="col-lg-4 col-xl-4 col-xxl-4">
									<label >Html File(.html/xhtml files only)</label>
									<input type="file" id="html_file" onchange="return fileValidation();" name="html_file" class="form-control">
								</div>
					
								<div class="col-lg-5 col-xl-5 col-xxl-5">
									<label >Html file link (Just file name only)</label>
									<input type="text" id="html_file_link" name="html_file_link" class="form-control" >
								</div>
								
								<div class="col-lg-2 col-xl-2 col-xxl-2">
									<button type="submit" id="btnSubmit" class="btn btn-primary btn-xs" style="margin-top:25px;">Submit</button>
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
								 <th>slno</th>
								 <th>E-Book</th>
								 <th>Title</th>
								 <th>Html_File</th>
								 <th >Action</th>
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
				<div class="modal-body" style="padding:25px 0px;margin:0 auto;align-items:center;">
					
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-xs" data-dismiss="modal" aria-label="Close">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!--end::Modal-->
	
	

@push('scripts')

<!--<script src="https://player.vimeo.com/api/player.js"></script>-->
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
        pageLength :50,
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
			url:"view_html_files",
			data: function (data) 
		    {
			   data.search = $('input[type="search"]').val();
		    },
		},
		
		columnDefs:[
				  {"width":"40px","targets":0},
				  {"width":"80px","targets":4},
				],
	
        columns: [
			{"data": "slno" },
            //{"data": "id" },
			{"data": "ebk" },
			{"data": "title" },
			{"data": "hfile" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) 
		{
			$('input[type="search"]').val('');
		}
	
 });


$("form#myForm").submit(function(e)
{
	e.preventDefault();
    var formData = new FormData(this);
	
	if($("#html_file").val()=='' && $("#html_file").val()=='' && $("#html_file_link").val()=='')
	{
	    toastr.error("Select ebook and other details!");
	}
	else
	{
       $.ajax({
          url: "save_html_file",
          type: 'POST',
          data: formData,
          success: function (res) 
		  {
			if(res==1)
			{
				toastr.success("Html file successfully added.");
				
				$("#ebook_id").val('');
				$("#title").val('');
				$("#html_file").val(''); 
				$("#html_file_link").val(''); 
				table.draw();
			}
			else
			{
				toastr.success("Details missing, Try again.");	
			}
          },
			cache: false,
			contentType: false,
			processData: false
		});
	}
});


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var fid=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_html_file"+"/"+fid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
  });
    
 
  $('#datatable tbody').on( 'click', '.btnDel', function (e)
  {
	e.preventDefault();
	if(confirm("Are you sure, Delete this?"))
	{

	    var cid=$(this).attr('id');
	
			jQuery.ajax({
			type: "GET",
			url: "delete_html_file"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   table.draw();
			   toastr.success("Html file successfully removed.");
			}
		});
	}
  });


function fileValidation()
{
	 var fileInput = document.getElementById('html_file'); 
	 var allowedExtensions="";

		allowedExtensions = /(\.htm|\.html|\.xhtml)$/i; 
	          
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





