
					
					<div class="row">
					<div class="col-lg-12 col-xl-12 col-xxl-12 " style="padding:10px 25px;">

						<form method="post" action="{{ url('update_group_package')}}" enctype="multipart/form-data">
									@csrf
									
									<input type="hidden" name="ed_pkgid" value="{{ $pkg->id }}">

									<div class="form-group row">
										<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Package Name</label>
										<div class="col-lg-10 col-xl-10 col-xxl-10">
										  <input type="text" name="ed_package_name" class="form-control" value="{{ $pkg->package_name }}" required>
									  </div>
									</div>  
									
									<div class="form-group">
									 <div class="row">
									  
										<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">Start Date </label>
										<div class="col-lg-4 col-xl-4 col-xxl-4">
										<input type="date" name="ed_start_date" class="form-control" value="{{ $pkg->start_date }}"  required>
										</div>

										<label class="col-lg-2 col-xl-2 col-xxl-2 col-form-label">End Date </label>
										<div class="col-lg-4 col-xl-4 col-xxl-4">
										<input type="date" name="ed_expiry_date" class="form-control" value="{{ $pkg->expiry_date }}" required>
										</div>

									   </div>
									</div>
									
									<div class="form-group">
									<div class="row">
										<div class="col-lg-12 col-xl-12">
											<label style="margin-top:10px;">Select Packages </label>
											
											<div style="width:100%;height:200px;overflow:auto;">
											 <table id="ed_tbl_packages" class="tbl_pkgs" border=1 style="width:100%">
												<tr><th >&nbsp;</th><th>Id</th><th>Package Name</th><th>Rate</th><th>&nbsp;</th></tr>
												@php
												$sta=0;
												if(!empty($spkg))
												{
													foreach($spkg as $r)
													{
														for($x=0;$x<count($ids);$x++)
														{
														   if($r->id==$ids[$x]){ $sta=1;break;}
														}
												@endphp
												
													<tr @if($sta==1) {!! "style='background: #c4c4c4;'" !!}{!! "selected" !!} @endif >
													<td align="center" width="30px"><input type="checkbox" class="chkbox" @if($sta==1) {!! "checked" !!}@endif disabled></td>
													<td>{{ $r->id }}</td><td>{{ $r->package_name }}</td><td width="100px">{{ $r->rate }}</td>
													<td width="100px">  
													  <button type="button" class="ed_pselect btn btn-primary btn-xs" style="padding:2px 10px 2px 10px;">Select</button>
													</td></tr>
												@php
												   $sta=0;
													}
												}
												@endphp
																							
											</table>
										</div>
										</div>
									</div>
									</div>
									
									<div class="form-group" >
									<div class="row" style="margin-top:10px;">
									<label class="col-lg-3 col-xl-3 col-form-label"> Selected Packages </label>
										<div class="col-lg-9 col-xl-9">
										<input type="text"  class="form-control" name="ed_sel_packages" id="ed_sel_packages" value="{{ $pkg->sel_package_id }}" readonly>
										</div>
									</div>
									</div>
									
									<div class="form-group">
									<div class="row">
									<label class="col-lg-3 col-xl-3 col-form-label"> Amount </label>
										<div class="col-lg-5 col-xl-5">
										<input type="text"  class="form-control" name="ed_package_rate" id="ed_package_rate" value="{{ $pkg->rate }}">
										</div>
									</div>
									</div>
	
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary"> Update </button>
								    <button type="button" class="btn btn-danger" data-dismiss="modal"><span>Close</span></button>
								</div>
								</form>
							</div>
					    </div>
<script>
		
$("#ed_tbl_packages").on('click','.ed_pselect',function()
   {
	var spkg="";
	var amount=0;
	if($(this).closest('tr').find(".chkbox").is(':checked',true))    //unselect item
	 {

		$(this).closest('tr').find(".chkbox").prop('checked',false);
		$(this).closest('tr').css('background','#fff'); 
		var id=$(this).closest('tr').find('td').eq(1).text();

		var amt=parseInt($(this).closest('tr').find('td').eq(3).text());
		
		if($("#ed_package_rate").val()==""){ amount=0;}else{	amount=parseInt($("#ed_package_rate").val())}

		amount-=amt;
		$("#ed_package_rate").val(amount);
		
		var id1=id+",";	
		var id2=","+id;	
		
		if($("#ed_sel_packages").val().includes(id1))
		{
		var sids=$("#ed_sel_packages").val().replace(id1,'');
		}
		else if($("#ed_sel_packages").val().includes(id2))
		{
			var sids=$("#ed_sel_packages").val().replace(id2,'');
		}
		else
		{
			var sids=$("#ed_sel_packages").val().replace(id,'');
		}
		
		$("#ed_sel_packages").val(sids);
		//$("#subids").val(sids);
	 }  
	 else 	//select item
	 { 
		//alert($("#ed_sel_packages").val());	 

		$(this).closest('tr').find(".chkbox").prop('checked',true);
		$(this).closest('tr').css('background','#c4c4c4'); 
		
		var id=$(this).closest('tr').find('td').eq(1).text();

		var amt=parseInt($(this).closest('tr').find('td').eq(3).text());
		if($("#ed_package_rate").val()==""){ amount=0;}else{ amount=parseInt($("#ed_package_rate").val())}
		
		amount+=amt;
		
		$("#ed_package_rate").val(amount);

		if($("#ed_sel_packages").val()=="")
		{
		   var sids=$("#ed_sel_packages").val()+id;
		}
		else
		{
			var sids=$("#ed_sel_packages").val()+","+id;
		}
		
		/*$.each($("#tbl_package tr.selected"),function()
		{ 
			spkg+=","+$(this).find('td').eq(0).text(); 
		});*/
		
		$("#ed_sel_packages").val(sids);
		//$("#subids").val(sids);
	 }  

});
		
</script>