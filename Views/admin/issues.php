<div class="row">
	<div class="container">
		<div class="row my-2">
			<div class="col-md-12">
				<div class="btn-group">
					<a href="issues_all" class="btn btn-primary has-icon btn-rounded btn-xs">
					  <i class="mdi mdi-bell"></i>All
					</a>
					<a href="issues_1" class="btn btn-success has-icon btn-rounded btn-xs">
					  <i class="mdi mdi-check"></i>Resolved
					</a> 
					<a href="issues_0" class="btn btn-danger has-icon btn-rounded btn-xs">
					  <i class="mdi mdi-alert"></i>Unresolved
					</a> 
					<a href="#" data-toggle="modal" data-target="#_issue_modal" class="btn btn-warning has-icon btn-rounded btn-xs text-light border-light">
					  <i class="mdi mdi-plus"></i>Report
					</a> 
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xl-9">
		<div class="col-lg-12 col-md-12 col-sm-12">
	        <div class="grid">
	          <p class="grid-header warning bg-dark">Issues</p>
	          <div class="item-wrapper">
	            <div class="table-responsive table-vertical">
	              <table class="table table-striped table-dark">
	                <thead>
	                  <tr>
	                  	<th>Reporter</th>
	                    <th>Description</th>
	                    <th>Severity <small>level</small></th>
	                    <th>Status</th>
	                  </tr>
	                </thead>
	                <tbody>
<?php

#print_r($_SESSION);

if(!empty($_SESSION['View_command'])){
	$_issues = json_decode($server->_render($_SESSION['View_command']),true);
}else{
	$_issues = json_decode($server->_load_issues('all'),true);

}
//This if statement if stupid but it get the Job done
if(!empty($_SESSION['View_command']) && $_issues == null){
}else{
	$_issues = json_decode($server->_load_issues('all'),true);
}

if(!empty($_issues)){
	for ($i = sizeof($_issues)-1; $i > -1 ; $i--) {
		//issue severity level display
		$severity = $_issues[$i]['severity'];
		switch (strtolower($severity)) {
			case 'low':
				$_tag = '<label class="badge badge-primary" > '.strtoupper($severity).' </label>';
				break;
			case 'medium':
				$_tag = '<label class="badge badge-warning" > '.strtoupper($severity).' </label>';
				break;
			case 'high':
				$_tag = '<label class="badge badge-danger" > '.strtoupper($severity).' </label>';
				break;
		}
		$_issue_status = $_issues[$i]['solved'];
		if($_issue_status==0){
			#<label class="badge badge-success" >'.$_status.'</label>
			$_status = '<label class="badge badge-danger" >Unresolved</label>';
			$_Update = "Resolved";
		}else{
			$_status = '<label class="badge badge-success" >Resolved</label>';
			$_Update = "Unresolved";
		}
		$_user_details = json_decode($server->_get_username($_issues[$i]['uploader']),true);
		echo '<tr>
	            <td class="d-flex align-items-center border-top-0">
	              <img class="profile-img img-sm img-rounded mr-2" src="img/'.$_user_details['photo'].'" alt="profile image">
	              <span>'.$_user_details['Firstname']." ".$_user_details['Lastname'].'</span>
	            </td>
	            <td>
	            	<div class="btn btn-xs btn-rounded has-icon btn-outline-success" >
	            		<i class="mdi mdi-eye" ></i>
	            		<span data-toggle="modal" data-target="#Reading_modal" onclick=\'_read_issue("'.$_issues[$i]['issue_id'].'")\' >Read</span>
	            	</div>
	            </td>
	            <td>
	            	'.$_tag.'
	            </td>
	            <td>
	            	'.$_status.'';

	            	if( json_decode($server->_user_roles($User[1]['role']),true)[0]['value'] =="admin"){
	            		echo '|
								<button type="button" class="btn btn-trasnparent action-btn btn-xs component-flat pr-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  <i class="mdi mdi-dots-vertical"></i>
								</button>
								<div class="dropdown-menu dropdown-menu-right">
								  <a class="dropdown-item" onclick=\'update_issue("'.$_issues[$i]['issue_id']."@".$_issues[$i]['solved'].'")\' href="#">Update('.$_Update.')</a>
								</div>';
	            	}

	            	echo '
	            </td>
	          </tr>';
	}
}
?>
	                </tbody>
	              </table>
	            </div>
	          </div>
	        </div>
	    </div>
	</div>
</div>

<div class="modal fade" id="_issue_modal">
	<div class="modal-dialog">
		<div class="modal-content" type="document">
			<div class="modal-header bg-dark ">
				<h3 class="featurette-header text-center text-light" >
					<span>Report Issue</span>
					<i class="mdi mdi-alert mdi-danger" ></i>
				</h3>
			</div>
			<div class="modal-body bg-dark">
				<div class="form-group" >
					<div class="alert alert-info" style="text-transform: capitalize; font-family: Helvetica; font-size: 20px;" >Team:
						<?php echo $User[1]['team']; ?>
					</div>
					<hr class="featurette-divider bg-dark" >
					<input type="text" class="form-control" id="issue_title" name="issue_title" placeholder="Issue Title" required autocomplete autofocus>
					<hr class="featurette-divider text-light" >
					<h5 class="featurette-header text-light bg-dark" >Issue Severity</h5>
					<select name="Severity" id="Severity" class="form-control border border-primary" required autocomplete >
						<option class="form-control border-light bg-dark text-light" ></option>
						<option class="form-control border-light bg-dark text-light" >Low</option>
						<option class="form-control border-light bg-dark text-light" >Medium</option>
						<option class="form-control border-light bg-dark text-light" >High</option>
					</select>
				</div>
				<input type="text" name="team" id="team" value="<?php echo $User[1]['team']; ?>" hidden class="form-control" >
				<div class="form-group">
					<textarea class="form-control textarea textarea-md border-success" id="issue" name="Description" placeholder="Issue Descrition"></textarea>
				</div>
				<div class="btn-group">
					<button class="btn btn-success btn-rounded has-icon btn-xs" id="issue_submit" type="submit">
						Submit <i class="mdi mdi-upload" ></i>
					</button>
					<button class="btn btn-danger btn-rounded has-icon btn-xs" type="button" >
						Reset <i class="mdi mdi-autorenew" ></i>
					</button>
					<button data-dismiss="modal" class="btn btn-warning btn-rounded has-icon btn-xs" type="button" role="button">
						Close <i class="mdi mdi-window-close" ></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="Reading_modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content bg-dark card w-18 border border-light">
			<div class="card card-w-20 bg-dark">
				<div class="card-header">
					<h6 class="featurette-header"> Issue : 
						<span class="label" id="_issue_head"> </span>
					</h6>
				</div>
				<div class="card-body text-light" style='padding:5px;border-radius:5px;font-size:1rem; font-weight:10px;margin:0px 0px;text-align: justify; width:100%; background-color:rgba(0,0,0,0.7);font-family: "Segoe UI";' >
					<h6 class="severity text-light text-center" id="issue_severity" ></h6>

					<p class="card-text text-light" id="_issue_description" style="padding:10px;" ></p>

					<hr class="bg-dark featurette-divider" >
					<h6 calss="featurette-header text-light" style="color:#ccc;" id="Status"></h6>
				</div>
				<div class="card-footer">
					<div class="btn-group">
						<button class="btn btn-danger" data-dismiss="modal"> Close
							<i class="fa fa-close"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="card w-10 mx-5 my-5 px-0 py-0 border border-success" id="_responce" style="display: none;">
	<div class="container px-0 bg-dark ">
		<div class="grid py-2 px-4 my-0 my-0 bg-dark">
			<div class="row">
				<div class="col-md-9 px-0 text-center">
					<p class="card-text" id="_responce_text" style="font-family: Helvetica; font-size: 20px;">
						
					</p>
				</div>
				<div class="col-md-1 has-icon">
					<span class="btn btn-rounded py-3 px-3 my-2 mx-2 border border-light" id="_responce_close">
						<i class="mdi mdi-close mdi-md text-danger" ></i>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>