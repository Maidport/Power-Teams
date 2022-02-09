<?php
require(dirname(__FILE__)."/config/controllers.php");
$server = new controller();

//$_POST related functions and controls
$data = $_POST;
if(isset($_COOKIE)){
	if(isset($_COOKIE['_front'])){
		$_SESSION['sess'] = strrev($_COOKIE['_front']);
	}
}

//test space
if(isset($data) & $data !=null){
	if(isset($_SESSION) & $_SESSION !=null){
		if(!empty($_SESSION['sess'])){
			$SESS = $_SESSION['sess'];
			$User = $server->Session($SESS);
			$_SESSION['sess'] = $User[0];
		}
	}else{
		$User = "";
	}
	$type = $data['type'];
	switch ($type) {
		case 'login':
			$User = $server->login([$data['Username'],$data['pwd']]);
			
			//setting cookie
			$week = new DateTime("+1 week");
			if(isset($data['remember_me']) & $User !== null){
				setcookie('_key',strrev($User[0]['sess']),$week->getTimestamp(),"/",null,null,true);
				#setcookie('_key',strrev($User[0]['sess']),$week->getTimestamp(),"/");
			}

            if($User != "Failed"){
                $View = $server->View('dashboard');
				setcookie('_front',strrev($User[0]['sess']),$week->getTimestamp(),"/",null,null,false);
            }else{
            	redirect();
            }
			break;
		case '_add_user':
			$firstname = $data['fName'];
			$lastname = $data['lName'];
			$username = $data['username'];
			$email = $data['email'];
			$pwd1 = $data['pwd1'];
			$pwd2 = $data['pwd2'];
			$team = $data['team'];
			$role = $data['role'];
			//get the role 
			$_roles = json_decode($server->_team_roles($team),true);
			for($i=0;$i<sizeof($_roles);$i++){
				if(in_array($role, $_roles[$i])){
					$_item = $_roles[$i];
					break;
				}
			}
			//set the role to value of $_item index ['role']
			if($_item){
				$role = $_item['role'];
			}

			$_img = $_FILES['photo'];
			//upload the profile image
			if($_img['error']==0){
				//get file type and extension
				$_final_dir = "user/";

				$type_ext = explode("/",$_img['type']);
				if($type_ext[0]=='image'){
					//prepare new file name
						//Max size
						$size =  2740779;
					//check size
					if($_img['size']<= $size){
						//new file name
						$new_name = implode("~",explode(".",uniqid(date("hmsttDT"),true)));

						$profile_image = $_final_dir.$new_name.".".$type_ext[sizeof($type_ext)-1];

						$upload_result = move_uploaded_file($_img['tmp_name'],"img/".$profile_image );
					}
				}
			}else{}
			if($upload_result){
				$_profile_img = $profile_image;
			}else{
				$_profile_img = "upload";
			}
			$_result = $server->_add_user([$firstname,$lastname,$email,$username,$pwd1,$team,$role,$_profile_img,$team]);
			break;
		case "_upload":
			$title = $data['title'];
			$upload_category = $data['category'];
			$text = $data['text'];
			$time = $data['time_peice'];
			//Check if the $_FILE Global Variable is set or not
			if(isset($_FILES) & $_FILES != null){
				//upload the file
				$attachment = Media($upload_category,$_FILES);
			}else{
				$attachment = "";
			}
			//check the value of attachment
			if(!empty($attachment) & $attachment !== ""){
				$attachment = $attachment;
			}else{
				$attachment = "";
			}
			//Execute the upload 
			//Method location : [controllers.php]
			$upload_result = $server->_upload([$upload_category,$title,$text,$time,$attachment,$User[1]['UID']]);
			print_r($upload_result);

			break;
		case '_upload_lyrics':
			$_lyrics_upload = $server->_upload_lyrics($data,$User[1]['UID']);
			print_r($_lyrics_upload);
			break;
		case "_add_event":
			$uploader = $server->Session($SESS)[1]['UID'];
			print_r($uploader);
			$title = $data['event_title'];
			$host = $data['event_host'];
			$event_description = $data['description'];
			$start = $data['start_date'];
			$end = $data['end_date'];

			//upload the image attachment

			$_attachment = $_FILES['file'];
			if ($_attachment['error'] !== 1) {
				//get the file ext
				$_ext = explode(".", $_attachment['name']);
				$ext = $_ext[sizeof($_ext)-1];
				$attachment_name = implode("_",explode(".",uniqid(md5("$title")."@".$title,true))).".".$ext;
				$dir = "media/image/";
				$attachment_upload_name = $dir.$attachment_name;
				print_r($attachment_upload_name);
				move_uploaded_file($_attachment['tmp_name'], $attachment_upload_name);
			}
			$_event_result = $server->event_upload([$attachment_upload_name,$title,$host,$event_description,$start,$end,$uploader]);
			print_r($_event_result);

			break;
		
		//Profile Details Change Start
		case 'profile_img_change':
			//Goto controller.php line
			//Delete the current profile image
			$delete = unlink("img/".$User[1]['photo']);
			if($delete){
				//set the role to value of $_item index ['role']
				$_img = $_FILES['my_file'];
				//upload the profile image
				if($_img['error']==0){
					//get file type and extension
					$_final_dir = "user/";
					$type_ext = explode("/",$_img['type']);
					if($type_ext[0]=='image'){
						//prepare new file name
							//Max size
							$size =  2740779;
						//check size
						if($_img['size']<= $size){
							//new file name
							$new_name = implode("~",explode(".",uniqid(date("hmsttDT"),true)));

							$profile_image = $_final_dir.$new_name.".".$type_ext[sizeof($type_ext)-1];

							$upload_result = move_uploaded_file($_img['tmp_name'],"img/".$profile_image );
						}
					}
				}else{}
				if($upload_result){
					$_profile_img = $profile_image;
				}else{
					$_profile_img = "upload";
				}
				$_img_change = $server->_profile_Image_change($User[1]['UID'],$profile_image);	
			}
			break;
		case 'profile_edit':
			#print_r($data);
			$firstname = $data['Firstname'];
			$lastname = $data['Lastname'];
			$Email = $data['email'];
			$username = $data['username'];
			$pwd_1 = $data['pwd_1'];
			$pwd_2 = $data['pwd_2'];
			if($pwd_1=$pwd_2){
				//Send datato the execution method
				$User_update = $server->user_update([$firstname,$lastname,$Email,$username,$pwd_1,$User[1]['Password'],$User[1]['UID']]);
				print_r($User_update);
				$week = new DateTime("+1 week");
				unset($_COOKIE);
				unset($_COOKIE);
				setcookie('_front',strrev($_SESSION['sess']),$week->getTimestamp(),"/",null,null,false);
			}
			break;
		//Profile Details Change END
		case "Reassign":
			print($server->Reassign($data['RID']));
			break;
		default:
			# code...
			break;
	}
}else{
	if(isset($_SESSION) & $_SESSION !=null){
		$SESS = $_SESSION['sess'];
		$User = $server->Session($SESS);
		$_SESSION['sess'] = $User[0];
	}else{
		$User = "";
	}
}


//Control and load Views and locations throught the $_GET
if(isset($_GET) & $_GET !=null){
	if(isset($_SESSION) & $_SESSION !=null){
		$url = explode("/", $_GET['url']);
		//Check for logout action
		if($url[0]=='logout'){
			session_unset();
			$_SESSION = null;
			//delete or destroy the cookie 
			unset($_COOKIE['_key']);
			unset($_COOKIE['_front']);

			session_destroy();

			$protocol ="HTTP";
			$HTTP_HOST = $_SERVER['HTTP_HOST'];
			$site = "power-teams.herokuapp.com";

			$link = $protocol."://".$HTTP_HOST."/".$site;
			$_SESSION['msg'] = "Requested Page not found. Reverted to default Page";

			header("Location: $link");
		}
		//Explode buy a ?

		//Check sizeof the explode and take the right rought as the processing and loading a view
		if(sizeof($url)<2){
			if($_GET['url']=="dashboard"||$_GET['url']=="home"||$_GET['url']=='index'){
				$page = "dashboard";
			}
			else{
				$page = $_GET['url'];
			}

			$_explode = explode("_", $_GET['url']);

			if(sizeof($_explode)<2){
				$View = $server->View($_explode[0]);
			}else{
				$View = $server->View($_explode[0]);
				$_SESSION['View_command'] = array('View_name'=>$_explode[0],'command'=>$_explode[1]);
			}
		}else{
			$protocol ="HTTP";
			$HTTP_HOST = $_SERVER['HTTP_HOST'];
			$site = "power-teams.herokuapp.com";

			$link = $protocol."://".$HTTP_HOST."/".$site;
			$_SESSION['msg'] = "Requested Page not found. Reverted to base page...";
			header("Location: $link/$url[0]");
		}
	}else{
		$View = "Failed";
	}
}else{
	if(isset($_SESSION) & $_SESSION!=null){
		$View = $server->View('index');
	}else{
		//Cookie consumption to support session
		if(isset($_COOKIE)){
			if(isset($_COOKIE['_key'])){
				#print_r("Found");
				$__key = $_COOKIE['_key'];
				$User = $server->Session(strrev($__key));
				$_SESSION['sess'] = $User[0];
				#print_r($User);
			}
		}else{
			$protocol ="HTTP";
			$HTTP_HOST = $_SERVER['HTTP_HOST'];
			$site = "power-teams.herokuapp.com";

			$link = $protocol."://".$HTTP_HOST."/".$site;
			$_SESSION['msg'] = "Requested Page not found. Reverted to base page...";
			header("Location: $link/$url[0]");
		}
	}
}

function Media($category,$array){
	//Steps
	/*
		1). check for upload error
		2). check if the file requires and application or not
		3). get the sub-location for upload from the system configuration file
		4). create the upload location
		5). create a unique name for the file by concatinating the originatl name with the new name.
		5). upload the file while retaining the file name to return the caller to be uploaded to the database
	*/
	if(!empty($category) & $array != null){
		$data = $array['my_file'];
		//check for upload errors
		if($data['error']==0){
			$_name = $data['name'];
			$_size = $data['size'];
			$_tmp_name = $data['tmp_name'];
			//instance of the main class
			$_main = new controller();
			$_file = $_main->file()['_file_upload'];
			$_type = _upload_location(explode("/",strtolower($data['type'])),$_file);
			//Prepare the file name
			$_new_name = _upload_name($_name,$_type);
			if($_new_name != null){
				//upload the file to the Directory produced
				if(move_uploaded_file($_tmp_name, $_new_name)){
					return $_new_name;
				}
			}
		}else{
			return "";
		}
	}else{}
}

//prepare the _sub_location
function _upload_location($_file_type,$_init_data){
	$_type = $_file_type[0];
	$_data = $_file_type[1];
	if($_file_type != null & $_init_data !==null){
		if($_type=="application"){
			$_sub_location = $_init_data['valid_file_types'][$_type][$_data];
		}else{
			$_permitted_file_ext_list = explode("/",$_init_data['valid_file_types'][$_type]);
			if(in_array($_data, $_permitted_file_ext_list)){
				$_sub_location = $_type;
			}else{
				$_sub_location = "unknown";
			}
		}
		if($_sub_location !==null||$_sub_location!=="unknown"){
			//get the master folder
			$_location = $_init_data['_location']."/".$_sub_location;
			return $_location;
		}else{
			return null;
		}
	}else{
		return null;
	}
}

//generate the upload file _name
function _upload_name($_original_file_name,$_sub_location){
	if($_original_file_name !== null & $_sub_location != null){
		//explode the file name to saperate the name from the ext
		$_name = explode(".", $_original_file_name);
		$file_ext =  $_name[sizeof($_name)-1];
		//remove the period from the name and replace with a character
		$_uniq_name = implode( "@",explode(".",uniqid($_name[0],true)));
		return $_sub_location."/".$_uniq_name.".".strtolower($file_ext);
	}else{}
}

if($User == null){
	redirect();
}

function redirect(){
	$protocol ="HTTP";
	$HTTP_HOST = $_SERVER['HTTP_HOST'];
	$site = "power-teams.herokuapp.com";
	$link = $protocol."://".$HTTP_HOST."/".$site;
	$_SESSION['msg'] = "Requested Page not found. Reverted to base page...";
	header("Location: $link/$url[0]");
}

?>
