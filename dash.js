$(document).ready(function(){
	_key();

	function now(){
		var date = new Date();
		var hr = date.getHours();
		var min = date.getMinutes();
		var sec = date.getSeconds();
		if (hr<10) {
			h1 = "0";
		}else{
			h1 = "";
		}
		if (min<10) {
			h2 = "0";
		}else{
			h2 = "";
		}
		if (sec<10) {
			h3 = "0";
		}else{
			h3 = "";
		}
		var month = date.getMonth()+1;

		dt = date.getUTCFullYear() +"-"+month+"-"+date.getUTCDate()  +" "+  h1+hr+":"+h2+min+":"+h3+sec;
		return dt;
	}

	function time_peice (){
		var time_peice = document.getElementById("time_peice");
		var time_peice_2 = document.getElementById("time_peice_2");

		var date = now();
		
		if(time_peice!==null){
			time_peice.setAttribute("value",date.toString());
		}
		if(time_peice_2!==null){
			time_peice_2.setAttribute("value",date.toString());
		}

		//time_peice.innerText = date();
	}
	setInterval(time_peice,1000);

	$("#_responce_close").click(function(){
		document.getElementById("_responce").removeAttribute('style');
		document.getElementById("_responce").setAttribute("style","display:none;");
	});

 
	if ($("#chartjs-doughnut-chart").length) {

		//var GB = 1073741824;‪
		
		//get server disk usage
		if(JSON.parse(localStorage.getItem('disk'))!==null){
			var disk = JSON.parse(localStorage.getItem('disk'));
		}else{
			var disk = JSON.parse(server_disk_usage());
		}


		var free = disk[0].free/1073741824;
		var used = disk[0].used/1073741824;
		var total = disk[0].total;

		var DoughnutData = {
		  datasets: [{
		    data: [free, used],
		    backgroundColor: chartColors,
		    borderColor: chartColors,
		    borderWidth: chartColors
		  }],
		  labels: [
		    'Free',
		    'Used'
		  ]
		};
		var DoughnutOptions = {
		  responsive: true,
		  animation: {
		    animateScale: true,
		    animateRotate: true
		  }
		};
		var doughnutChartCanvas = $("#chartjs-doughnut-chart").get(0).getContext("2d");
		var doughnutChart = new Chart(doughnutChartCanvas, {
		  type: 'doughnut',
		  data: DoughnutData,
		  options: DoughnutOptions
		});
	}


});
 

function _download_file(FID){
	$.ajax({
		url:"API.php",
		type:"post",
		data:{
			"type":"_download_file",
			"FID":FID
		},
		success:function(data,msg){
			console.log(data);
		}
	});
}

function server_disk_usage(){
	$.ajax({
		url:"API.php",
		type:"post",
		data:{
			"type":"disk_summary"
		},
		success:function(data,msg){
			localStorage.setItem('disk',data);
			return data;
		}
	});
}

function password_pre_submition_check(){
	//get Elements
	var pwd_1 = document.getElementById("pwd_1").value;
	var pwd_2 = document.getElementById("pwd_2").value;

	var pwd_msg = document.getElementById("pwd_msg");

	while(pwd_1===pwd_2){
		if(pwd_1!==null){
		
			if(pwd_1===pwd_2){
				break;
			}else{

				if(pwd_msg.setAttribute("class","text-danger")){

				}else{
					pwd_msg.setAttribute("class","text-danger");
				}

				pwd_msg.innerHTML = 'Passwords do nt match. <i class="fa fa-exclamation-triangle fa-md" ></i>';

			}

		}
	}
}

$("#issue_submit").click(function(){
	upload_issue();
});

function _key(){
	if(document.cookie){
		if(document.cookie.split(";")){
			var _KEY = document.cookie.split(";");
			var _key_ = _KEY[1].split("=");
			return _key_[1];
		}
	}
}

function _read_issue(_issue){
	if(_issue !== null){
		$.ajax({
			url:"API.php",
			type:"Post",
			data:{
				"type":"_issue_load",
				"_issue":_issue
			},
			success:function(data,msg){
				var data = JSON.parse(data)[0];
				var _view = document.getElementById('_issue_description');
				var _title = document.getElementById('_issue_head');
				var _severity = document.getElementById('issue_severity');
				var _status = document.getElementById('Status');

				if(data.solved === 1){
					var solved = 'Issue Status : <span class="badge badge-success badge-md">Resolved</span>';
				}else{
					var solved = 'Issue Status : <span class="badge badge-danger badge-md">Unresolved</span>';
				}
				switch(data.severity){
					case "High":
						var severity = 'Issue Severity :<label class="badge badge-danger text-dark ml-3">'+data.severity+'</label>';
						break;
					case "Medium":
						var severity = 'Issue Severity :<label class="badge badge-warning">'+data.severity+'</label>';
						break;
					case "Low":
						var severity = 'Issue Severity :<label class="badge badge-primary text-light">'+data.severity+'</label>';
						break;
				}

				var line_br = "\\"+"n";
				//console.log(line_br);

				//console.log(data.issue_description.toString().replace(line_br,"<br>"));
				var description = data.issue_description.toString();

				_view.innerHTML = '<h5 class="featurette-header text-center">Issue Description:</h5><hr class="featurette-divider bg-dark" >'+description.replace(/(\r\n|\n|\r)/,"<br>");
				_title.innerText = data.issue_head;
				_severity.innerHTML = severity;
				_status.innerHTML = solved;
			}
		});

	}else{}
}

function upload_issue(){
	var severity = document.getElementById('Severity').value;
	var issue = document.getElementById('issue').value;
	var team = document.getElementById('team').value;
	var title = document.getElementById('issue_title').value;

	//time

	var date = new Date();
		var hr = date.getHours();
		var min = date.getMinutes();
		var sec = date.getSeconds();
		if (hr<10) {
			h1 = "0";
		}else{
			h1 = "";
		}
		if (min<10) {
			h2 = "0";
		}else{
			h2 = "";
		}
		if (sec<10) {
			h3 = "0";
		}else{
			h3 = "";
		}
		var month = date.getMonth()+1;

		dt = date.getUTCFullYear() +"-"+month+"-"+date.getUTCDate()  +" "+  h1+hr+":"+h2+min+":"+h3+sec;
	
	$.ajax({
		url:"API.php",
		type:"POST",
		data:{
			"type":"issue_upload",
			"_key":_key(),
			"title":title,
			"team":team,
			"severity":severity,
			"issue":issue,
			"date":dt
		},
		success:function(data,msg){
			var data = JSON.parse(data);
			//console.log(data.error);
			if(data.error == 0){
				var issue = document.getElementById('issue').value = "";
				var title = document.getElementById('issue_title').value = "";

				//Control responce
				document.getElementById("_responce").removeAttribute('style');
				document.getElementById("_responce").setAttribute("style",'width:250px;height: 70px; text-align: center;z-index: 9990909;position: fixed;top: 0;right: 0;display: table;');
				document.getElementById("_responce_text").innerText = "Upload Success";

			}	
		}
	});

}

function update_issue(IID){
	if(IID !== null){
		$.ajax({
			url:"API.php",
			type:"post",
			data:{
				type:"update_issue",
				"IID":IID
			},
			success:function(data,msg){
				console.log(data);
				var issue = document.getElementById('issue').value = "";
				var title = document.getElementById('issue_title').value = "";
				//Control responce
				document.getElementById("_responce").removeAttribute('style');
				document.getElementById("_responce").setAttribute("style",'width:250px;height: 70px; text-align: center;z-index: 9990909;position: fixed;top: 0;right: 0;display: table;');
				document.getElementById("_responce_text").innerHTML = "Update Success <br> <a href='' class='link has-icon'> <i class='mdi mdi-reload mdi-md' ></i> </i>";
			}
		});

	}
}

function _read_upload(PID){
	var content = document.querySelector("content");
	//DOM elements
	 var title = document.getElementById('upload_preview_title');
	 var description = document.getElementById("upload_preview_description");
	 var attachment_div = document.getElementById("attachement_display");
	 var time = document.getElementById('upload_preview_time');

	$.ajax({
		url:"API.php",
		type:"post",
		data:{
			"type":"_read_upload",
			"PID":PID
		},
		success:function(data,msg){
			var data = JSON.parse(data)[0];
			title.innerText =  data.UID+" : "+data.title;
			description.innerText = data.upload_text;
			time.innerText = data.upload_date;
			//Source and embed the uploaders profile image
			preview_profile_img.setAttribute('src',"img/"+data.photo);
			//get the attachement type (image/file)
			if(data.attachment !== ""){
				if(data.attachement_type=="image"){
					attachment_div.innerHTML = '<div class="container-fluid m-0 p-0" style="width:100%;height: auto;display: block;">'
													+'<div class="p-0 m-0" style="width: 100%;height: 144px;display: table;margin-left: auto;margin-right:auto;background-color: rgba(0,0,0,0.4);" >'
														+'<div class="container card" style="display: table-cell;vertical-align: middle;height: 100%;width: 100%;text-align: center;">'
															+'<img src="'+data.attachment+'"  class="card-top-img w-1 h-1" alt="Attachment" style="display:table; width:100%;height:auto;">'
														+'</div>	'
													+'</div>'
												+'</div>';
				}else{
					attachment_div.innerHTML = '<div class="container-fluid m-0 p-0" style="width:100%;height: auto;display: block;">'
													+'<div class="p-0 m-0" style="width: 100%;height: 144px;display: table;margin-left: auto;margin-right:auto;background-color: rgba(0,0,0,0.4);" >'
														+'<div class="container" style="display: table-cell;vertical-align: middle;height: 100%;width: 100%;text-align: center;">'
															+'<a href="'+data.attachment+'" class="btn btn-primary btn-sm btn-rounded has-icon text-light" >'
																+'<i class="mdi mdi-download mdi-md mr-1" ></i>Download File'
															+'</a>'
														+'</div>'	
													+'</div>'
												+'</div>';
				}
			}else{
				attachment_div.innerHTML =  '<div class="container-fluid m-0 p-0" style="width:100%;height: auto;display: block;">'
													+'<div class="p-0 m-0" style="width: 100%;height: 144px;display: table;margin-left: auto;margin-right:auto;background-color: rgba(0,0,0,0.4);" >'
														+'<div class="container" style="display: table-cell;vertical-align: middle;height: 100%;width: 100%;text-align: center;">'
															+ '<span class="alert alert-default text-light bg-dark" > <span class="badge badge-danger"><i class="mdi mdi-close mdi-xs" ></i></span> No Attachement</span>'
														+'</div>'	
													+'</div>'
												+'</div>';;
			}
		}
	});
}

function _read_lyrics (LID){
	if(LID !== null){
		$.ajax({
			url:"API.php",
			type:"post",
			data:{
				"type":"read_lyrics",
				"LID":LID
			},
			success:function(data,msg){
				//get the DOM display containers
				 var singer = document.getElementById('_singer_name');
				 var song_title = document.getElementById('_song_title');
				 var _lyrics = document.getElementById('_lyrics');
				 var upload_date = document.getElementById('_upload_date');

				 //parse the json data
				 var data = JSON.parse(data)[0];
				 console.log(data);

				 if(data !== null){

				 	var _lyrics_content =  data.lyrics.toString();

				 	singer.innerText = data.singer;
				 	song_title.innerText = data.song;
				 	upload_date.innerText = data.lyrics_date;
				 	_lyrics.innerHTML = _lyrics_content.replace("<br><br>","<br>");
				 }
			}
		});
	}else{}
}

function load_event(event_id){
	//DOM elements
	var title = document.getElementById("_title");
	var host = document.getElementById("_host");
	var description = document.getElementById("_description");
	var start = document.getElementById("_start_date");
	var end = document.getElementById("_end_date");
	//banner is an image
	var banner = document.getElementById("_banner");
	$.ajax({
			url:"API.php",
			type:"post",
			data:{
				"type": "_load_event",
				"EID": event_id
		},
		success:function(data,msg){
			var e = JSON.parse(data)[0];
			//console.log(e);
			title.innerText = "Title :" +e.title;
			host.innerText = e.host;
			description.innerText = e.description;
			start.innerText = e.start_date;
			end.innerText = e.end_date;

			banner.removeAttribute("src");
			banner.setAttribute("src",e.banner);
		}
	});
}
function _upload_modal_param(){
	var attachment_div = document.getElementById("_file_field");
	if (attachment_div.innerHTML == "") {
		attachment_div.innerHTML='<div class="col-md-12 showcase_content_area" >'
									+'<div class="custom-file">'
										+'<input type="file" class="custom-file-input" id="customFile" name="my_file" accept="image/*|media_type" file_extensions=".png,.jpg,.jpeg,.psd,.bitmap,.docx,.pdf,.xlsx,.accdb,.gif" >'
										+'<label class="custom-file-label" for="customFile">Choose file</label>'
									+'</div>'
								+'</div>';
		document.getElementById('upload_form').setAttribute('enctype',"multipart/form-data");
	}else{
		attachment_div.innerHTML = "";
		document.getElementById('upload_form').removeAttribute('enctype');
	}
}

//Reassign User

function r (RID){
	if(RID !== null){
		$.ajax({
			url:"linker.php",
			type:"post",
			data:{
				type:"Reassign",
				"RID":RID
			},
			success:function(data,msg){
				console.log(data);
				//Control responce
				document.getElementById("_responce").removeAttribute('style');
				document.getElementById("_responce").setAttribute("style",'width:250px;height: 70px; text-align: center;z-index: 9990909;position: fixed;top: 0;right: 0;display: table;');
				document.getElementById("_responce_text").innerHTML = "Reassignment Complete <small>Reload</small> <br> <a href='' class='link has-icon'> <i class='mdi mdi-reload mdi-md' ></i> </i>";
			}
		});

	}
}