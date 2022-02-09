<?php

include(dirname(__FILE__)."/config/API.php");

$server = new api();
$data = $_POST;
if($data != null){

	switch ($data['type']) {
		case "issue_upload": 
			$_Issue_upload = $server->_add_issue($data);
			print_r(json_encode($_Issue_upload));
			break;
		case "_issue_load":
			$_issue = $server->_issue($data['_issue']);
			print_r($_issue);
			break;
		case 'disk_summary':
			$disk_summary [] = array('total' => disk_total_space("C:") ,'free'=>diskfreespace("C:"),'used'=> disk_total_space("C:") - diskfreespace("C:") );
			print_r(json_encode($disk_summary));
			break;
		case 'read_lyrics':
			$_lyrics = $server->_read_lyrics($data['LID']);
			print_r($_lyrics);
			break;
		case "update_issue":
			print_r($server->update_issue($data['IID']));
			break;
		case '_load_event':
			print_r(json_encode($server->_event_read($data['EID'])));
			break;
		case "_read_upload":
			print_r(json_encode($server->_read_upload($data['PID'])));
			break;
		default:
			# code...
			break;
	}

}else{

}

?>
