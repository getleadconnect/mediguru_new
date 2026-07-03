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

.igroup
{
	display:none;
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

.pshow
{
	display:block;
}
.phide
{
	display:none;
}

</style>


<!-- for message -------------->
		<input type="hidden" id="view_message" value="{{ Session::get('message') }}">
	<!-- for message end-------------->	

<input type="hidden" name="img_path" id="img_path" value="{{ config('constants.file_path')}}">

<div class="kt-subheader-search ">
	<div class="kt-container  kt-container--fluid ">
		<h3 class="kt-subheader-search__title">
		Chat
	</h3>
</div>
</div>


<div class="picture_box phide" style="position:absolute;z-index:9999999;width:80%;height:90%;background:#060606e0;">
<div class="row">
<div class="col-lg-12 text-right">
<label style="color:#fff;font-size:30px;right:10;cursor:pointer;margin:-7px 10px;color:red;" id="lblClose">x</label>
</div>
</div>
<div style="display:flex;align-items:center;justify-content:center;height:80%;overflow:auto;" >
<img id="view_pic" src="">
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
		
				<div class="kt-widget kt-widget--users kt-mt-20">
					<div class="kt-scroll kt-scroll--pull">
						<div class="kt-widget__items">

						<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse:collapse; border-spacing:0; width:100%;">
							  <thead>
								<tr>
									<th width="100%">
									

											<div class="form-group form-group-marginless">
												<div class="input-group">
													<input type="text" id="txt_search" class="form-control" placeholder="Search..." aria-describedby="basic-addon2">
													<div class="input-group-append">
													<span class="input-group-text" id="basic-addon2" style="padding:4px;">
													<button type="button" id="btn_search" class="btn btn-brand" style="padding:3px 5px 3px 7px;"><i class="la la-search" style="color:#fff;"></i></button>
													</span></div>
												</div>
											</div>

									
									</th>
								</tr>
							  </thead>
							<tbody>
							
							<!------student names here ------>
							
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
							<div class="kt-chat__messages" style="overflow-y:scroll; height:370px;">
							 
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
								<div class="col-lg-1 col-xl-1 col-xxl-1">
									<button id="picture" style="margin-top:7px !important;padding:0px 5px;border:none;">
									<i class="flaticon2-photograph" style="font-size:25px;cursor:pointer;top:15px;color:#5867dd;" title="image"></i></button>
								</div>
								
									<div class="col-lg-11 col-xl-11 col-xxl-11" style="padding:10px;right:10px;">
									
									<div class="igroup" style="position:absolute;z-index:99999999;width:100%;">
									
										<form method="post" id="FormRequest" enctype="multipart/form-data">
										@csrf	
										
										<input type="hidden" name="student_id1" id="student_id1" value="">
										<input type="hidden" name="admin_id1" id="admin_id1" value="{{Session::get('admin_id')}}" >
										<input type="hidden" name="chat_no1" id="chat_no1" value="{{Session::get('chat_no')}}" >
								 
										
										  <div class="input-group" >
											<input type="file" name="file1" class="form-control" placeholder="Recipient's username" aria-describedby="basic-addon2" style="height:50px;">
											<div class="input-group-append"><span class="input-group-text" id="basic-addon2">
											<button type="submit" class="btn btn-primary btn-xs" style="padding:5px 3px 5px 7px;">
											<i class="flaticon2 flaticon-upload" style="font-size:20px;color:#fff;" title="upload" ></i></button></div>
										  </div>
										</form>
									</div>
								
									<div class="row">
										<div class="col-lg-10">
											<textarea style="height: 50px;border:1px solid #e4e4e4 !important;" name="message" id="message" placeholder="Type here..."></textarea>
										</div>
										<div class="col-lg-2">
											<button type="button" class=" btnReply btn btn-brand btn-md btn-upper btn-bold kt-chat__reply">reply</button>
										</div>
									</div>
								
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

$(".chat_head").hide();
$(".igroup").hide();

$(".btnReply").prop('disabled',true);
$("#picture").prop('disabled',true);


 $("#picture").click(function()
 {
    $(".igroup").toggle();
 });

$("#lblClose").click(function()
{
	$(".picture_box").addClass('phide');
	$("#view_pic").attr('src',"");
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
});

$("form#FormRequest").submit(function(e)
{
    e.preventDefault();
    
    var formData = new FormData(this);
        
		var mes="";
		var id=100;
		
        $.ajax({
            url: "{{ url('add_image')}}",
            type: 'POST',
            data: formData,
            success: function (res) 
    	    {
				add_message(mes,id,res);
            },
            cache: false,
            contentType: false,
            processData: false
        });
   
});


$('#datatable tbody').on( 'click', '.stud_name', function (e)
{
	e.preventDefault();

	$(".chat_head").show();
	$(".igroup").hide();
	$("#chat_count").html("");

	var sid=$(this).attr('id');
	var sna=$(this).text();
	
	$("#student_id").val(sid);
	$("#student_id1").val(sid);
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
		   
		   $(".btnReply").prop('disabled',false);
		   $("#picture").prop('disabled',false);

		}
	});
});



var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
		stateSave:true,
		paging     : true,
        pageLength :100,
		scrollX: true,
		bFilter:false,
		
		'pagingType':"simple_numbers",
        'lengthChange': true,
		
        ajax: {
			url:"view_chat_students",
			data: function (data) 
		    {
				//data.search = $('input[type="search"]').val();
				data.search = $('#txt_search').val();
		    },
		},
		
		/*columnDefs:[
				  {"width":"60px","targets":1},
				],*/
	
        columns: [
            {"data": "studs" ,name: 'Names',orderable: false, searchable: true },
        ],
		
		initComplete: function(settings, json) {
			$('#txt_search').val("");
		}
		
		
		
    });

$("#btn_search").click(function(e)
{
	e.preventDefault();
	table.draw();
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
			add_message(msg,res,"");
		}
	});
});


function view_image(data)
{
	var src  = $(data).attr('src');
	$("#view_pic").attr('src',src);
	$(".picture_box").removeClass('phide');
	$(".picture_box").addClass('pshow');
}


function add_message(mes,id,pic)
{
	var dt=moment().format("D-M-YYYY h:mm:ss A");
		
	var no=$("#chat_no").val();
	var img=$("#img_path").val();
	
	var mesg="";
		mesg='<div class="kt-chat__message" id="con-'+no+'">'+
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
								
								'<div class="col-lg-11">';
								
								if(pic!='')
								{
									mesg+='<img onclick="view_image(this)" src="'+img+pic+'" style="widh:100px;height:100px;">';
								}
								else
								{
								    mesg+='<div class="kt-chat__text kt-bg-light-success">'+mes+'</div>';
								}
								
								mesg+='</div>'+
								'<div class="col-lg-1">'+
								'<a href"#" class="btnDel" onclick="deleteChat(this)" data-id="con-'+no+'" id="'+id+'"><i class="fa fa-trash" style="color:#f77b7b;"></i></a>'+
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





