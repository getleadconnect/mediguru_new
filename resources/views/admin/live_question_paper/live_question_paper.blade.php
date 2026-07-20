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
	min-height:100px;
}
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Live Test Question Papers
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
						Question Papers
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs" data-toggle="modal" data-target="#kt_modal_1">
							 Add Q-Papers
							</button>
						</li>
						
					</ul>
					
					
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->
				
				<div class="row">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							<thead>
								<tr>
									<th>Id</th>
									<th>Unique_Id</th>
									<th>Icon</th>
									<th>Question paper</th>
									<th>Course</th>
									<th width="100px">Time</th>
									<th width="110px">Date</th>
									<th>Marks</th>
									<!--<th>Instruction</th>-->
									<th>Status</th>
									<th width="80px">Action</th>
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
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Q-Paper</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					
				<form method="post" action="{{url('save_live_qpaper')}}" enctype="multipart/form-data">
							@csrf

							<input type="hidden" name="question_paper_type" value="2">

							<div class="row">
							<div class="col-lg-6 col-xl-6 col-xxl-6">
							
							<div class="form-group">
								<label>Course </label>
								<select id="course_id" name="course_id" class="form-control" required>
								<option value="">--select--</option>
								@foreach($crs as $r)
								<option value="{{$r->id}}">{{$r->course_name}}</option>
								@endforeach
								</select>
							  </div>
							
							 <div class="form-group">
								<label>Unique ID </label>
									<input type="text" class="form-control" name="unique_id" required>
							</div>

						    <div class="form-group">
								<label>Question Paper Name </label>
									<input type="text" class="form-control input-default " name="question_paper_name" required>
							</div>

							<div class="form-group" style="width:150px;">
								<label >Premium/Free </label>
								<select name="premium" class="form-control" required>
								<option value="">--select--</option>
								<option value="0">Free</option>
								<option value="1">Premium</option>
								</select>
							</div>

							</div> <!-- column end --->

					<div class="col-lg-6 col-xl-6 col-xxl-6"> <!-- second column --->
					
							<div class="form-group" style="width:175px;">
							  <label >Test Time </label>
							    <div class="input-group input-primary">
								   <input type="number" name="test_time" class="form-control" required>
								  <div class="input-group-append">
									<span class="input-group-text">/Minutes</span>
								  </div>
							  </div>
							</div>
					

							<div class="form-group">
								<div class="row">
								<div class="col-lg-6 col-xl-6 col-xxl-6" style="padding-right:0px;">
								<label>Test Date </label>
								<input type="date" class="form-control input-default" name="test_date" required>
								</div>
								
								<div class="col-lg-5 col-xl-5 col-xxl-5" style="padding-right:0px;">
								<label>Starting Time </label>
								<input type="time" class="form-control input-default" name="start_time" required>
								</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="row">
								<div class="col-xl-8 col-xxl-8 col-lg-8">
									<label>Select Icon </label>
										<input type="file" id="qpaper_icon" class="form-control" name="question_paper_icon" required>
								</div>
								<div class="col-xl-4 col-xxl-4 col-lg-4">
									<img src="" id="icon_output" style="width:70px;">
								</div>
								</div>

							</div>

							<div class="form-group"> 
								<div class="row">
									<div class="col-lg-6 col-xl-6 col-xxl-6">
									<label>Question Mark </label>
									<input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="question_mark" required>
									</div>
								
									<div class="col-lg-6 col-xl-6 col-xxl-6">
									<label>Negative Mark </label>
										<input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  name="negative_mark" required>
									</div>
								</div>
							</div>

							</div>

						</div><!-- row end -->
						
						<hr>
						<div class="form-group"> 
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">
						<!-- summernote editor -------------->
								<label><strong>Instructions</strong> </label>
								<textarea  class="textarea" rows=4 class="form-control input-default " name="instruction" required></textarea>
						</div> 
						
						</div>
						</div>

						<div class="modal-footer">
						<button type="submit" class="btn btn-primary"> Submit </button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>
						
						</form>	
	
				</div>
				
			</div>
		</div>
	</div>

	<!--end::Modal-->
	
	<!--begin::Modal-->
	<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
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

$('.textarea').summernote();

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

 $('#btnAdd').click(function()
 {
	$("#icon_output").attr('src','');
 });


 $("#qpaper_icon").change(function() {
      var file = document.getElementById("qpaper_icon").files[0];
      if (file) {
          var reader = new FileReader();
        reader.onload = function() {
              $("#icon_output").attr("src", reader.result);
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
				
        ajax:
		{
			url:"view_live_question_papers",
			data: function (data) 
		    {
                data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  {"width":"350px","targets":3},
				  {"width":"110px","targets":5},
				  {"width":"100px","targets":9},
				],
	
        columns: [
            {"data": "id" },
			{"data": "uid" },
			{"data": "qpicon" },
			{"data": "qpname" },
			{"data": "cname" },
			{"data": "ttime" },
			{"data": "tdate" },
			{"data": "marks" },
			/*{"data": "desc" },
			{"data": "instruct" },*/
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		
		initComplete: function(settings, json) 
		{
			$('input[type="search"]').val('');
		}
    });


$("#course_id").change(function()
{
	var cid=$(this).val();

	jQuery.ajax({
			type: "GET",
			url: "get_lmt_subjects_by_course_id"+"/"+cid,
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


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	    
		var qpid=$(this).attr('id');
		var Result=$("#kt_modal_2 .modal-body");
		$(this).attr('data-target','#kt_modal_2');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_live_question_paper"+"/"+qpid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res)
			}
		});
		
  });

$('#datatable tbody').on( 'click', '.btndel', function ()
  {
	
	if(confirm("Are you sure, delete this?"))
	{	
		var qpid=$(this).attr('id');
			jQuery.ajax({
			type: "GET",
			url: "delete_live_qpaper"+"/"+qpid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   if($res==1)
			   {
			       table.draw();
			   }
			}
		});
	}
		
  });



$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});


</script

@endpush

@endsection





