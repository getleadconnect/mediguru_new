
<div class="row">
<div class="col-lg-12 col-xl-12 col-xxl-12">
<input type="hidden" id="package_id"  name="package_id" value="{{$id}}">
<label><b><u>Course Subjects</u></b></label>
<div style="width:100%;overflow-x:scroll;height:250px;">

@php
	$sids=explode(",",$subs);
@endphp

	<table style="width:100%;" border=1>
		@foreach($subjs as $r)
		<tr height="35px">
		<td>{{$r->id}}</td>
		<td>{{$r->subject_name }}</td>

		<td width="60px">
		@if(in_array($r->id, $sids))
			<button rel="{{$r->id}}" class="btnAdd btn btn-success btn-elevate btn-circle btn-icon" style="width:1.7rem;height:1.7rem;" title="add"><i class="fa fa-plus" style="font-size:10px !important;" ></i></button>
		@else
			<button rel="{{$r->id}}" class="btnAdd btn btn-brand btn-elevate btn-circle btn-icon" style="width:1.7rem;height:1.7rem;" title="add"><i class="fa fa-plus" style="font-size:10px !important;" ></i></button>			
		@endif
		
		<button rel="{{$r->id}}" class="btnDel btn btn-danger btn-elevate btn-circle btn-icon" style="width:1.7rem;height:1.7rem;" title="Remove"><i class="fa fa-minus" style="font-size:10px !important;"></i></button>
		</td>
		</tr>
		@endforeach
	</table>
</div>
</div>
</div>

<div class="row mt-2">
<div class="col-lg-12 col-xl-12 col-xxl-12">
<label><b><u>Added Subjects(IDs)</u></b></label>
<input type="text" id="sub_ids" name="sub_ids" class="form-control" value="{{$subs}}," readonly>

</div>
</div>

<div class="modal-footer">
<button type="button" id="btnSubmit" class="btn btn-primary btn-xs">Submit</button>
<button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
</div>

<script>

$(".btnAdd").click(function()
{
	var id1=$(this).attr('rel');
	var ids=$("#sub_ids").val();
	
	if(ids.indexOf(id1)!=-1)
	{
	  alert("Package subjects already added.");
	}
	else
	{
	  var txt=ids+id1+",";
	  $("#sub_ids").val(txt);
	    $(this).removeClass('btn-brand');
	  $(this).addClass('btn-success');
	  alert("Subject added");
	}
	
})

$(".btnDel").click(function()
{
	var id1=$(this).attr('rel')+",";
	var ids=$("#sub_ids").val();
	var txt=ids.replace(id1,'');
	
	$(this).siblings('.btnAdd').removeClass('btn-success');
	$(this).siblings('.btnAdd').addClass('btn-brand');
	  
	$("#sub_ids").val(txt);
	alert("Subject removed");
})


$("#btnSubmit").click(function()
{
	var pid=$("#package_id").val();
	var sids=$("#sub_ids").val();
	alert(pid);
	alert(sids);
	jQuery.ajax({
		type: "GET",
		url: "change_package_subjects"+"/"+pid+"/"+sids,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
			if(res==1)
			{
				alert("Package subjects changed.");
			}
			else
			{
				alert("Something wrong, Try again.");	
			}
		}
	});
	
	
});




</script>