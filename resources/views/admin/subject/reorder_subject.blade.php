@extends('admin.layouts.master')
@section('contents')


<link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
<link rel="stylesheet" href="{{asset('css/drag-style.css')}}">
<script src="{{ asset('plugins/general/jquery/dist/jquery.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/jquery-ui.js')}}"></script>
<style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.2em; min-height: 45px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }

 .card {    border:none !important; }
 .fa{font-size:13px !important; }
 #sortable li:hover { 	cursor:pointer; }

 ol li{ 	height:25px; 	font-weight:600;	color:#4646d1; }
</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Re-order Sub-courses(Subjects)
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
							<!--<button type="button" id="btnAdd" class="btn-accordion btn btn-primary btn-xs" data-toggle="modal" data-target="#kt_modal_1" >
							<i class="flaticon2-plus"></i> Add User
							</button>-->
						</li>
						
					</ul>
					
					
				</div>
				
			</div>
			<div class="kt-portlet__body">
			
			<div class="row">
			<div class="col-lg-8 col-xl-8 col-xxl-8">

				<!--begin::Accordion-->
				<div class="accordion  accordion-toggle-arrow" id="accordionExample4">
					<div class="card">
					<div id="collapseOne4" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample4">
						<div class="card-body" style="background:#e2f0f7;padding-top:15px;padding-bottom:3px;">
							<div class="form-group">
							<div class="row">
							<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Select Course</label>
							<div class="col-lg-5 col-xl-5 col-xxl-5">
								  <select id="flt_course_id" class="form-control" name="flt_course_id" required>
								  <option value="">--select--</option>
								  @foreach($crs as $r)
								    <option value="{{ $r->unique_id }}">{{ $r->course_name }}</option>
								  @endforeach
								  </select>
						  	</div>
							 
							</div>
							</div>

						</div>
					</div>
				  </div>
			</div> <!--- end Accordion --->
					
				<ol class="mt-3">
				  <li> Select course, To display available sub-courses(subjects) below</li>
				  <li> Click on the subject and Drag to arrange the order.</li>
				  <li> Finaly click 'Change Order' button.</li>
				</ol>
				<!--Begin:: Content-->

				<label><b><u>Re-order Subjects</u></b> </label>

				<div class="row">
					<div class="col-lg-12 col-xl-12 col-xxl-12 ">
						<label id="smes" style="color:red;font-weight:600;padding-left:30px;"></label>
						<ul id="sortable">
						  <li class="ui-state-default" data-id="0">No Subjects</li>
						  <!--<li class="ui-state-default" data-id="2"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 2</li>
						  <li class="ui-state-default" data-id="3"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 3</li>
						  <li class="ui-state-default" data-id="5"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item 5</li>-->
						</ul>
					</div>
					<div class="col-xl-12 col-xxl-12 col-lg-12">
						<button id="btnCOrder" class="mt-3 btn btn-primary btn-xs"> Change Order </button>
					</div>
				
				</div>
			</div>
			
			<div class="col-lg-4 col-xl-4 col-xxl-4">

				<!--- content here ------------------------>

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

  $( function() {
    $( "#sortable" ).sortable();
  } );

$("#btnCOrder").prop('disabled',true);

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
 
 function getSubjects()
 {
	var cid=$("#flt_course_id").val();
	jQuery.ajax({
		type: "GET",
		url: "get_subjects_for_reorder"+"/"+cid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
			if(res=='')
			{
				$("#btnCOrder").prop('disabled',true);
				$("#smes").html('No Subjects.');
			}
			else
			{
				$("#btnCOrder").prop('disabled',false);
				$("#smes").html('');
			}
		  $("#sortable").html(res);
		}
	});  
 }

 $("#flt_course_id").change(function()
 {
	getSubjects();
	
 });
 

 
var phrases ="";
$("#btnCOrder").click(function()
{
	phrases ="";
	$('#sortable').each(function(){
		$(this).find('li').each(function(){
			var current = $(this).attr('data-id');
			phrases+=","+current;
		});
	});
	
	var ids=phrases.substr(1);
	
	jQuery.ajax({
		type: "POST",
		url: "set_subjects_reorder",
		dataType: 'html',
		data:{_token:"{{csrf_token()}}",subids:ids},
		success: function(res)
		{
		   alert("Subject re-order successfully completed.");
		   getSubjects();
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





