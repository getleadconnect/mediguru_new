<form method="post" action="{{url('update_promocode')}}" enctype="multipart/form-data" autocomplete=off>
	@csrf
	<input type="hidden" name="ed_promo_id" value="{{$pcd->id}}">
		<div class="form-group">
		<label >Select Course </label>
			<select id="ed_course_id"  name="ed_course_id" class="form-control" required>
			<option value="">--select--</option>
			@foreach($crs as $r)
			<option value="{{$r->id}}" @if($r->id==$pcd->course_id){!! "selected" !!} @endif >{{ $r->course_name }}</option>
			@endforeach
			</select>
		</div>
		
		@if($pcd->user_id!="")		
		
		<div class="form-group">
		<label >Select User </label>
			<select id="ed_user_id"  name="ed_user_id" class="form-control"  style="width:100% !important;">
			<option value="">--select--</option>
			@foreach($urs as $r)
			<option value="{{$r->user_id}}" @if($r->user_id==$pcd->user_id){!! "selected" !!} @endif >{{ strtoupper($r->name) }}</option>
			@endforeach
			</select>
		</div>
		
		@endif

		<div class="form-group">
		<div class="row">
		<div class="col-lg-5 col-xl-5 col-xxl-5">
		<label >Promocode </label>
			<input type="text" id="ed_promocode" class="form-control" name="ed_promocode" value="{{$pcd->promocode }}" required>
		</div>
		<div class="col-lg-3 col-xl-3 col-xxl-3">
		<label >Amt. % </label>
			<input type="number" id="ed_percentage" class="form-control" name="ed_percentage" value="{{$pcd->percentage }}" required>
		</div>

		<div class="col-lg-4 col-xl-4 col-xxl-4">
		<label >Expiry Date </label>
			<input type="text" id="ed_kt_datepicker_2" class="form-control"  name="ed_expiry_date" value="{{ date_create($pcd->expiry_date)->format('d-m-Y') }}" required>
		</div>
		</div>
		</div>
		
		@if($pcd->discount_course!="")		
		
		<div class="form-group">
		<label >Select course for discount </label>
			<select id="ed_discount_course"  name="ed_discount_course" class="form-control"  style="width:100% !important;">
			<option value="">--select--</option>
			@foreach($crs as $r)
			<option value="{{$r->id}}" @if($r->id==$pcd->discount_course){!! "selected" !!} @endif >{{ $r->course_name }}</option>
			@endforeach
			</select>
		</div>
		
		@endif
		

		<div class="form-group">
		<label >Description </label>
			<textarea rows=3 id="description" class="textarea1 form-control" name="ed_description">{{$pcd->description }}</textarea>
		</div>

		<div class="modal-footer">
			<button type="submit" class="btn btn-primary"> Submit </button>
		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		</div>
		</form>

<script>

//$(".textarea1").summernote({dialogsInBody: true});

$('#ed_kt_datepicker_2').datepicker({
            format:'d-m-yyyy',
            todayHighlight: true,
            autoclose:true,
        });

$("#ed_user_id").select2();

</script>