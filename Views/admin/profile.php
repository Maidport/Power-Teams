<div class="container-fluid">
	<div class="row p-0 m-0">
		<div class="col-md-12">
			<div class="card bg-dark" style="width:300px;margin-right: auto;margin-left: auto;">
				<div class="card-header">
						<img class="profile-img img-md img-rounded" height="180px" src="img/<?php echo $User[1]['photo']; ?>" alt="profile image" >
						<?php echo $User[1]['Firstname']." ".$User[1]["Lastname"]; ?>

						<i class="mdi mdi-dots-vertical mdi-lg mt-2" data-toggle="modal" data-target="#profile_img_options" style="float: right;"></i>
				</div>
				<img class="card-top-img" height="180px" src="img/<?php echo $User[1]['photo']; ?>" alt="profile image">
				<div class="card-body p-0">
					<div class="table-responsive p-0 m-0">
						<table class="table tale-dark p-1 m-0" style="text-transform: capitalize;" >
							<tr>
								<td class="text-light px-1 text-right" ><b>First Name:</b></td>
								<td class="text-light" ><b><?php echo $User[1]['Firstname']; ?></b></td>
							</tr>
							<tr>
								<td class="text-light px-1 text-right" ><b>Surname:</b></td>
								<td class="text-light" ><b><?php echo $User[1]['Lastname']; ?></b></td>
							</tr>
							<tr>
								<td class="text-light px-1 text-right" ><b>E-mail:</b></td>
								<td class="text-light" ><b><?php echo $User[1]['EmailAddress']; ?></b></td>
							</tr>
							<tr>
								<td class="text-light px-1 text-right" ><b>Team:</b></td>
								<td class="text-light" ><b><?php echo $User[1]['team']; ?></b></td>
							</tr>
							<tr>
								<td class="text-light px-1 text-right" ><b>Role:</b></td>
								<td class="text-light" ><b><?php echo json_decode($server->_user_roles($User[1]['role']),true)[0]['value']; ?></b></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="card-footer border border-top">
					<div class="btn-group">
						<button class="btn btn-primary btn-xs btn-rounded border-light text-light has-icon" data-toggle="modal" data-target="#edit_profile">
							<i class="mdi mdi-pen mdi-xs" ></i> Edit Profile
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Profile details Edit-->
<div class="modal fade" id="edit_profile">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header p-1">
				<h4 class="grid-title text-dark p-1 my-0" >
					<img class="profile-img img-md img-rounded" height="180px" src="img/<?php echo $User[1]['photo']; ?>" alt="profile image"> Edit Profile
				</h4>
			</div>
			<form class="modal-body p-4" method="post">
				<div class="form-group">
					<input type="text" name="type" value="profile_edit" hidden>
					<input type="text" name="Firstname" class="form-control border-border-success" autocomplete="" placeholder="Firstname : <?php echo $User[1]['Firstname'];?>" value="<?php echo $User[1]['Firstname'];?>" >
				</div>
				<div class="form-group">
					<input type="text" name="Lastname" class="form-control border-border-success" autocomplete="" placeholder="Lastname : <?php echo $User[1]['Lastname'];?>" value="<?php echo $User[1]['Lastname'];?>" >
				</div>
				<div class="form-group">
					<label class="email_notice text-dark" ><small><small class="text-dark" style="font-size: 10px;">Changing your Email Address will require you to login again.</small></small></label>
					<input type="text" name="email" class="form-control border-border-success" autocomplete="" placeholder="E-mail Address : <?php echo $User[1]['EmailAddress'];?>" value="<?php echo $User[1]['EmailAddress'];?>" >
				</div>
				<div class="form-group">
					<input type="text" name="username" class="form-control border-border-success" autocomplete="" placeholder="Username: <?php echo $User[1]['Username'];?>" value="<?php echo $User[1]['Username'];?>" >
				</div>
				<label class="password_check text-dark" >Password <small><small class="text-dark" style="font-size: 10px;" id="pwd_msg">Retype Old Password Or Enter New Password</small></small></label>
				<div class="form-group">
					<input type="password" name="pwd_1" id="pwd_1" class="form-control border-border-success" autocomplete="" placeholder="Password" required>
				</div>
				<div class="form-group">
					<input type="password" name="pwd_2" id="pwd_2" class="form-control border-border-success" autocomplete="" placeholder="Retype Password" required onfocus="password_pre_submition_check()">
				</div>
				<div class="btn-group">
					<button class="btn btn-success btn-xs btn-rounded has-icon" type="Submit" role="button" >
						Submit
						<i class="mdi mdi-send mdi-xs ml-2" ></i>
					</button>
					<button class="btn btn-danger btn-xs btn-rounded has-icon" type="button" role="button" data-dismiss="modal" >
						Close
						<i class="mdi mdi-close mdi-xs ml-2" ></i>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--Profile image preview-->

<div class="modal fade" id="profile_img_options">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-dark">
				<img class="profile-img img-md img-rounded" height="180px" src="img/<?php echo $User[1]['photo']; ?>" alt="profile image">
				Check Profile Image
			</div>
			<form class="modal-body form" enctype="multipart/form-data" method="post">
				<div class="form-group">
					<div class="col-md-12 showcase_content_area">
						<input type="text" name="type" value="profile_img_change" hidden>
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="customFile" name="my_file" accept="image/*" file_extensions=".png,.jpg,.jpeg,.gif">
							<label class="custom-file-label" for="customFile">Choose file</label>
						</div>
					</div>
				</div>
				<button class="btn btn-success btn-xs has-icon btn-rounded" type="submit" > Change <i class="mdi mdi-send mdi-xs"></i> </button>
				<button class="btn btn-danger btn-xs has-icon btn-rounded" type="button" data-dismiss="modal" >Close <i class="mdi mdi-close mdi-xs" ></i></button>
			</form>
		</div>
	</div>
</div>