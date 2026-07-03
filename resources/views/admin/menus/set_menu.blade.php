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
.m-field
{
	color:red;
}
.btn-set-menu {
    margin-top: 10px;
    padding: 5px 10px 5px 10px !important;
    height: 35px;
}

</style>

<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Set User Menus
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
						To Assign selected menu(s) to user
					</h3>
				</div>
				
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
					
						<li class="nav-item">
							<button type="button" id="btnSetMenu" class="btn-set-menu btn btn-primary btn-xs" data-toggle="modal">
							  <i class="la la-plus"></i> Set Menu To User
							</button>
						</li>
						
						<li class="nav-item">
							<a href="{{url('admin_users')}}" type="button" class="btn-set-menu btn btn-info btn-xs"><i class="la la-arrow-left"></i> Back </a>
						</li>
						

					</ul>

				</div>
				
			</div>
			
			
			<div class="kt-portlet__body" style="padding:15px;">
	
				<div class="row">
				<div class="col-lg-6 col-xl-6 col-xxl-6"  style="padding-left:15px;">
				
				  <div class="row">
					<div class="col-lg-12 col-xl-12 col-xxl-12 ">
					    <h5 style="line-height:30px;border-bottom:1px solid #e4e4e4;margin-bottom:10px;"> Menus (<span style="font-size:16px;color:green;font-weight:600;"><i class="la la-check"></i></span><span style="font-size:12px;">Selected Menus</span>)</h5>
					</div>
					
				  </div>
				  <div class="row ">
					   <div class="col-lg-12 col-xl-12">
					   <label class="kt-margin-b-10" style="color:#49499d;">● To select menu options, and click on the "<b>Set Menu To User</b>" button </label>
					   <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							  <thead>
								<tr>
								 <th></th>
								 <th>M_Id</th>
								 <th>Menu_Group</th>
								 <th>Menu_Option</th>
								</tr>
							  </thead>
						<tbody>

						</tbody>
					   </table>
					   </div>
					 </div>
				   </div>
				
				<div class="col-lg-6 col-xl-6 col-xxl-6">
				
				@php
					if(!empty($auser))
					{
						$uname=$auser->name;
					}
					else
					{
						$uname="";
					}
				@endphp
				
				<h5 style="line-height:30px;border-bottom:1px solid #e4e4e4;margin-bottom:20px;"> User : <span style="color:#0505fb;"> {{ $uname }} </span> </h5>
				
				   <table id="datatable1" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
						  <thead>
							<tr>
							 <th>SlNo</th>
							 <th>Menu_Id</th>
							 <th>Menu_Group</th>
							 <th>Menu_Option</th>
							 <th></th>
							</tr>
						  </thead>
					<tbody>
					@foreach($mnus as $key=>$m)
							<tr>
							 <td>{{ ++$key }}</td>
							 <td>{{ $m->menu_id }}</td>
							 <td>{{ $m->MenuGroup->menu_group_name }}</td>
							 <td>{{ $m->menu_option }}</td>
							 <td>
								<a href="{{ url('delete_menu/'.$m->id) }}" id="conf" title="Delete"><i class="fa fa-trash" style="color:#f34f3f;"></i></a> 
							 </td>
							</tr>
					@endforeach

					</tbody>
				   </table>
				
				</div>
			</div>
</div>
</div>

</div>



<!-- edit model -->
		<div class="modal fade" id="kt_modal_5" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog " role="document">
				<div class="modal-content">
				<form class="kt-form kt-form--label-right" method="POST" action="" enctype="multipart/form-data" >
					@csrf
			
					  <div class="modal-header">
						<div class="kt-portlet__head-label">
							<h3 class="kt-portlet__head-title"><small>Message</small></h3>
						</div>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						</button>
					</div>
					<div class="modal-body">
					

					</div>
					<div class="modal-footer kt-margin-r-30">
					    <button type="submit" class="btn btn-primary btn-lp">Yes</button>
						
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					</div>
				</form>
		
				</div>
			</div>
		</div>
		<!-- end::Model  -->

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

var table= $('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
			'pageLength':100,
			'ordering':false,
            "ajax":{
                     "url": "view_menu",
					 data: function (data) 
						{
							data.search = $('input[type="search"]').val();
						},
                   },
				   
			"columnDefs":[
			{"width":"70px","targets":0},
			],
				   
            "columns": [
				{"data": "check" },
                {"data": "id" },
				{ "data": "mgroup" },
                { "data": "moption" },
            ]	 

        });

	
	jQuery('#master').on('click', function(e) {
	 if($(this).is(':checked',true))  
	 {
		 $(".sub_chk").prop('checked', true);  
		 $(".sub_chk").closest('tr').toggleClass('selected');
	 }  
	 else  
	 {  
		 $(".sub_chk").prop('checked',false);  
		 $(".sub_chk").closest('tr').removeClass('selected');
	 }  
  });

  
  $('#datatable tbody').on( 'click', '.sub_chk', function ()
  {
		$(this).closest('tr').toggleClass('selected');
  });
  
  
  $("#btnSetMenu").click(function()
  {
		

		var mid="";
		$.each($("#datatable tr.selected"),function()
		{ 
			mid+=","+$(this).find('td').eq(1).text(); 
		});
			
		if($.trim(mid).length<=0)
			{
				$("#btnSetMenu").attr('data-target',"");
				swal.fire("Cancelled", "Please select menu options.");
			}
			else
			{
			
			var Result=$("#kt_modal_5 .modal-body");
			
			$(this).attr('data-target','#kt_modal_5');
						jQuery.ajax({
							type: "GET",
							url: "set_menu_confirm/"+mid,
							dataType: 'html',
							success: function(res)
							{
							    Result.html(res);	
							}
						});	
	
			}

  }); 


$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});



</script>

@endpush

@endsection





