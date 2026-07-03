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
		Question Bank
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
						Subjects
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
							<!-- contents --->
						</li>
						
					</ul>
					
					
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->
				

				<div class="row">
					<div class="col-xl-4 col-xxl-4 col-lg-4">
					
					<label><b><u> Add Subjects </u></b> </label>
						<form method="post" action="" enctype="multipart/form-data">
							@csrf
						  
						  <div class="modal-body" style="padding:.5rem !important;">
						
							<div class="form-group">
							
							<label>No of Subjects </label>
							<div class="row">
							<div class="col-lg-8 col-xl-8 col-xxl-8 text-right">
							<input type="number" id="noofsubject" class="form-control input-default " name="no_of_subject" required>
							</div>
							<div class="col-lg-1 col-xl-1 col-xxl-1">
								<button type="button" id="btnSet" class="btn btn-primary btn-xs" style="margin-top:3px;">Set </button>
							</div>
							</div>
							</div>
							<label><u>Subjects</u></label>
									
							<div class="form-group" id="subjects">
									
							</div>

						</div>
						<hr>
						<div class="row mb-3">
						<div class="col-lg-11 col-xl-11 col-xxl-11 text-right">
							<button type="submit" class="btn btn-primary"> Submit </button>
						</div>
						</div>
						</form>
					
					</div>
					
					<div class="col-xl-8 col-xxl-8 col-lg-8">
					
					<label><b><u> Subject List </u></b> </label>
					
						<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							<thead>
								<tr>
									<th>Id</th>
									<th >Name</th>
									<th width="80px">Action</th>
								</tr>
							</thead>
							<tbody>
							@if(!empty($sub))
							@foreach($sub as $r)
							<tr>
								<td>{{$r->id}}</td>
								<td>{{$r->subject_name}}</td>
								<td width="80px">
								<a href="" id="{{$r->id}}" class="edit btn btn-brand btn-elevate btn-circle btn-icon" data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a> 
								<a href="{{url('delete_qb_subject').'/'.$r->id}}" id="conf" class="btn btn-danger btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a> 
							</td>
							</tr>
							@endforeach
							@endif
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
					<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
 });


$("#btnSet").click(function()
{
	var no=$("#noofsubject").val();
	var input="";
	if(no<=0)
	{
		alert("No of subject value missing, Try again.")
	}
	else
	{
		for(var x=1;x<=no;x++)
		{
			input+='<label>Enter Subject Name('+x+')</label><input type="text" class="form-control" name="subject[]" required>';
		}
		$("#subjects").html(input);
	}
});


 var table = $('#datatable').DataTable({
      "processing": true,
	  "pageLength":100,
	  "bDestroy":true,
	  "stateSave": true,
	  
	  
   });


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_qb_subject"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   Result.html(res);
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





