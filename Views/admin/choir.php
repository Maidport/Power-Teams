<div class="row">
	<?php 
		$_choir = json_decode($server->get_choir()); 
	?>
	<hr class="featurette-divider bg-light text-light" >
	<div class="col-md-8 equel-grid">
		<div class="grid bg-dark text-light">
		  <div class="grid-body py-3">
		    <p class="card-title ml-n1 text-light">Choir Members <i class="fa fa-microphone fa-md" ></i> </p>
		  </div>
		  <div class="table-responsive text-light border border-success">
		    <table class="table table-strppied table-sm table-dark ">
		      <thead class="border-top text-light">
		        <tr class="solid-header ">
		          <th colspan="2" class="pl-4">Member</th>
		          <th>Role</th>
		          <th>Lyrics</th>
		        </tr>
		      </thead>
		      <tbody>
  	<?php
  		if(!empty($_choir) & $_choir !==null){
  			for($i = sizeof($_choir)-1;$i > -1;$i-- ){
  				//get user role
  				$role = json_decode($server->_user_roles($_choir[$i][7]),true);
  				if( $role[0]['value'] == 'admin'){
  					$role = '<i class="mdi mdi-star mdi-md text-warning" ></i>'.$role[0]['value'];
  				}else{
  					$role = $role[0]['value'];
  				}
  				echo '<tr>
				          <td class="pr-0 pl-4">
				            <img class="profile-img img-sm" src="img/'.$_choir[$i][6].'" alt="profile image">
				          </td>
				          <td class="pl-md-0">
				            <small class="text-white font-weight-medium d-block" style="text-transform: capitalize;">'.$_choir[$i][1]." ".$_choir[$i][2].'</small>
				            <span class="text-gray " style="text-transform: capitalize;">
				              <span class="status-indicator rounded-indicator small bg-success text-gray"></span>'.json_decode($server->_user_roles($_choir[$i][7]),true)[0]['value'].' </span>
				          </td>
				          <td>
				            <small class="text-light " style="text-transform: capitalize;">'.$role.'</small>
				          </td>
				          <td>'.sizeof(json_decode($server->_member_lyrics($_choir[$i][0]))).'</td>
				        </tr>';
  			}
  		}

  	?>        
		      </tbody>
		    </table>
		  </div>
		  <a class="border-top px-3 py-2 d-block text-light">
		    <small class="font-weight-medium text-light"><i class="mdi mdi-microphone mr-2"></i>The Choir Members list</small>
		  </a>
		</div>
	</div>

	<div class="col-md-4 equel-grid">
		<div class="grid bg-dark border border-gray">
		  <div class="grid-body">
		    <div class="split-header">
		      <p class="card-title has-icon text-white">Lyrics <i class="fa fa-edit fa-md text-light" ></i></p>
		      <div class="btn-group">
      	<?php
      		if($User[1]['team']=='choir'){
	  			echo'<span class="btn btn-light btn-rounded border border-light btn-xs component-flat py-2" aria-haspopup="true" aria-expanded="false">
			          <a class="btn has-icon p-0 py-2" href="#" data-toggle="modal" data-target="#Add_lyrics" > <i class="mdi mdi-microphone mdi-md text-dark" ></i> Add Lyrics </a>
			        </span>';
      		}
      	?>
		      </div>
		    </div>
		    <div class="vertical-timeline-wrapper">
		      <div class="timeline-vertical dashboard-timeline pl-1">

		      	<?php
		      		//get and display lyrics
		      		$_lyrics = json_decode($server->_get_lyrics(),true);
		      		if(!empty($_lyrics)){
		      			#print_r($_lyrics);
		      			for ($i=sizeof($_lyrics)-1; $i > -1 ; $i--) { 	
		      				//get uplaoder's full name
		      				$_lyric_upload = json_decode($server->_get_username($_lyrics[$i]['uploader']),true);
		      				#print_r($_lyric_upload);
							echo 
								'<div class="activity-log cursor-pointer" data-toggle="modal" data-target="#_read_lyrics" style="cursor:pointer;" onclick="_read_lyrics(\''.$_lyrics[$i]['LID'].'\')">
									<p class="log-name">'.$_lyrics[$i]['singer']." <b>:</b> ".$_lyrics[$i]['song'].'</p>
									<div class="log-details text-light"><i>'.$_lyric_upload['Firstname']." ".$_lyric_upload['Lastname'].'</i> Added a new song.
									</div>
								</div>';
		      			}
		      		}else{}
		      	?>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
</div>
<div class="modal fade" id="Add_lyrics">
	<div class="modal-dialog">
		<div class="modal-content bg-dark">
			<div class="modal-header">
				<table class="table">
					<thead class="text-light col-12 border-dark">
					    <th style="padding: 2px 5px;" class=" bg-dark" style="line-height: 50px;">
					      <img src="img/<?php echo $User[1]['photo']; ?>" width="50px" height="50px" class=" border border-primary" style="margin: 0px;border-radius: 50%; float: left;" >
					      <span style="margin-left:15px;height: 50px;display: table;line-height: 50px;font-size: 20px;" ><?php echo $User[1]['Firstname']." ".$User[1]['Lastname']; ?>
					  	  </span>
					    </th>
					</thead>
				</table>
			</div>
			<div class="modal-body">
				<form class="form form-group" action="" method="post" >
					<h4 class="featurette-header text-light text-center mb-2" > ADD LYRICS <span class="badge right has-icon" > <i class="mdi mdi-microphone mdi-md text-light" ></i> </span></h4>
					<div class="form-group">
						<input type="text" name="type" value="_upload_lyrics" hidden contenteditable="false" readonly>
						<input type="text" name="_song" placeholder="Song Title" required autocomplete class="form-control border border-success" >
					</div>
					<div class="form-group">
						<input type="text" name="_singer" placeholder="Song Artist" required autocomplete autofocus class="form-control border border-success" >
					</div>
					<div class="form-group">
						<textarea class="textarea success valid form-control border-success" name="_lyrics" placeholder="Write/Paste Lyrics..." required autofocus="" cols="12" rows="6" wrap contenteditable lang="en" height="100px" ></textarea>
						<input type="text" hidden name="time_peice" id="time_peice_2" class="form-control">
					</div>
					<div class="modal-footer">
						<button class="btn btn-success btn-xs btn-rounded has-icon" type="submit" > Submit <span class="mdi mdi-send mdi-xs" ></span></button>
						<button class="btn btn-warning btn-xs btn-rounded has-icon" type="button" > Clear <span class="mdi mdi-reload mdi-xs" ></span></button>
						<button class="btn btn-danger btn-xs btn-rounded has-icon" type="button" data-dismiss="modal"> Close <span class="mdi mdi-close mdi-xs" ></span></button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>

<!--Read lyrics-->

<div class="modal fade" id="_read_lyrics">
	<div class="modal-dialog" type="document">
		<div class="modal-content bg-dark text-light">
			<div class="modal-header">
					<h2 class="featurette-header text-center" id="_song_title" align="center"> </h2>
			</div>
			<div class="modal-body">
				<h3 class="featurette-header text-center" id="_singer_name"></h3>

				<p class="text-center border-top" id="_lyrics">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				</p>	
				<div class="col-md-12 border-top">
					<span class="badge badge-light right my-2" id="_upload_date"></span>
				</div>	
			</div>
			<div class="modal-footer">
				<div class="btn-group">
					<button class="btn btn-danger btn-sm has-icon btn-rounded" data-dismiss="modal" >
						Close <i class="mdi mdi-close mdi-md ml-1" ></i>
					</button>
				</div>
			</div>

		</div>
	</div>
</div>
