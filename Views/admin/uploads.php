<div class="row">
	<div class="col-md-8">
		<div class="col-md-12 grid bg-dark">
			<div class="btn-group mb-0" >
              <a href="uploads_all" class="btn btn-outline-info btn-success btn-sm active btn-rounded text-light link">
                <i class="mdi mdi-upload mr-1"></i>
                All
              </a>
              <a href="uploads_personal" class="btn btn-outline-info btn-success btn-sm btn-rounded text-light link">
                <i class="mdi mdi-account-circle mr-1"></i>
                My Uploads
              </a>
              <label class="btn btn-outline-info btn-primary btn-rounded btn-sm text-light" data-toggle="modal" data-target="#_upload">
                <i class="mdi mdi-plus mr-1 mdi-lg"></i>
              </label>
            </div>
		</div>
	</div>
	<hr class="feature-divider bg-light">
</div>
<div class="container-fluid">
	<div class="row">	
		<?php
			if($_SESSION != null){
				if(!empty($_SESSION['View_command'])){
					if(json_decode($server->_render($_SESSION['View_command']),true) !== null){
						$_uploads = json_decode($server->_render($_SESSION['View_command']),true);

						$_SESSION['View_command'] = "";
					}else{
						$_uploads = json_decode($server->_render(array('View_name'=>'uploads','command'=>'all')),true);	
					}
				}else{
					$_uploads = json_decode($server->_render(array('View_name'=>'uploads','command'=>'all')),true);
				}
			}else{
				$_uploads = json_decode($server->_render(array('View_name'=>'uploads','command'=>'all')),true);
			}
			//get all permited file extesions from the syste file.
			$init = $server->file()['_file_upload']['file_types'];

			if(!empty($_uploads)){
				for ($i=sizeof($_uploads)-1; $i >-1 ; $i--) {
					//Get the plaoder Details
					$_uploader = json_decode($server->_get_username($_uploads[$i]['UID']),true);
					if($_uploads[$i]['attachment'] !== null){
						$attach = $_uploads[$i]['attachment'];
						//check the file extension and check whether or not it's an Image
						if(explode(".", $attach)){
							$explode = explode(".", $attach);
							if(in_array(strtolower($explode[sizeof($explode)-1]), ['png','gif','jpg','jpeg'])){
								$attachement = '<div class="container-fluid m-0 p-0" style="width:100%;height: auto;display: flex;">
													<div class="p-0 m-0" style="width: 100%;height: 144px;display: table;margin-left: auto;margin-right:auto;background-color: rgba(0,0,0,0.4);" >
														<div class="container card" style="display: table-cell;vertical-align: middle;height: 100%;width: 100%;text-align: center;">
															<img src="'.$attach.'"  class="card-top-img w-1 h-1" alt="Attachment" style="display:table; width:100%;height:auto;max-height:144px;">
														</div>	
													</div>
												</div>';
							}else if(in_array(strtolower($explode[sizeof($explode)-1]),explode("/",$init))){
								//prep the file ext
								$ext_list =explode("/",$init);
								$test_subj = explode(".", $attach);
								$_ext = $test_subj[sizeof($test_subj)-1];
								if (in_array($_ext, $ext_list)) {
									switch ($_ext) {
										case 'docx':
											$ext = "word";
											break;
										case "pdf":
											$ext = "pdf";
											break;
										case "pptx":
											$ext = "powerpoint";
											break;
										case "accdb":
											$ext="database";
											break;
										case "txt":
											$ext = "outline";
											break;
										case 'xlsx':
											$ext = "excel";
											break;
										case 'xls':
											$ext = "excel";
											break;
										default:
											break;
									}
								}else{
									$ext = null;
								}
								$attachement = '<div class="container-fluid m-0 p-0" style="width:100%;height: auto;display: block;">
													<div class="p-0 m-0" style="width: 100%;height: 144px;display: table;margin-left: auto;margin-right:auto;background-color: rgba(0,0,0,0.4);" >
														<div class="container" style="display: table-cell;vertical-align: middle;height: 100%;width: 100%;text-align: center;">
															<a href="'.$attach.'" class="btn btn-primary btn-sm btn-rounded has-icon text-light" >
																<i class="mdi mdi-download mdi-md mr-1" ></i>Download File <i class="mdi mdi-file-'.$ext.' mdi-2x ml-2 mr-0"></i>
															</a>
														</div>	
													</div>
												</div>';
							}else{
								$attachement = null;
							}
						}
					}
					echo '<div class="col-md-4 col-sm-6 col-xs-12 m-0 p-0">
						<div class="grid bg-dark p-0">
							<h6 class="grid-title p-1 m-0">
								<img class="profile-img img-sm" src="img/'.$_uploader["photo"].'" alt="Event image">
								<small class="px-1">'.$_uploader['Firstname'].'</b></small>
							</h6>
							<div class="grid-body p-0 m-0">
								<div class="item-wrapper p-0">
									'.$attachement.'
									<hr class="feature-divider my-1 p-0 bg-light">
									<p class="item-wrapper p-2" style="font-size: 13px;"> Title : <b>'.$_uploads[$i]['title'].'<br> '.$_uploads[$i]["upload_text"].'</p>
									<hr class="feature-divider my-1 p-0 bg-light">
									<div class="btn-group p-1">
										<button class="btn btn-primary btn-xs has-icon" data-toggle="modal" data-target="#_upload_read" onclick="_read_upload(\''.$_uploads[$i]['PID'].'\')" > Preview <i class="mdi mdi-eye mdi-xs"></i> </button>
									</div>	
								</div>
							</div>
						</div>
					</div>';
				}
			}
		?>		
	</div>
</div>
<!--upload modal-->
<div class="modal fade" id="_upload">
	<div class="modal-dialog">
		<div class="modal-content bg-dark">
			<div class="modal-header bg-dark">
				<h4 class="feature-header text-right" >
					<i class="fa fa-upload fa-md" ></i> 
					Upload File
				</h4>
			</div>
			<form method="post" action="" class="modal-body form" id="upload_form">
				<div class="form-group">
					<input type="text" name="type" value="_upload" hidden readonly/>
					<input type="text" name="time_peice" id="time_peice" hidden>
				</div>
				<div class="form-group m-0 p-1">
					<label for="#category">Select Category</label>
					<select class="form-control" name="category" id="category" >
					<?php
						$file = $server->file()['_file_upload'];
						$categories = explode("/",$file['_category']);
						for ($i=0; $i < sizeof($categories) ; $i++) { 
							echo '<option class="bg-light text-dark"> '.$categories[$i].' </option>';
						}
					?>
					</select>
					<label for="#title">Title :</label>
					<input type="text" class="form-control p-2" autocomplete required name="title" id="title"/>
					<textarea class="form-control p-3 border border-success mt-1" cols="12" rows="6" name="text" placeholder="Upload Text."></textarea>
				</div>
				<button type="button"  onclick="_upload_modal_param()" class="btn btn-default btn-xs btn-rounded bg-light border border-light has-icon text-dark" >
					<i class="mdi mdi-paperclip mdi-1x text-dark" ></i> Add Attachement
				</button>
				<div class="form-group mt-2">
					<div class="form-group row" id="_file_field" >
						
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn-group">
						<button type="submit" class="btn btn-success btn-xs btn-rounded"> Upload <i class="mdi mdi-upload mdi-md" ></i> </button>
						<button type="button" class="btn btn-danger btn-xs btn-rounded" data-dismiss="modal">Close <i class="mdi mdi-close mdi-md" ></i></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!--read upload text-->
<div class="modal fade" id="_upload_read">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h6 class="mb-6 text-left text-light" >
					<img class="profile-img img-sm" id="preview_profile_img">
					<small>
						<small id="upload_preview_title" ></small>
					</small>
				</h6>
			</div>
			<div class="modal-body bg-dark p-0">
				<div class="attachement container-fluid p-0 m-0" style="display: table;height: 144px;">
					<div class="container-fluid" id="attachement_display" style="display: table-cell;width: 100%;height: 100%;" ></div>
				</div>
				<hr class="feature-divider bg-light p-0 my-1" >
				<p class="card-text p-1" id="upload_preview_description" ></p>
				<hr class="feature-divider bg-danger" >
				<span class="badge badge-sm badge-dark text-light border border-light mb-2 ml-4" id="upload_preview_time" ></span>
			</div>
			<div class="modal-footer bg-dark p-1">
				<div class="item-wrapper text-right bg-dark p-0 m-0 mt-2 mr-2 mb-2">
					<btn class="btn btn-danger btn-xs btn-rounded has-icon m-0 " data-dismiss="modal" > Close <i class="mdi mdi-close mdi-XS" ></i> </btn>
				</div>
			</div>
		</div>
	</div>
</div>