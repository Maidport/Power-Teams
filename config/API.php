<?php
require('controllers.php');

class api extends controller {

	public function access($_key,$Load,$_data){
		//get the connection
		$conn = self::Connect();
		$key = self::session($_SESSION['sess']);

		if($key){
			$_file = self::file();
			//begin by checking if the key is required
			if($_file['_api']['_key']=="yes"){
				//Validate the submited key with the system
				if(self::_interchange_key_handler($_key)){
					$requests = explode("/",$_file['_api']['search_control']['requests']);
					if(in_array($Load, $requests)){
						$table = "";
						for ($i=0; $i < sizeof($requests) ; $i++) {
							if(strtolower($Load)==$requests[$i]){
								//set the rable to select from using the index;
								$table = $requests[$i];
								break;
							}
						}
						//use the table result to index to a table
						if($table != null){
							$SQL = "SELECT * FROM `$table` ;";
							$stmt = mysqli_stmt_init($conn);
							if(!mysqli_stmt_prepare($stmt,$SQL)){
								return "Error";
							}else{
								
								mysqli_execute($stmt);
								$query = mysqli_stmt_get_result($stmt);
								if($query->num_rows >0){
									//Use the table variable to determine the arrangement of the data
									//Each table valriable will correspond index and matrix index in the _table_render_mapper object's _table_indecies/matricies object'
									/*
										Use:
										print_r($_file['_table_render_mapper']);
										To see the structure of the object
									*/
									//This will be done though a switch
									$_mapper = $_file['_table_render_mapper'];
									$_mapper_tables = explode("/",$_mapper['_tables']);

									if (in_array($table,$_mapper_tables)) {
										//access the indecies of the selected mapper table
										//get the table in the matricies index with the table name
										$_table_index = $_mapper['_table_indecies']['matricies']/*Select the table in the matricies as it corresponded to an index in the matricies list of indecies*/[$table];
										//get the table_matrix
										$_table_matrix = explode(",",$_table_index);
										//using the array of indecies
										while ($row = $query->fetch_array()) {
											$_array [] = $row;
										}
										//sort the data using the $_table_matrix list
										$_data_row = [];
										for ($i=0; $i < sizeof($_array) ; $i++) {
											//sort the data in the table
											for ($j=0; $j <sizeof($_table_matrix) ; $j++) {
												$_data_row[$i] [] = $_array[$i] [$_table_matrix[$j]] ;
											}
										}
										return json_encode($_data_row);
									}else{
										return "table not found";
									}
								}else{
									return "null";
								}
							}
						}else{
							return "request processing failed";
						}
					}else{ return "failed"; }

				}else{
					return json_encode(array('responce'=>"invalid user access key"));
				}
			}else{
				return json_encode(array('status'=>"Failed"));
			}
		}else{
			return "Key error";
		}
	}

	public function _data_indecies($_key,$_handle){
		//validate the key
		$conn = self::Connect();
		$_handle = strtolower($_handle);

		if(self::_interchange_key_handler($_key)){
			// Get the system init file contents
			$_file = self::file();
			$_table_render_mapper =$_file['_table_render_mapper'];
			$_tables = explode("/",$_table_render_mapper['_tables']);
			$matricies = explode(",",$_table_render_mapper['_table_indecies']['matricies'][$_handle]);
			return json_encode(array($_handle => $matricies));
		}else{
			return false;
		}
	}
	//Teams micro API will use this function / method to validate the key that the user is using to make API directed requests
	//this key simply makes use og the session method to get the master key/ $_session['sess'] value
	private function _interchange_key_handler($_key){
		if(isset($_key) & $_key != null){
			$master_key = self::session($_SESSION['sess'])[0];
			if (strrev($master_key)==$_key) {
				return true;
			}else{
				return false;
			}
		}else{}
	}
	///processing the request

	//File download procedure
	public function _download_file($FILE_ID){
		if($FILE_ID!= null){
			//get the connection
			$conn = self::Connect();

			//Set the SQL statemtn
			$SQL = "SELECT * FROM `_upload_files` WHERE `FID`=? ;";

			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt,$SQL)){
				return 01100;
			}else{
				mysqli_stmt_bind_param($stmt,"s",$FILE_ID);
				mysqli_execute($stmt);

				$query = mysqli_stmt_get_result($stmt);
				if($query){

					if($query->num_rows > 0){

						while($row=$query->fetch_assoc()){
							$data [] = $row;
						}
						return json_encode($data);
					}

				}
			}

		}else{

		}
	}

	//Update Issue 
	public function update_issue($_issue_id){
		if(isset($_issue_id)){
			//get connection
			$conn = self::Connect();
			//explode the issue ID toget the currrent state of the issue
			$issue = explode("@", $_issue_id);

			$state = $issue[1];

			if($state == 0){
				$_new_state = 1;
			}else{
				$_new_state = 0;
			}

			$SQL = "UPDATE `issues` SET `solved` = '$_new_state' WHERE `issues`.`issue_id` = '$issue[0]';";
			$query = $conn->query($SQL);
			return $query;

		}
	}

	//Event management and handling

	public function _event_read($event_id){
		//get connection
		session_start();
		$conn = self::Connect();

		if(isset($event_id)){
			//SQL statement
			$SQL = "SELECT * FROM `events` WHERE `EID`=? ;";

			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt,$SQL)){

			}else{
				mysqli_stmt_bind_param($stmt,"s",$event_id);
				mysqli_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);
				if($query){

					if ($query->num_rows > 0) {
						while ($row = $query->fetch_assoc()) {
							$data [] =$row;
						}
						return $data;
					}

				}
			}
		}

	}	
}

?>
