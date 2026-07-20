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
.note-editable
{
	min-height:100px !important;
}
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		E-book Titles
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
						E-book Titles
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
						  <a href="{{url('ebook_files')}}" class="btn-accordion btn btn-primary btn-xs">
						  <i class="fa fa-plus"></i> Add E-book Html Files</a>
						</li>
					</ul>
				</div>
			  </div>
			
			  <div class="kt-portlet__body">

				<div class="row mt-3">
					<div class="col-xl-4 col-xxl-4 col-lg-4">
					
					 <form method="post" id="EbookForm" enctype="multipart/form-data">
					   @csrf
						<div class="form-group">
							<label><b>E-Book Title</b></label>
							<textarea id="ebook_title" class="form-control" name="ebook_title" required></textarea>
						</div>
						<div class="form-group">
							<label><b>E-Book Icon</b></label>
							<input type="file" id="ebook_icon" class="form-control" name="ebook_icon" required>
							<img src="" id="icon_output" style="width:80px;">
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary"> Submit </button>
						</div>
					 </form>
					
					</div>
					<div class="col-xl-8 col-xxl-8 col-lg-8">
						<table id="datatable" class="table table-bordered dt-responsive" style="width:100%;">
						 <thead>
							<tr>
								<th>Sl.No</th>
								<th ><b>E-Book Title</th>
								<th >Icon</th>
								<th width="80px">Action</th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
						</table>
					</div>
				
				</div>
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
					<h5 class="modal-title" id="exampleModalLabel">Edit</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">	</button>
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

//$(".textarea").summernote({dialogsInBody: true});

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

        ajax: "view_ebooks",
		
		columnDefs:[
				  {"width":"60px","targets":0},
				],
	
        columns: [
            {"data": "id" },
			{"data": "btitle" },
			{"data": "eimg" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}

    });


$("form#EbookForm").submit(function(e)
{
    e.preventDefault();        
    $.ajax({
        url: "save_ebook",
        type: "POST",
        dataType: "html",
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (data)
        {
			if(data==1)
			{
				toastr.success("Data successfully added.");
				table.draw();
				$("#ebook_title").val('');
			}
			else
			{
				toastr.error("Details missing, Try again.");
			}
        },
    });        
});


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var fid=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_ebook"+"/"+fid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
			}
		});
  });
  
  
  
  $('#datatable tbody').on( 'click', '.btndel', function (e)
  {
	 e.preventDefault();
	 
	var eid=$(this).attr('id');
	
	if(confirm("Are you sure, delete this item?"))
	{
	    jQuery.ajax({
			type: "GET",
			url: "delete_ebook"+"/"+eid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   if(res==1)
			   {
				   toastr.success("Book title successfully removed.");
				   table.draw();
			   }
			   else
			   {
				   toastr.error("Something wrong, Try again.");
			   }
			}
		});
	}
		
  });
  
   $("#ebook_icon").change(function() {
      var file = document.getElementById("ebook_icon").files[0];
      if (file) {
          var reader = new FileReader();
        reader.onload = function() {
              $("#icon_output").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
      }
 });

   
$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});


</script

@endpush

@endsection





