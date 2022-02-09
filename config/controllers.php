<?php
require(dirname(__FILE__)."/config.php");

class controller extends config{
	//get all the data from the init file
	public function file(){
		$file = dirname(__FILE__)."/init.json";
		if(file_exists($file)  & file_get_contents($file) != null){
			return json_decode(file_get_contents($file),true);
		}else{
		}
	}

	public function login($data){
		if($data != null){
			return self::loginHandler($data);
		}
	}

	public function session($sessionValue){
		if ($sessionValue != null & strlen($sessionValue) > 11) {
			return self::sessionHandler($sessionValue);
		}else{}
	}

	public function _add_user($array){
		return self::SignupHandler($array);
	}
	//View handling

	private function getView($View){
		if(isset($View)){
			$View = strtolower($View);
			$Views = explode("/",self::file()['Views']['Views']);
			$dir = "Views/";
			$ext = ".php";
			for($i = 0;$i < sizeof($Views);$i++){
				if($View == $Views[$i]){
					$SetView = $dir.$Views[$i].$ext;
					break;
				}else{
					$SetView = null;
				}
			}
			return $SetView;
		}
	}

	//View controls and rendering
	public function View($View){
		$Home_Views = ['dashboard','home','index'];
		if(in_array(strtolower($View), $Home_Views)){
			return self::getView('dashboard');
		}else{
			return self::getView($View);
		}
	}

	//Comprehensive function
	//These functions/ methods are usable for all or most of the operation in this system

		//Page data rendering and request handling methods / Page handlers
		//This function/ method is used to get specific data that is page or request related i.e variation of specfic data set.
		public function _render($array){
			if(!empty($array)){
				//get the connection
				$conn = self::Connect();
				
				//Use the first as a control in the switch
				$_called_view = strtolower($array['View_name']);

				//The control value
				$_data = strtolower($array['command']);

				//Check if the view called is valid
				$_check_view = explode("/",self::View($_called_view));
				if($_check_view != null){
					if(sizeof($_check_view)>0){
						$_view = explode(".", $_check_view[1]);
						$_view = $_view[0];
						//The following switches have switches in themselves
						switch ($_view) {
							case 'issues':
								//Allowed values
								$_allowed_values = ['all','1','0'];
								if(in_array($_data, $_allowed_values)){
									//Run switch and return result
									switch ($_data) {
										case 'all':
											return self::_load_issues("all");
											break;
										case '1':
											return self::_load_issues("resolved");
											break;
										case '0':
											return self::_load_issues("unresolved");
											break;
										default:
											# code...
											break;
									}

								}else{}
								break;
							case "uploads":
								$_upload_types = ["personal","all"];
								if(in_array($_data, $_upload_types)){
									switch ($_data) {
										case 'all':
											return  self::_load_uploads('all');
											break;
										case 'personal':
											return self::_load_uploads('personal');
											break;		
										default:
											# code...
											break;
									}
								}
								break;
							
							default:
								# code...
								break;
						};

					}else{}

				}
			}else{}
		}

		//get the First and lastname of a particuler UID value
		public function _get_username($_UID){
			if ($_UID !=="") {
				//get the user's firstname and lastname from the table using $_UID 
				$conn = self::Connect();

				$SQL = "SELECT `Firstname` ,`Lastname` ,`role`,`photo` FROM `users`WHERE `UID`= '$_UID' ;";
				//Run a query
				$query = $conn->query($SQL);

				if($query){

					if ($query->num_rows > 0) {
						while ($row = $query->fetch_assoc()) {
							$data = $row;
						}
						return json_encode($data);
					}

				}else{
					return "STOP";
				}

			}else{}
		}

		//Change profile Image

		public function _profile_Image_change($UID,$new_image){
			//Get connection
			$conn = self::Connect();
			if($UID !== null & $new_image !== null){

				$SQL = "UPDATE `users` SET `photo` = '$new_image' WHERE `UID` = '$UID';";

				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt,$SQL)){

				}else{
					mysqli_execute($stmt);
					$query = mysqli_stmt_get_result($stmt);
					return $query;
				}
			}
		}

		//Update the user Details
		public function user_update($array){
			if(isset($array)){

				$fname = $array[0];
				$lname = $array[1];
				$email = $array[2];
				$username = $array[3];
				//Password verification
				$pwd = $array[4];
				$current_pwd = $array[sizeof($array)-2];
				if(self::Hasher("pwd",$pwd)==$current_pwd){
					$pwd = $current_pwd;
				}else{
					$pwd = self::Hasher("pwd",$pwd);
				}
				//User uniqID
				$UID = $array[sizeof($array)-1];
				//check the password

				//get the connection
				$conn = self::Connect();

				//SQL statement
				$SQL = "UPDATE `users` SET `Firstname` = ?, `Lastname` = ?, `EmailAddress` = ?, `Username` = ?,`Password`=? WHERE `users`.`UID` = ?;";

				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt,$SQL)){

				}else{
					mysqli_stmt_bind_param($stmt,"ssssss",$fname,$lname,$email,$username,$pwd,$UID);
					mysqli_execute($stmt);
					return mysqli_stmt_get_result($stmt);
				}

			}
		}

		public function Reassign ($RID){
			if (!empty($RID)) {
				
				$r = explode("@", $RID);
				//reverse the user ID string to validly use it
				$UID = strrev($r[1]);

				//get the connection
				$conn = self::Connect();

				//SQL statement
				$SQL = "UPDATE `users` SET `role`=? WHERE `users`.`UID` = ?;";

				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt,$SQL)){

				}else{
					mysqli_stmt_bind_param($stmt,"ss",$r[0],$UID);
					mysqli_execute($stmt);
					$resp = array('status' => 'success' );

					return json_encode($resp);

				}

			}else{}
		}


		//get the use roles
		//$role should be an integer value
		public function _user_roles($role){
			$conn = self::Connect();
			$SQL = "SELECT * FROM `_user_roles` WHERE `role`=?";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt,$SQL)){
				return "Preparation failed";
			}else{
				mysqli_stmt_bind_param($stmt,"s",$role);
				mysqli_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);
				if($query){
					if($query->num_rows > 0){
						while ($row = $query->fetch_assoc()) {
							$data [] = $row;
						}
						return json_encode($data);
					}
				}
			}
		}
	//???????? Comprehensive function END

	public function _team_roles($TID){
		if(!empty($TID)){
			$tid = strtolower($TID);

			//Get the connection
			$conn = self::Connect();
			$SQL = "SELECT * FROM `_user_roles` WHERE `TID` = ?;";

			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt,$SQL)){
			}else{
				mysqli_stmt_bind_param($stmt,"s",$tid);
					mysqli_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);
				if($query !== null){
					if($query->num_rows > 0){
						while ($row = $query->fetch_assoc()) {
							$data [] = $row;
						}
						return json_encode($data);
					}else{
					}
				}else{}
			}

		}
	}

	//Issue related function
		//Load issues
		public function _load_issues($category){
			//get Connection
			$conn = self::Connect();

			$category = strtolower($category);
			$_categories = ['all','resolved','unresolved'];

			if(in_array($category, $_categories)){
				switch ($category) {
					case 'all':
						$SQL = "SELECT * FROM `issues` ;";
						break;
					case 'resolved':
						$SQL = "SELECT * FROM `issues` WHERE `solved`=1";
						break;
					case "unresolved";
						$SQL = "SELECT * FROM `issues` WHERE `solved`=0";
						break;
					default:
						break;
				}
				$stmt = mysqli_stmt_init($conn);

				if(!mysqli_stmt_prepare($stmt,$SQL)){
					return http_head($_SERVER['host']);
				}else{
					mysqli_execute($stmt);
					$query = mysqli_stmt_get_result($stmt);
					if($query !== null){
						if($query->num_rows > 0){
							while ($row = $query->fetch_assoc()) {
								$data [] = $row;
							}
							return json_encode($data);
						}else{
						}
					}else{}
				}
			}
		}

		public function _issue($_id){
			//get Connection
			$conn = self::Connect();
			if(strlen($_id) > 10){
				$SQL = "SELECT * FROM `issues` WHERE `issue_id` =? ;";
				$stmt = mysqli_stmt_init($conn);

				if(!mysqli_stmt_prepare($stmt,$SQL)){
					return http_head($_SERVER['host']);
				}else{
					mysqli_stmt_bind_param($stmt,"s",$_id);
						mysqli_execute($stmt);
					$query = mysqli_stmt_get_result($stmt);
					if($query !== null){
						if($query->num_rows > 0){
							while ($row = $query->fetch_assoc()) {
								$row['issue_description'] = str_replace(array('\n','\r'),"<br>", $row['issue_description']);
								$row['issue_description'] = str_replace("<br><br>","<br>", $row['issue_description']);
								$row['issue_description'] = str_replace("\\", "", $row['issue_description']);
								$data [] = $row;
							}
							return json_encode($data);
						}else{
						}
					}else{}
				}
			}else{}
		}
		//Upoad or Add a new issues
		public function _add_issue($data){
			//Start session
			session_start();
			//get connection
			$conn = self::Connect();	
			#validate the submitted KEY

			$_key = $data['_key'];
			if($_SESSION['sess']==strrev($_key)){
				//issue title
				$title = $data['title'];
				//team: Get the uploader's team TID
				$team = self::_team(["name",$data['team']])['TID'];
				//Severity
				$severity =$data['severity'];
				//issue description
				$issue_description = $data['issue'];
				//issue upload date
				$date = $data['date'];
				//Get the uploaders UID

				$uploader = self::Session($_SESSION['sess'])[1]['UID'];

				//generate Issue ID
				$_issue_id = uniqid(date("DmonYHttTs")."_ISSUE_",true);
				
				##########################################################

					//uplaod execution
				$SQL = "INSERT INTO `issues` (`Tid`, `issue_id`, `issue_head`, `issue_description`, `uploader`, `severity`, `data_raised`, `solved`) VALUES (?,?,?,?,?,?,?,0)";

				$stmt = mysqli_stmt_init($conn);

				if(!mysqli_stmt_prepare($stmt,$SQL)){

				}else{
					mysqli_stmt_bind_param($stmt,"sssssss",$team,$_issue_id,$title,$issue_description,$uploader,$severity,$date);
					mysqli_execute($stmt);
					$query = mysqli_stmt_get_result($stmt);
					
					return array('error' => 0 );
				}

			}
		}
	
	
	/* Uploads */

		//dowload Uploaded file
		public function _load_uploads($type){
			$type = strtolower($type);
			switch ($type) {
				case 'all':
					$SQL = "SELECT * FROM `uploads` ;";
					break;
				case 'personal':
					$UID = self::Session($_SESSION['sess'])[1]['UID'];
					$SQL = "SELECT * FROM `uploads` WHERE `UID`='$UID';";
					break;
				default:
					# code...
					break;
			}
			//Get the connection
			$conn = self::Connect();
			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt,$SQL)){
				return array('error'=>1,'summary'=>$stmt->error);
			}else{
				mysqli_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);
				if($query->num_rows > 0){
					while ($row = $query->fetch_assoc()) {
						$data[] =$row;
					}
					return json_encode($data);
				}
			}

		}

		//Text or regular uplaods

		public function _upload($array){
			if(sizeof($array)>0 & $array !== null){
				//get connection
				$conn = self::Connect();

				//Parameters
				$category = $array[0];
				$title = $array[1];
				$description = $array[2];
				$time = $array[3];
				$attachment = $array[4];
				$UID = $array[5];
				//Generate the PID
					$PID = strrev(uniqid(date("DMYYYYHMStt")."_upload",true));
				//
				$SQL = "INSERT INTO `uploads` (`PID`,`UID`,`category`,`title`,`upload_text`,`attachment`,`upload_date`) VALUES (?,?,?,?,?,?,?);";
				//Prepare stateent approach
				$stmt = mysqli_stmt_init($conn);

				if(!mysqli_stmt_prepare($stmt,$SQL)){
					return 00110;
				}else{					
					mysqli_stmt_bind_param($stmt,"sssssss",$PID,$UID,$category,$title,$description,$attachment,$time);
					mysqli_execute($stmt);
					$query = mysqli_stmt_get_result($stmt);
					return $query;
				}

			}else{}
		
		}

		//read specific upload

		public function _read_upload($PID){
			if(isset($PID)){
				//get Connection
				$conn = self::Connect();

				$SQL = "SELECT * FROM `uploads` WHERE `PID`=? ;";

				$stmt = mysqli_stmt_init($conn);

				if(!mysqli_stmt_prepare($stmt,$SQL)){
					return json_encode($stmt);
				}else{
					mysqli_stmt_bind_param($stmt,"s",$PID);
					mysqli_execute($stmt);

					$query = mysqli_stmt_get_result($stmt);
					if($query){
						if($query->num_rows > 0){

							$_img_ext = ['png','jpg','jpeg','psg','gif'];

							while ($row = $query->fetch_assoc()) {
								//get the uploadser's basic details
								$uploader = json_decode(self::_get_username($row['UID']),true);

								$row['UID'] = $uploader['Firstname'];
								$row['photo'] = $uploader['photo'];
								//check if the attachement file is an image or a document type file.
								$_att_ext = explode(".", $row['attachment'])[sizeof(explode(".",$row['attachment']))-1];
								if(in_array($_att_ext, $_img_ext)){
									$row['attachement_type'] = 'image';
								}elseif($row['attachment']==null){

								}else{
									$row['attachment_type'] = "file";
								}
								$data [] = $row;
							}
							return $data;
						}
					}
				}
			}
		}

	### Teams
		//Get the team details of a particular ID or team nam
		public function _team($array){
			$conn = self::Connect();
			if($array!=null){
				$_submitted_type = strtolower($array[0]);
				$data = strtolower($array[1]);
				switch ($_submitted_type) {
					case 'name':
						$type = "team";
						break;
					case "id":
						$type = "TID";
						break;
				}
				$SQL = "SELECT * FROM `teams` WHERE `$type` = '$data' ;";
				
				$query = $conn->query($SQL);
				if($query->num_rows >0){
					while ($row = $query->fetch_assoc()) {
						$data = $row;
					}
					return $data;
				}
				#$SQL = "INSERT INTO `issues` (`team_id`, `issue_id`, `issue_head`, `issue_description`, `uploader`, `serverity`, `date_raised`, `solved`) VALUES (?,?,?,?,?,?,?,?);";
			}else{}
		}

		//Get the user's team members from the users table
		public function user_team($TID){
			$conn = self::Connect();
			$SQL = "SELECT * FROM `users` WHERE `Tid`=? ;";
			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt,$SQL)){
				return "Prep Failed";
			}else{
				mysqli_stmt_bind_param($stmt,"s",$TID);
				mysqli_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);
				if($query){
					if($query->num_rows > 0){
						while ($row = $query->fetch_assoc()) {
							$data [] = $row;
						}
						return json_encode($data);
					}else{}
				}
			}
		}

	//CHOIR
		public function get_choir(){
			$conn = self::Connect();
			$SQL = "SELECT * FROM `users` WHERE `Tid`= 'mega1999'";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt,$SQL)){
				return "Prepe failed";
			}else{
				mysqli_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);
				if($query){
					if($query->num_rows>0){
						while ($row = $query->fetch_assoc()) {
							$data [] = [$row['UID'],$row['Firstname'],$row['Lastname'],$row['EmailAddress'],$row['Tid'],$row['team'],$row['photo'],$row['role']];
						}
						return json_encode($data);
					}
				}
			}
		}

		//Upload lyrics

		public function _upload_lyrics($data,$uploader){
			if(!empty($data)){

				$conn = self::Connect();

				$_singer = $data['_singer'];
				$_song = $data['_song'];
				$_lyrics = $conn->real_escape_string($data['_lyrics']);
				$_time = $data['time_peice'];
				$_uploader = $uploader;

				$LID = explode(".",uniqid(date("MDYHSmt")."_lyrics_",true));
				$LID = implode("@", $LID);

				$SQL = "INSERT INTO `lyrics` (`LID`,`song`,`singer`,`lyrics`,`uploader`,`lyrics_date`) VALUES (?,?,?,?,?,?);";

				$stmt = mysqli_stmt_init($conn);

				if(!mysqli_stmt_prepare($stmt,$SQL)){

				}else{
					mysqli_stmt_bind_param($stmt,"ssssss",$LID,$_song,$_singer,$_lyrics,$_uploader,$_time);
					mysqli_execute($stmt);

					$query = mysqli_stmt_get_result($stmt);

					return $query;
				}

			}
		}
		//get lyrics
		public function _get_lyrics(){
			$conn = self::Connect();

			$SQL = "SELECT * FROM `lyrics`; ";
			$query =  $conn->query($SQL);

			if($query){
				if($query->num_rows > 0){
					while ($row = $query->fetch_assoc()) {
						$data [] = $row;
					}
					return json_encode($data);
				}
			}else{}
		}
		//get lyrics uploaded by a particular user
		public function _member_lyrics($UID){
			$conn = self::Connect();

			$SQL = "SELECT * FROM `lyrics` WHERE `uploader`=? ;";
			$stmt = mysqli_stmt_init($conn);

				if(!mysqli_stmt_prepare($stmt,$SQL)){

				}else{
					mysqli_stmt_bind_param($stmt,"s",$UID);
					mysqli_execute($stmt);
					$query = mysqli_stmt_get_result($stmt);
					if($query){

						if($query->num_rows > 0){

							while ($row = $query->fetch_assoc()) {
								$data [] = $row;
							}

							return json_encode($data);
						}else{}

					}
				}

		}

		//Read lyrics using LID / LyricID value
		public function _read_lyrics($LID){
			if(!empty($LID)){
				//get the connection
				$conn = self::Connect();

				$SQL = "SELECT * FROM `lyrics` WHERE `LID`=? ;";

				$stmt = mysqli_stmt_init($conn);

				if(!mysqli_stmt_prepare($stmt,$SQL)){

				}else{
					mysqli_stmt_bind_param($stmt,"s",$LID);
					mysqli_execute($stmt);
					$query = mysqli_stmt_get_result($stmt);
					if($query){

						if($query->num_rows > 0){

							while ($row = $query->fetch_assoc()) {
								$row['lyrics'] = str_replace(array('\n','\r'),"<br>", $row['lyrics']);
								$row['lyrics'] = str_replace("<br><br>","<br>", $row['lyrics']);
								$row['lyrics'] = str_replace("\\", "", $row['lyrics']);
								$data [] = $row;
							}

							return json_encode($data);
						}else{}

					}
				}

			}
		}

	###################
	#Events
		public function event_upload($array){
			//get Connection
			$conn = self::Connect();

			if(isset($array) & $array !== null){
				//Generate Event I / EIDD
				$EID = uniqid(date("HMESS"),true);

				$banner = $array[0];
				$title = $array[1];
				$host = $array[2];
				$description = $array[3];
				$start = $array[4];
				$end = $array[5];
				$uploader =$array[6];

				print_r($uploader);

				$SQL = "INSERT INTO `events` (`EID`, `banner`, `title`, `host`, `description`, `start_date`, `end_date`, `uploader`) VALUES (?,?,?,?,?,?,?,?) ;";

				$stmt = mysqli_stmt_init($conn);

				if(!mysqli_stmt_prepare($stmt,$SQL)){
					return ["faield",$stmt->error];
				}else{
					mysqli_stmt_bind_param($stmt,"ssssssss",$EID,$banner,$title,$host,$description,$start,$end,$uploader);
					mysqli_execute($stmt);
					$query = mysqli_stmt_get_result($stmt);
					return $query;
				}

			}

		}
		public function get_events(){
			//et Connection
			$conn = self::Connect();

			$SQL = "SELECT * FROM `events`;";
			$query = $conn->query($SQL);
			if($query){

				if($query->num_rows >0){

					while ($row = $query->fetch_assoc()) {
						$data [] = $row;
					}
					return json_encode($data);
				}
			}
		}

}

?>
