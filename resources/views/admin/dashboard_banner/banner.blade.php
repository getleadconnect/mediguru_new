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
		Dashboard Banners
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
						Banners
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
					<label><b><u>Add Banner</u></b></label>
					<form method="post" action="" enctype="multipart/form-data">
						@csrf
						
					<!--<img src="{{ config('constants.image_path')}}dashboard_banner/dash_banner_1.png">-->
					
						
						<div class="form-group">
						<label>Banner Image (.jpg|.png only)</label>
						<input type="file" onchange="fileValidation();" id="banner_image" class="form-control" name="banner_image" equired>
						<img src="" id="image_output" style="margin-top:3px;width:200px;">
						</div>
						<div class="form-group">
						<label>Banner Section </label>
						<select name="banner_section" class="form-control" required>
							<option value="1" >Dashboard Banner</option>
							<option value="2" >Subject Banner</option>
						</select>
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
					
					<label><b><u>Banner List</u></b></label>
					
					
						<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							 <thead>
                                            <tr>
                                                <th>Id</th>
												<th >Banner</th>
												<th >Section</th>
												<th >Status</th>
                                                <th width="80px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										@if(!empty($bnr))
										@foreach($bnr as $r)
										<tr>
											<td>{{$r->id}}</td>
											<td><img src="{{ config('constants.file_path').$r->banner_image}}" style="width:150px;"></td>
											<td>
											@if($r->banner_section==1) {!! "Dashboard Banner" !!}
											@else
												 {!! "Subject Banner" !!}
											@endif</td>
											<td width="80px">
											@if($r->status==1)
											<span class="kt-badge kt-badge--success  kt-badge--inline kt-badge--pill">Active</span>
											@else
											<span class="kt-badge kt-badge--danger  kt-badge--inline kt-badge--pill">Inactive</span>
											@endif

										  </td>
										  
										  <td width="100px">
											<a href="" id="{{$r->id}}" class="edit btn bt-brand btn-secondary btn-elevate btn-circle btn-icon" data-toggle="modal" title="Edit"><i class="fa fa-edit"></i></a> 
											<a href="{{url('delete_banner').'/'.$r->id}}" id="conf" class=" btn bt-danger btn-secondary btn-elevate btn-circle btn-icon" title="Delete"><i class="fa fa-trash"></i></a> 
											@if($r->status==1)
											<a href="{{url('deactivate_banner').'/'.$r->id}}" class="btn bt-warning btn-secondary btn-elevate btn-circle btn-icon" title="Deactivate"><i class="fa fa-times"></i></a> 	
											@else
											<a href="{{url('activate_banner').'/'.$r->id}}" class="btn bt-success btn-secondary btn-elevate btn-circle btn-icon" title="Activate"><i class="fa fa-check"></i></a> 	
											@endif
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

$(".textarea").summernote();


var table=$('#datatable').DataTable({
	"processing": true,
	'paging':true,
	'pageLength':25,
	'bDestroy':true,
	'saveState':true,
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
	
	$("#image_output").attr('src','');
	
 });


   $("#banner_image").change(function() {
        var file = document.getElementById("banner_image").files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $("#image_output").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
   });
  
 
function fileValidation()
{
	 var fileInput = document.getElementById('banner_image'); 
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

 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var bid=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
		$(this).attr('data-target','#kt_modal_1');
	
			jQuery.ajax({
			type: "GET",
			url: "edit_banner"+"/"+bid,
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





