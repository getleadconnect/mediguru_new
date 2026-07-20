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
.plan-period
{
	width:20px;
	height:20px;
	vertical-align:middle;
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
						Add Student
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
						<li class="nav-item">
						<a href="{{url('students')}}" class="btn-accordion btn btn-primary btn-xs">	<i class="flaticon2-left-arrow"></i> Back	</a>
						</li>
						
					</ul>
					
					
				</div>
				
			</div>
			<div class="kt-portlet__body">

				<!--Begin:: Content-->
	
				
				<div class="row">
					<div class="col-xl-12 col-xxl-12 col-lg-12">
				<form method="post" action="{{url('save_student')}}" enctype="multipart/form-data">
					@csrf
		
					<div class="row pb-3" style="border-bottom:1px solid #e4e4e4;">
						<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Enter Mobile </label>
						<div class="col-lg-3 col-xl-3 col-xxl-3">
							<input type="number" id="mobile" class="form-control input-default " name="mobile" value="{{ old('mobile')}}" required>
						</div>
						<div class="col-lg-1 col-xl-1 col-xxl-1" style="padding-left:0px;">
							<button type="button" id="check_mobile" class="btn btn-info"  title="Verify">Verify</button>
						</div>
						<div class="col-lg-2 col-xl-2 col-xxl-2" >
							<label style="color:red;font-size:13px; margin-top:10px;" id="mob_err"></label>
						</div>							
					</div>
					
		
					<fieldset id="field_set"  class="mt-3">
					
						<div class="row">
						<div class="col-lg-6">
						
							<div class="form-group">
								<div class="row">
								<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Select Course </label>
								<div class="col-lg-8 col-xl-8 col-xxl-8">
									<select id="course_id"  name="course_id" class="form-control" required>
									<option value="">--select--</option>
									@foreach($crs as $r)
									<option value="{{$r->unique_id}}" >{{ $r->course_name }}</option>
									@endforeach
									</select>
									
								</div>
							</div>
							</div>
							
												
							<div class="form-group">
								<div class="row">
								<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Enter Name </label>
								<div class="col-lg-8 col-xl-8 col-xxl-8">
									<input type="text" id="name" class="form-control" name="name" required>
								</div>
							</div>
							</div>
							
														
							<div class="form-group">
							<div class="row">
								<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Gender </label>
								<div class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">
									<input type="radio" id="name" class="st-radio plan-period" name="gender" value="Male">&nbsp;Male
								</div>
								<div class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">
									<input type="radio" id="name" class="st-radio plan-period" name="gender" value="Female">&nbsp;Female
								</div>
							</div>
							</div>
							
							<div class="form-group">
								<div class="row">
								<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Date Of Birth </label>
								<div class="col-lg-8 col-xl-8 col-xxl-8">
									<input type="date" id="birthdate" style="width:180px;" class="form-control" name="birthdate" value="{{ old('birthdate')}}" required>
								</div>
							</div>
							</div>
												
							<div class="form-group">
								<div class="row">
								<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Email </label>
								<div class="col-lg-8 col-xl-8 col-xxl-8">
									<input type="email" id="email" class="form-control" name="email" value="{{ old('email')}}" required>
								</div>
							</div>
							</div>

							<div class="form-group">
								<div class="row">
								<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">State </label>
								<div class="col-lg-8 col-xl-8 col-xxl-8">
									<input type="text" id="state" class="form-control" name="state" value="{{ old('state')}}"required>
								</div>
							</div>
							</div>
														
							<div class="form-group">
								<div class="row">
								<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Password </label>
								<div class="col-lg-8 col-xl-8 col-xxl-8">
									<input type="text" id="password" class="form-control" name="password" value="{{ old('password')}}" required>
								</div>
							</div>
							</div>
							
							
						</div>
						<div class="col-lg-6">
						
							<div class="row">
								<div class="col-xl-8 col-xxl-8 col-lg-8">
								 <div class="form-group">
									<label>Student Image </label>
										<input type="file" id="student_image" class="form-control" name="student_image" >
									</div>
								</div>
								<div class="col-xl-3 col-xxl-3 col-lg-3">
									<img src="" id="icon_output" style="width:100px;">
								</div>
							</div>
												
							<hr>
							
							<div class="form-group">
							<div class="row">
								<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Select Subscription Period </label>
								<div class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">
									<input type="radio"  class="plan-period" name="plan_period" value="3" >&nbsp;3 Months
								</div>
								<div class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">
									<input type="radio"  class="plan-period" name="plan_period" value="6" >&nbsp;6 Months
								</div>
								
								<div class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">
									<input type="radio" class="plan-period" name="plan_period" value="1" >&nbsp;1 Year
								</div>
								<input type="hidden" id="subscription_plan_type" name="subscription_plan_type"> 
							</div>
							</div>
							
							
							<div class="form-group">
									<div class="row">
									<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Select Pacakge </label>
									<div class="col-lg-8 col-xl-8 col-xxl-8">
										<select id="package_id" class="form-control" name="package_id" required>
										<option value="">--select--</option>
										</select>
									</div>
								</div>
								
								<input type="hidden" id="package_type" name="package_type"> 
							</div>
							
							
							<div class="form-group">
									<div class="row">
									<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Package Amount </label>
									<div class="col-lg-8 col-xl-8 col-xxl-8">
										<input type="text" id="package_rate" class="form-control" name="package_rate" stayle="background:#fff;" readonly>
									</div>
								</div>
							</div>
							
							<div class="form-group">
									<div class="row">
									<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Promocode </label>
									<div class="col-lg-5 col-xl-5 col-xxl-5">
										<select id="promocode" class="form-control input-default " name="promocode" >
										<option value="">--select--</option>
										</select>
									</div>
									<div class="col-lg-3 col-xl-3 col-xxl-3">
										<input type="text" id="promocode_amount" class="form-control" name="promocode_amount" >
									</div>
								</div>
							</div>
							
							<div class="form-group">
									<div class="row">
									<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Referral Code </label>
									<div class="col-lg-5 col-xl-5 col-xxl-5">
										<select id="referral_code" class="form-control" name="referral_code" >
										<option value="">--select--</option>
										@foreach($rfc as $r)
										<option value="{{$r->referral_code}}">{{$r->referral_code}}</option>
										@endforeach
										</select>
									</div>
									<div class="col-lg-3 col-xl-3 col-xxl-3">
										<input type="text" id="referral_amount" class="form-control" name="referral_amount" >
									</div>
								</div>
							</div>
							<div class="form-group">
									<div class="row">
									<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Net Amount </label>
									<div class="col-lg-3 col-xl-3 col-xxl-3">
										<input type="text" style="width:150px;" id="net_amount" class="form-control" name="net_amount" >
									</div>
									<div class="col-lg-5 col-xl-5 col-xxl-5 text-right">
										<button type="button" id="calc_net_amt" class="btn btn-info btn-sm" style="font-size:12px !important;"> Re-Calc </button>
									</div>
								</div>
							</div>
						
						</div>

						</div>
						
						<hr>
						<div class="row mb-5">
						<div class="col-lg-12 text-right">
						<button type="submit" id="btnSubmit" class="btn btn-primary  pl-5 pr-5">Submit</button>
						</div>
						</div>
						
					</fieldset>
						</form>
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
$("#btnSubmit").prop("disabled",true);
$("#package_id").prop('disabled',true);

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
 

$(".plan-period").change(function()
{
	$("#package_id").prop('disabled',false);
	$("#subscription_plan_type").val($(this).val());
	clear_data();
			
});

function clear_data()
{
	$("#package_rate").val('');
	$("#package_id").val('')
	$("#promocode").val('');
	$("#promocode").val('');
	$("#promocode_amount").val('');
	$("#referral_code").val('');
	$("#referral_amount").val('');
	$("#net_amount").val('');
}


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
					$("#field_set").prop("disabled",false);
				}					
			}
		});
	}
	else
	{
		alert("Enter Mobile number.");
		$("#mobile").focus();
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


$("#calc_net_amt").click(function()
{
	var amt=$("#package_rate").val();
	var pamt=($("#promocode_amount").val()!="")?$("#promocode_amount").val():0;
	var ramt=($("#referral_amount").val()!="")?$("#referral_amount").val():0 ;
	var namt=parseInt(amt)-(parseInt(pamt)+parseInt(ramt));
	$("#net_amount").val(namt);
	$("#btnSubmit").prop("disabled",false);
	
});


$("#promocode").change(function()
{
	if($("#package_id").val()!='')
	{
		if($(this).val()=='')
		{
			$("#promocode_amount").val('');
			$("#calc_net_amt").click();	
		}
		else
		{
			
		var pkid=$("#package_id").val();
		var pcode=$(this).val();
		jQuery.ajax({
				type: "GET",
				url: "get_promocode_amount"+"/"+pcode+"/"+pkid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   $("#promocode_amount").val(res);
				   	$("#calc_net_amt").click();	
				}
			});

		}
	}
	else
	{
		alert("Select package..!");
		$(this).val('');
	}
	

		
});


$("#referral_code").change(function()
{
	if($("#package_id").val()!='')
	{
		if($(this).val()=='')
		{
			$("#referral_amount").val('');
			$("#calc_net_amt").click();
		}
		else
		{
			var rcode=$(this).val();
			jQuery.ajax({
					type: "GET",
					url: "get_referral_code_amount"+"/"+rcode,
					dataType: 'html',
					//data: {vid: vid},
					success: function(res)
					{
					   $("#referral_amount").val(res);
					   $("#calc_net_amt").click();
					}
				});
		}
	}
	else
	{
		alert("Select package..!");
		$(this).val('');
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
		
        ajax: "view_students",
		
		columnDefs:[
				  {"width":"150px","targets":2},

				],
	
        columns: [
            {"data": "id" },
			{"data": "simage" },
			{"data": "name" },
			{"data": "gender" },
			{"data": "package" },
			{"data": "state" },
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
	$("#package_rate").val('');
	
	jQuery.ajax({
			type: "GET",
			url: "get_packages_by_course_unique_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#package_id").empty();
			   $("#package_id").append(res);
			}
			});
	
	jQuery.ajax({
			type: "GET",
			url: "get_promocodes_by_course_id"+"/"+cid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
				$("#promocode").empty();
				$("#promocode").append(res);
			}
	});		
			
});

$("#package_id").change(function()
{
	$("#package_rate").val('');
	$("#promocode").val('');
	$("#referral_code").val('');
	$("#referral_amount").val('');
	$("#promocode_amount").val('')
	$("#net_amount").val('');
	
	var pid=$(this).val();
	var period=$("#subscription_plan_type").val();

	jQuery.ajax({
			type: "GET",
			url: "get_package_amount"+"/"+pid+"/"+period,
			dataType: 'json',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#package_rate").val(res.amount);
			   $("#package_type").val(res.package_type);
			}
	   });

});


 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	    
		var stid=$(this).attr('id');
		var Result=$("#basicModal-2 .modal-body");
		$(this).attr('data-target','#basicModal-2');
	
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


$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});



</script

@endpush

@endsection





