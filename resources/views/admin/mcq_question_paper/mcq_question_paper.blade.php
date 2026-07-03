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
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Mock Test Question Papers
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
									<th width="350px">Question paper</th>
									<th>Course</th>
									<th width="90px">Time/Date</th>
									<!--<th>Instruction</th>-->
									<th>Status</th>
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
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Q-Paper</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					
					<form method="post" action="{{url('save_mcq_qpaper')}}" enctype="multipart/form-data">
							@csrf
							
							<input type="hidden" name="question_paper_type" value="1">

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
									<input type="number" class="form-control " name="unique_id" required>
							</div>

						    <div class="form-group">
								<label>Question Paper Name </label>
									<input type="text" class="form-control input-default " name="question_paper_name" required>
							</div>

							
						</div> <!-- column end --->

					<div class="col-lg-6 col-xl-6 col-xxl-6"> <!--- seond column-->

						<div class="form-group">
							<div class="row">
							<div class="col-lg-6 col-xl-6">
								<label class="col-lg-12 col-xl-12 col-xxl-12">Premium/Free </label>
								<div class="col-lg-12 col-xl-12 col-xxl-12" style="padding-right:0px;">
								<select name="premium" class="form-control" required>
								<option value="">--select--</option>
								<option value="0">Free</option>
								<option value="1">Premium</option>
								</select>
								</div>
							  </div>
							  
							<div class="col-lg-6 col-xl-6">
							  <label class="col-lg-12 col-xl-12 col-xxl-12">Test Time </label>
							    <div class="col-lg-11 col-xl-11 col-xxl-11" style="padding-right:0px;">
							    <div class="input-group input-primary">
								   <input type="number" name="test_time" class="form-control" required>
								  <div class="input-group-append">
									<span class="input-group-text">/Minutes</span>
								  </div>
								</div>
							  </div>
							 </div>
							</div>
							</div>

							<div class="form-group">
							 <div class="row">
								<label class="col-lg-12 col-xl-12 col-xxl-12">To schedule this test, set date. Other wise leave it.</label>
								<div class="col-lg-9 col-xl-9 col-xxl-9" style="padding-right:0px;">
								
								<div class="input-group  input-primary">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Schedule Date</span>
                                            </div>
                                           <input type="date" class="form-control input-default" name="schedule_date">
                                        </div>
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
							    <img src="" id="icon_output" style="width:100px;">
							</div>
							</div>
							</div>

						</div><!-- row end -->
						</div>
						
						<div class="row">
						<div class="col-lg-12 col-xl-12 col-xxl-12">

						<div class="form-group"> 
						
						<!-- summernote editor -------------->
						
								<label><strong>Instructions</strong> </label>
								<textarea  class="textarea form-control" rows=4 name="instruction" required></textarea>
						</div> 
						
						</div>
						</div>
						
						<div class="modal-footer">
						<button type="submit" class="btn btn-primary" style="padding-left:50px;padding-right:50px;"> Submit </button>
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
			url:"view_mcq_question_papers",
			data: function (data) 
		    {
                data.search = $('input[type="search"]').val();
		    },
          },
		
		columnDefs:[
				  {"width":"350px","targets":3},
				  {"width":"90px","targets":5},

				],
	
        columns: [
            {"data": "id" },
			{"data": "uid" },
			{"data": "qpicon" },
			{"data": "qpname" },
			{"data": "cname" },
			{"data": "ttime" },
			/*{"data": "desc" },
			{"data": "instruct" },*/
			{"data": "status" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ]
    });


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	    
		var qpid=$(this).attr('id');
		var Result=$("#kt_modal_2 .modal-body");
		$(this).attr('data-target','#kt_modal_2');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_mcq_qpaper"+"/"+qpid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res)
			}
		});
		
  });
  
  
  /*$("#course_id").change(function()
  {
		var cid=$(this).val();
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

  });*/

  
  /*$('#datatable tbody').on( 'click', '.btndel', function ()
  {
		if(confirm("Are you sure, delete this?"))
		{
			
			alert("ok");
			
			var qpid=$(this).attr('id');
				jQuery.ajax({
				type: "GET",
				url: "delete_qpaper"+"/"+qpid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   if(res==1)
				   {
					  table.draw();
				   }
				}
			});
		}
		
  });*/


$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details111?");
});



</script

@endpush

@endsection





