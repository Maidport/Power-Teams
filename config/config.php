<?php

class config {

	protected function Connect(){
		$file = dirname(__FILE__)."/init.json";
		if(file_exists($file) & file_get_contents($file) !== null){
			$decode = json_decode(file_get_contents($file),true);
			$server = $decode['server'];
			if($server != null){
				$host = $server['host'];
				$username = $server['username'];
				$password  = $server['password'];
				$database = $server['database'];

				$conn = new mysqli($host,$username,$password,$database);
				if(!$conn){
					return die($conn->error_reporting())."Connection failed";
				}else{
					return $conn;
				}
			}
		}else{}
	}

	//Session Handler to return user details Everytime a user switchs or reloads a page or requests a diffrent page
	protected function sessionHandler($sessID){
		if($sessID != ""){
			//Get database connection
			$conn = self::Connect();
			//Get into the database table loop and hash though all the emails and find a match and get its details
			$SQL = "SELECT * FROM `users`;";

			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt,$SQL)){
				session_destroy();
				return 0;
			}else{
				mysqli_execute($stmt);
				$query= mysqli_stmt_get_result($stmt);
				if($query){
					if($query->num_rows > 0){
						while($row = mysqli_fetch_assoc($query)){
							$user = $row;

							if(self::Hasher('sess',$user['EmailAddress'])==$sessID){
								return [$sessID,$user];
								break;
							}
						}
					}
				}else{
				}
			}
		}else{
		}
	}

	//Hashing handler function
	protected function Hasher($use,$text){
		if(isset($use)){
			switch ($use) {
				case 'pwd':
					//reverse the hash
					$hash = strrev(md5($text));
					return $hash;
					break;
				case 'sess':
					//Hash the reverse of the string
					$hash = md5(strrev($text));
					return $hash;
					break;
				case "upload":
					$hash = uniqid(md5(date("HMsDnyyy")),true);
					break;
				case "issue":
					$hash = uniqid(md5(date("HMsDnyyyy"))."_issue",false);
					break;
				default:
					# code...
					break;
			}
			return $hash;
		}
	}
	
	//Handle regular user Registration
	protected function SignupHandler($array){
		if(sizeof($array)>4){
			$conn = self::Connect();
			
			$Fname = $array[0];
			$Lname = $array[1];
			$Email = $array[2];
			$username = $array[3];
			$pwd = self::Hasher('pwd',$array[4]);
			//get and prepare the team name
			$team = self::_team_name($array[5])['team'];
			$role = $array[6];
			$photo = $array[7];
			$Tid = $array[8];

			if($photo==01100){
				$photo = 01100;
			}else{
			}
			//Generate UID
			$UID = random_int(0,99999999);
			#$SQL = "INSERT INTO `users`(`UID`,`FirstName`,`LastName`,`Username`,`EmailAddress`,`Password`,`DOB`,`photo`)VALUES (?,?,?,?,?,?,?);";

			$conn = self::Connect();
			$SQL = "INSERT INTO `users` (`UID`, `FirstName`, `LastName`, `EmailAddress`, `Username`, `Password`,`team`,`role`, `photo`,`Tid`) VALUES (?,?,?,?,?,?,?,?,?,?);";

			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt,$SQL)){
				return "Preparation failed";
			}else{
				mysqli_stmt_bind_param($stmt,"ssssssssss",$UID,$Fname,$Lname,$Email,$username,$pwd,$team,$role,$photo,$Tid);
				mysqli_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);
				$responce = array('result'=>'success');
				return json_encode($responce);
			}
		}else{
		}
	}
	//get team name
	private function _team_name($TID){
		$conn = self::Connect();
		$tid = strtolower($TID);
		if(strlen($tid)>5){
			//SQL
			$SQL = "SELECT * FROM `teams` WHERE `TID`=? ;";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt,$SQL)){
				print_r("Failed");
			}else{
				mysqli_stmt_bind_param($stmt,"s",$tid);
				mysqli_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);

				if($query){
					if($query->num_rows > 0){

						while ($row = $query->fetch_assoc()) {
							$team = $row;
						}
						return $team;

					}
				}
			}
		}
	}

	//Handle Regular user login
	protected function loginHandler($array){

		if(isset($array) & $array !=null){

			//Get the connection
			$conn = self::Connect();

			$UsernameEmail = $array[0];
			$pwd = self::Hasher('pwd',$array[1]);

			for ($i=0; $i < strlen($UsernameEmail) ; $i++) {
				if($UsernameEmail[$i]=='@'){
					$type = "EmailAddress";
					break;
				}else{
					$type = "Username";
				}
			}

			$SQL = "SELECT * FROM `users` WHERE `$type` = ? AND `Password`= ? ;";

			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt,$SQL)){
				return "Preparation failed";
			}else{
				mysqli_stmt_bind_param($stmt,"ss",$UsernameEmail,$pwd);
				mysqli_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);

				$counter = mysqli_num_rows($query);
				if($counter>0 & $counter<2){
					while($row = mysqli_fetch_assoc($query)){
						$user = $row;
					}
					$_SESSION['sess'] = self::Hasher('sess',$user['EmailAddress']);

					return [$_SESSION,$user];
				}else{
					return "Failed";
				}
			}
		}else{
			return "ret:Loginfailed";
		}
	}
}
?>
