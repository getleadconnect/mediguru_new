<style>
.plan-period
{
	width:20px;
	height:20px;
	vertical-align:middle;
}
</style>

<form method="post" action="{{url('update_package')}}" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="stud_id" value="{{$stid}}">
			
			
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
					<label class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">Subscription Period </label>
					<div class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">
						<input type="radio"  class="plan-period" name="plan_period" value="3" style="vertical-align:middle;">&nbsp;3 Months
					</div>
					<div class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">
						<input type="radio"  class="plan-period" name="plan_period" value="6" style="vertical-align:middle;">&nbsp;6 Months
					</div>
					
					<div class="col-lg-3 col-xl-3 col-xxl-3 col-form-label">
						<input type="radio" class="plan-period" name="plan_period" value="1" style="vertical-align:middle;">&nbsp;1 Year
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
						<label style="font-size:10px;color:green;"> <b>S</b> - Sub Package, <b>F</b> - Full package <label>
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
						<button type="button" id="calc_net_amt" class="btn btn-info btn-sm" style="font-size:12px !important;"> Get Net Amount</button>
					</div>
				</div>
			</div>
			
		<div class="modal-footer">
			<button type="submit" id="btn_Submit"  class="btn btn-primary"> Submit </button>
			<button type="button"  class="btn btn-danger light" data-dismiss="modal">Close</button>
		</div>
		
		</div><!-- row end -->
						
</form>
<script>

$("#btn_Submit").prop("disabled",true);
$("#package_id").prop('disabled',true);


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

$("#course_id").change(function()
{
	$("#package_rate").val('');
	
	var cid=$(this).val();

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
 
 $("#calc_net_amt").click(function()
{
	var amt=$("#package_rate").val();
	var pamt=($("#promocode_amount").val()!="")?$("#promocode_amount").val():0;
	var ramt=($("#referral_amount").val()!="")?$("#referral_amount").val():0 ;
	var namt=parseInt(amt)-(parseInt(pamt)+parseInt(ramt));
	$("#net_amount").val(namt);
	$("#btn_Submit").prop("disabled",false);
	
});


$("#promocode").change(function()
{
	var pcode=$(this).val();
	var pkid=$("#package_id").val();
	
	if(pcode!="")
	{
	jQuery.ajax({
			type: "GET",
			url: "get_promocode_amount"+"/"+pcode+"/"+pkid,
			dataType: 'html',
			//data: {vid: vid},
			success: function(res)
			{
			   $("#promocode_amount").val(res);
			}
		});
	}
	else
	{
		$("#promocode_amount").val('');
		$("#net_amount").val('');
	}		
	
});


$("#referral_code").change(function()
{
	var rcode=$(this).val();
	if(rcode!="")
	{
		jQuery.ajax({
				type: "GET",
				url: "get_referral_code_amount"+"/"+rcode,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   $("#referral_amount").val(res);
				}
			});
	}
	else
	{
		$("#referral_amount").val('');
		$("#net_amount").val('');
	}		
});


</script>

