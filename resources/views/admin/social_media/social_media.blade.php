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

.btn-update {
      margin-top: 40px !important; }

@media (max-width:915px) {
    .btn-update {
      margin-top: 5px !important; }
  }


</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Social Media Links
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
						Social Media Links
						</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
												
						<!--<li class="nav-item">
							<button type="button" class="btn-accordion btn btn-primary btn-xs" data-toggle="collapse" data-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne5">
							<i class="flaticon2-plus"></i> Filter
							</button>-->
						</li>
					</ul>
				</div>
				
			</div>
			<div class="kt-portlet__body">

				@foreach($sml as $key=>$r)


				<form method="POST" id="myForm{{++$key}}"  enctype="multipart/form-data">
				  @csrf
					 <div class="form-group">
					  <div class="row">
						<div class="col-xl-6 col-xxl-6 col-lg-6">
						<input type="hidden" name="smid" value="{{$r->id}}">
						<label>{{ $r->media_name }}</label>
						<textarea name="sm_link" id="sm_link" class="form-control">{{$r->link}}</textarea>	
						</div>
						<div class="col-xl-1 col-xxl-1 col-lg-1">
						   <button type="submit" class="btn btn-primary btn-xs btn-update" >Update</button>	
						</div>
					  </div>
					 </div>
				  </form>

				@endforeach

			</div>
		</div>
		<!--end:: Widgets/Sale Reports-->

</div>
    <!--begin::Modal-->
	<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" >
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
 });


$("form#myForm1").submit(function(e)
{
	e.preventDefault();    
    var formData = new FormData(this);
    $.ajax({
        url: "update_social_media",
        type: 'POST',
        data: formData,
        success: function (res) 
		{
			if(res==1)
			{
				alert("Social media links successfully updated.");
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


$("form#myForm2").submit(function(e)
{
	e.preventDefault();    
    var formData = new FormData(this);
    $.ajax({
        url: "update_social_media",
        type: 'POST',
        data: formData,
        success: function (res) 
		{
			if(res==1)
			{
				alert("Social media links successfully updated.");
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


$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete this details?");
});


</script>

@endpush

@endsection





