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
.note-editable
{
	min-height:150px !important;
}


#kt_modal_2 .modal-body
{
	margin:5px 10px;
	min-height: 200px !important;
	max-height: 450px !important;
	overflow-y: scroll;
}

</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Subject Wise Live Classes
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
						Subject wise live classes
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs" aria-expanded="false" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4" style="padding:5px 20px !important;">
							  Add
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
					<div id="collapseOne4" class="collapse " aria-labelledby="headingOne" data-parent="#accordionExample4">
						<div class="card-body" style="background:#e2f0f7;">
							
							<form method="post" action="" enctype="multipart/form-data">
							@csrf
	
							<div class="form-group">
							<div class="row">
					
							<div class="col-lg-4 col-xl-4 col-xxl-4">
 							  <label>Course</label>
								  <select id="course_id" class="form-control" name="course_id" required>
								  <option value="">--select--</option>
								  @foreach($crs as $r)
								  <option value="{{$r->id}}">{{$r->course_name }}</option>
								  @endforeach
								  </select>
						  	</div>
							
							<div class="col-lg-4 col-xl-4 col-xxl-4">
 							  <label>Subject</label>
								  <select id="subject_id" class="form-control" name="subject_id" required>
								  <option value="">--select--</option>
								  </select>
						  	</div>
							
							<div class="col-lg-4 col-xl-4 col-xxl-4">
 							  <label>News/Live Class Title </label>
								  <input type="text" id="class_title" class="form-control" name="class_title" required>
						  	</div>
														
							</div>
							</div>
							
							<div class="form-group">
							<div class="row">
			
							<div class="col-lg-2 col-xl-2 col-xxl-2">
								<label>Class Date </label>
									<input type="date" id="class_date" class="form-control" name="class_date">
							</div>
							
							<div class="col-lg-2 col-xl-2 col-xxl-2">
 							  <label>Display Order</label>
								  <input type="number" id="display_order" class="form-control" name="display_order" required>
						  	</div>
							
							<div class="col-lg-4 col-xl-4 col-xxl-4">
								<label>Live class Link (Youtube)</label>
									<input type="text" id="event_link" class="form-control" name="class_link">
							</div>
							
							<div class="col-lg-4 col-xl-4 col-xxl-4">
								<label>Chat Link (youtube)</label>
									<input type="text" id="chat_link" class="form-control" name="chat_link">
							</div>
							
							</div>
							</div>
	
							<div class="row">
							<div class="col-lg-12 col-xl-12 col-xxl-12">
								
							<div class="form-group mb-0">
								<label id="ntitle">Description </label>
									<textarea class="textarea1 form-control" name="description"  required></textarea>
								</div>
							<div class="form-group mt-3 mb-2 text-right">
							   <button type="submit" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Submit&nbsp;&nbsp;&nbsp; </button>
							</div>
							
							</div>
							</div>
							
						</form>	
							
						</div>
					</div>
				  </div>
			   
			   </div>
			
				
				<div class="row mt-3">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							<thead>
								<tr>
									<th width="60px">No</th>
									<th >Course/Subject</th>
									<th >Title/Link/Description</th>
									<th >Date/Order</th>
									<th >Status</th>
									<th width="100px">Action</th>
				
								</tr>
							</thead>
							<tbody>
							
							</tbody>
						</table>
					</div>
				
				</div>

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
					<h5 class="modal-title" id="exampleModalLabel">Edit</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body" style="margin:5px 10px;">
				  
				</div>
				
			</div>
		</div>
	</div>

	<!--end::Modal-->

<!--begin::Modal-->
	<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">View</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body" >
					 
					
				</div>
				
				<div class="modal-footer" >
					<button type="button" class="btn btn-danger btn-xs" data-dismiss="modal" aria-label="Close">Close</button>
				</div>
				
			</div>
		</div>
	</div>

	<!--end::Modal-->


@push('scripts')
<!--<script src="{{ asset('js/pages/crud/datatables/advanced/column-rendering.js')}}" type="text/javascript"></script>-->
<script>

/*$(".content1").summernote({dialogsInBody: true});*/

$(".textarea1").summernote();

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
			url:"view_subject_live_class",
			data: function (data) 
		    {
				data.search = $('input[type="search"]').val();
		    },
		},
		
		columnDefs:[
				  {"width":"50px","targets":0},
				  {"width":"60px","targets":4},
				  {"width":"100px","targets":5},
	
				],
	
        columns: [
            {"data": "slno" },
			{"data": "cname" },
			{"data": "title" },
			{"data": "dat" },
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ]
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
});

 
 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var id=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
			$(this).attr('data-target','#kt_modal_1');
		
				jQuery.ajax({
				type: "GET",
				url: "edit_subject_live_class"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   Result.html(res);
				}
			});
  });
  
   
  $('#datatable tbody').on( 'click', '.act_deact', function (e)
   {
	   e.preventDefault();
		
	   var op=$(this).attr('rel');
		var id=$(this).attr('id');
	
		if(confirm("Are you sure, Activate/Deactivate this details?"))
		{
				jQuery.ajax({
				type: "GET",
				url: "act_deact_subject_live_class"+"/"+op+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   table.draw();
				}
			});
		}
  });
  
  $('#datatable tbody').on( 'click', '.btnDel', function (e)
   {
	   e.preventDefault();

		var id=$(this).attr('id');
	
		if(confirm("Are you sure, Delete this item?"))
		{
				jQuery.ajax({
				type: "GET",
				url: "delete_subject_live_class"+"/"+id,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   table.draw();
				   if(res==1)
				   {
					   alert("Live class successfully removed.");
				   }
				   else
				   {
					   alert("Something wrong, Try again.");
				   }
				}
			});
		}
  });

function fileValidation()
{
	 var fileInput = document.getElementById('news_icon'); 
	 var allowedExtensions="";
	 
		allowedExtensions = /(\.jpg|\.png)$/i;  
      
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





