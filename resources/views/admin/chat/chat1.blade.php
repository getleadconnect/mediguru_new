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
.note-editable
{
	min-height:110px !important;
}
</style>


<style type="text/css">
    .chat-icon-sm{
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #78d473;
        font-size: 12px;
        font-weight: 400;
        color: #fff;
        text-align: center;
        line-height: 35px;
    }
    	
a:hover {
    color:#1e8d0a !important;
    text-decoration: underline;
}

/*a:visited {
    color:red !important;
    text-decoration: underline;
}*/

</style>


<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Chat
	</h3>
</div>
</div>


<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

						<!-- begin:: Content -->
						<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

							<!--Begin::App-->
							<div class="kt-grid kt-grid--desktop kt-grid--ver kt-grid--ver-desktop kt-app">

								<!--Begin:: App Aside Mobile Toggle-->
								<button class="kt-app__aside-close" id="kt_chat_aside_close">
									<i class="la la-close"></i>
								</button>

								<!--End:: App Aside Mobile Toggle-->

								<!--Begin:: App Aside-->
								<div class="kt-grid__item kt-app__toggle kt-app__aside kt-app__aside--lg kt-app__aside--fit" id="kt_chat_aside">

									<!--begin::Portlet-->
									<div class="kt-portlet kt-portlet--last">
										<div class="kt-portlet__body" style="padding:10px 25px;">
										
										<div class="row">
										<div class="col-lg-11 col-xl-11 col-xxl-11">
											<div class="kt-searchbar">
												<div class="input-group">
													<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24" />
																	<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																	<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
																</g>
															</svg></span></div>
													<input type="text" class="form-control" id="txt_search" placeholder="Search" aria-describedby="basic-addon1">
												</div>
											</div>
										</div>
										
										<div class="col-lg-11 col-xl-11 col-xxl-11">
										  <button type="button" class="form-control" id="txt_search" placeholder="Search" aria-describedby="basic-addon1">
										</div>
										
										</div>
											
											<div class="kt-widget kt-widget--users kt-mt-20">
												<div class="kt-scroll kt-scroll--pull">
													<div class="kt-widget__items">
													
													@foreach($studs as $key=>$r)
		
															@php
																$na=substr($r->name, 0, 1);
																if(strpos($r->name," ")!="")
																{
																   $na.=substr($r->name,strpos($r->name," ")+1, 1);
																}
															@endphp
																									
													
														<div class="kt-widget__item">
															<span class="kt-media kt-media--circle">
																<!--<img src="assets/media/users/300_9.jpg" alt="image"> -->
																<div class="chat-icon-sm" style="background:#24578a !important;font-size:15px;margin-top:2px; ">{{strtoupper($na)}}</div>
															</span>
															<div class="kt-widget__info">
																<div class="kt-widget__section">
																	<a href="#" class="stud_name kt-widget__username" id="{{ $r->stud_id }}">{{ $r->name }}</a>
																	<span class="kt-badge kt-badge--success kt-badge--dot"></span>
																</div>
																<span class="kt-widget__desc">
																{{ $r->mobile }}
																</span>
															</div>
															<div class="kt-widget__action">
																<span class="kt-widget__date">&nbsp;</span>
																@if($r->new_chat_count>0)
																   <span class="kt-badge kt-badge--success kt-font-bold">{{$r->new_chat_count}}</span>
																@endif
															</div>
														</div>
														
													@endforeach	
												

							<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							<thead>
								<tr>
									<th width="100%">
									
												<div class="row">
													<div class="col-lg-11 col-xl-11 col-xxl-11">
														<div class="kt-searchbar">
															<div class="input-group">
																<div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
																			<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																				<rect x="0" y="0" width="24" height="24" />
																				<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																				<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
																			</g>
																		</svg></span></div>
																<input type="text" class="form-control" id="txt_search" placeholder="Search" aria-describedby="basic-addon1">
															</div>
														</div>
													</div>
													
													<div class="col-lg-1 col-xl-1 col-xxl-1">
													  <button type="button" class="btn btn-primary btn-xs" id="txt_search" placeholder="Search" aria-describedby="basic-addon1"></button>
													</div>
													
													</div>
									
									</th>
								</tr>
							</thead>
							<tbody>
							
							</tbody>
							</table>

							</div>
							</div>
						</div>
					</div>
				</div>

				<!--end::Portlet-->
			</div>

								<!--End:: App Aside-->

			<!--Begin:: App Content-->
			<div class="kt-grid__item kt-grid__item--fluid kt-app__content" id="kt_chat_content">
				<div class="kt-chat">
					<div class="kt-portlet kt-portlet--head-lg kt-portlet--last">
						<div class="kt-portlet__head">
							<div class="kt-chat__head ">
								<div class="kt-chat__left">
									<!--left side menu here -->
								</div>
								
								<div class="kt-chat__center chat_head">
									<div class="kt-chat__label">
										<a href="#" class="kt-chat__title">&nbsp;</a>
										<span class="kt-chat__status">
											<span class="kt-badge kt-badge--dot kt-badge--success"></span> Active
										</span>
									</div>
															</div>
								
								<div class="kt-chat__right">
									<!-- Right side menu here-->
								</div>
							</div>
						</div>
						
					  <div class="kt-portlet__body" style="padding:10px 10px;">
						 <div class="kt-scroll kt-scroll--pull" data-mobile-height="300">
							<div class="kt-chat__messages" style="overflow-y:scroll; height:340px;">
							 
							 <input type="hidden" name="student_id" id="student_id" value="">
							 <input type="hidden" name="admin_id" id="admin_id" value="{{Session::get('admin_id')}}" >
							 <input type="hidden" name="chat_no" id="chat_no" value="{{Session::get('chat_no')}}" >
							 
							 <div id="chat_messages" style="width:97%;">
							 
								<!--- chat message here ---------------->
								
							 </div>
							
						 </div>
					  </div>
					
					
					  <div class="kt-portlet__foot">
						<div class="kt-chat__input">
							<div class="kt-chat__editor">
								<div class="row">
								<div class="col-lg-10 col-xl-10 col-xxl-10">
									<textarea style="height: 50px" name="message" id="message" placeholder="Type here..."></textarea>
								</div>
								<div class="col-lg-2 col-xl-2 col-xxl-2">
									<button type="button" class=" btnReply btn btn-brand btn-md btn-upper btn-bold kt-chat__reply">reply</button>
								</div>
								</div>
							</div>
						</div>
					  </div>
				</div>
			</div>

			<!--End:: App Content-->
		</div>

		<!--End::App-->
	</div>

	<!-- end:: Content -->
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

$(".chat_head").hide();

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


$('#datatable tbody').on( 'click', '.stud_name', function (e)
{
	e.preventDefault();

	$(".chat_head").show();

	var sid=$(this).attr('id');
	var sna=$(this).text();
	$("#student_id").val(sid);
	$(".kt-chat__title").html(sna);
	
	jQuery.ajax({
		type: "GET",
		url: "get_chat_messages"+"/"+sid,
		dataType: 'html',
		//data: {vid: vid},
		success: function(res)
		{
		   $("#chat_messages").empty();
		   $("#chat_messages").append(res);
		   $("#chat_no").val("{{ Session::get('chat_no')}}");
		}
	});
});


var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :10,
		scrollX: true,
		
		'pagingType':"simple_numbers",
        'lengthChange': true,
		
        ajax: {
			url:"view_chat_students",
			data: function (data) 
		    {
				data.search = $('input[type="search"]').val();
		    },
		},
		
		/*columnDefs:[
				  {"width":"60px","targets":1},
				],*/
	
        columns: [
            {"data": "studs" ,name: 'Names',orderable: false, searchable: true },
        ]
		
    });



$(".btnReply").click(function(e)
{

	e.preventDefault();
	
	var stid=$("#student_id").val();
	var adid=$("#admin_id").val();
	var msg=$("#message").val();
	
	jQuery.ajax({
		type: "POST",
		url: "add_admin_chat_message",
		dataType: 'html',
		data: {_token:"{{csrf_token()}}",stud_id:stid,admin_id:adid,message:msg},
		success: function(res)
		{
			$("#message").val("");
			add_message(msg,res);
		}
	});
});

function add_message(mes,id)
{
	var dt=moment().format("D-M-YYYY h:mm:ss A");;
	
	var no=$("#chat_no").val();
	
	var mesg='<div class="kt-chat__message" id="con-'+no+'">'+
						'<div class="kt-chat__user">'+
						  '<div class="row">'+
							'<div class="col-lg-1">'+
							'<span class="kt-media kt-media--circle kt-media--sm">'+
								<!--<img src="assets/media/users/100_12.jpg" alt="image">-->
								'<div class="chat-icon-sm" style="background:#034e14 !important;font-size:15px;margin-top:2px; ">Ad</div>'+
							'</span></div>'+
							
							'<div class="col-lg-11">'+
								'<div class="row">'+
								'<div class="col-lg-12">'+
								'<span class="kt-chat__username"><b>You</b></span>'+
								'<span class="kt-chat__datetime">'+dt+'</span>'+
								'</div>'+
								
								'<div class="col-lg-11">'+
								'<div class="kt-chat__text kt-bg-light-success">'+mes+'</div>'+
								'</div>'+
								'<div class="col-lg-1">'+
								'<a href"#" class="btnDel" onclick="deleteChat(this)" data-id="con-'+no+'" id="'+id+'"><i class="fa fa-trash"></i></a>'+
								'</div>'+
								'</div>'+
							'</div>'+
						 ' </div>'+
						'</div>'+
					'</div>';
			
	   $("#chat_messages").append(mesg);
	   $("#chat_no").val(parseInt(no)+1);
	   
	   var objDiv = $(".kt-chat__messages");
    	 var h = objDiv.get(0).scrollHeight;
    	 objDiv.animate({scrollTop: h});
}


function deleteChat(data)
{
  var cid  = $(data).attr('id');
  var div_na=$(data).attr('data-id');

	if(confirm("Are you sure, Delete this chat?"))
	{
	  
	  
	  jQuery.ajax({
		type: "GET",
		url: "remove_chat_message"+"/"+cid,
		dataType: 'html',
		//data: {_token:"{{csrf_token()}}",chat_id:cid},
		success: function(res)
		{
			 $("#"+div_na).remove();
		}
	});

	 
	}

}




/*
$('#btnAdd').click(function()
{
	$("#icon_output").attr('src','');
});

   $("#course_icon").change(function() {
        var file = document.getElementById("course_icon").files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function() {
                $("#icon_output").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
   });
   
 $('#datatable tbody').on( 'click', '.edit', function ()
  {
	var cid=$(this).attr('id');
	
		var Result=$("#kt_modal_1 .modal-body");
		
			$(this).attr('data-target','#kt_modal_1');
		
				jQuery.ajax({
				type: "GET",
				url: "edit_course"+"/"+cid,
				dataType: 'html',
				//data: {vid: vid},
				success: function(res)
				{
				   Result.html(res);
				}
			});
  });

function fileValidation()
{
	 var fileInput = document.getElementById('course_icon'); 
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

$(document).on('click','#conf', function()
{
	return confirm("Are you sure, Delete in the details?");
});
*/


</script>

@endpush

@endsection





