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
		Students
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
						Student List
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<!--<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
					
						<li class="nav-item">
						<a href="{{url('add_student')}}" class="btn-accordion btn btn-primary btn-xs"  ><i class="flaticon2-plus"></i> Add Students</a>
						</li>
						
					</ul>-->
					
					
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
								<th>Image</th>
								<th>Name</th>
								<th>Gender</th>
								<th>State</th>
								<th>Created_At</th>
								<th>Status</th>
								<th>Package</th>
								<th width="70px">Action</th>
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
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Package</h5>
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
$("#submit").prop("disabled",true);

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


$("#check_mobile").click(function()
{
	var mob=$("#mobile").val();
	if(mob!="")
	{
		jQuery.ajax({
			type: "GET",
			url: "check_mobile"+"/"+mob,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   if(res==1)
			   {
				  $("#mob_err").html("Mobile already exist");
				  $("#submit").prop("disabled",true);
			   }
				else
				{
					$("#submit").prop("disabled",false);
					$("#mob_err").html("<span style='color:green'>Verified Ok</span>");
				}					
			}
		});
	}
});

 $("#student_image").change(function() {
      var file = document.getElementById("student_image").files[0];
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
		
        ajax: {
			url:"view_students",
			data: function (data) 
		    {
				data.search = $('input[type="search"]').val();
		    },
		},
		
		columnDefs:[
				  {"width":"300px","targets":2},
				  {"width":"150px","targets":5},
				  {"width":"70px","targets":7},

				],
	
        columns: [
            {"data": "id" },
			{"data": "simage" },
			{"data": "name" },
			{"data": "gender" },
			{"data": "state" },
			{"data": "cdate" },
			{"data": "status" },
			{"data": "pkg" },
			{"data": "action" ,name: 'Action',orderable: false, searchable: false },
        ],
		initComplete: function(settings, json) {
			$('input[type="search"]').val('');
		}
				
		
    });


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	    
		var stid=$(this).attr('id');
		var Result=$("#kt_modal_1 .modal-body");
		$(this).attr('data-target','#kt_modal_1');
	
		  jQuery.ajax({
			type: "GET",
			url: "edit_student"+"/"+stid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res)
			}
		});
		
  });
  
  
  $('#datatable tbody').on( 'click', '.addPkg', function ()
  {
	    
		var stid=$(this).attr('id');
		var Result=$("#kt_modal_2 .modal-body");
		$(this).attr('data-target','#kt_modal_2');
	
		jQuery.ajax({
			type: "GET",
			url: "add_package"+"/"+stid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res)
			}
		});
		
  });



$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});



</script

@endpush

@endsection





