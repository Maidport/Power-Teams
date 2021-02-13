<div class="container-fluid" stle="padding:0px;margin:0px;width:100%;text-align:center;display:table;">
  <div class="btn-group mb-2" data-toggle="buttons">
    <label class="btn btn-success btn-rounded btn-xs" data-toggle="modal" data-target="#_member_add" >
      Add Member
      <input type="radio" name="options" id="ADD_member" checked="">
      <i class="mdi mdi-account-plus"></i>
    </label>
  </div>
</div>

<div class="grid">
  <p class="grid-header bg-dark">Teams Table (<i class="mdi mdi-account-multiple" ></i>) </p>
  <div class="item-wrapper">
    <div class="table-responsive bg-success">
      <table class="table table-hover table-dark table-striped">
        <thead>
          <tr>
            <th>Member</th>
            <th>E-mail</th>
            <th>Team</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $_team = json_decode($server->user_team($User[1]['Tid']),true);
            $team_role = json_decode($server->_team_roles($User[1]['Tid']),true);
            for ($i=0; $i < sizeof($_team); $i++) {  ?>
               <tr>
                <td class="d-flex align-items-center border-top-0">
                  <img class="profile-img img-sm img-rounded mr-2" src="img/<?php echo $_team[$i]['photo']; ?>" alt="profile image">
                  <span><?php echo $_team[$i]['Firstname']." ".$_team[$i]['Lastname']; ?></span>
                </td>
                <td>
                  <?php echo $_team[$i]['EmailAddress']; ?>
                </td>
                <td>
                  <?php echo $_team[$i]['team']; ?>
                </td>
                <td class="text-success">
                  <?php
                    if(json_decode($server->_user_roles($_team[$i]['role']),true)[0]['value']=="admin" && "admin" == json_decode($server->_user_roles($User[1]['role']),true)[0]['value']){
                      echo '<div class="btn btn-rounded social-btn btn-github">
                              <i class="mdi mdi-account-circle"></i>
                              '.json_decode($server->_user_roles($_team[$i]['role']),true)[0]['value'].
                            '</div>';
                    }else{
                      echo '<div class="btn btn-rounded social-btn btn-github"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="mdi mdi-account-circle"></i>
                              '.json_decode($server->_user_roles($_team[$i]['role']),true)[0]['value'].
                            '</div>';
                      echo '<div class="dropdown-menu dropdown-menu-top">';
                        for ($j=0; $j < sizeof($team_role); $j++) { 
                          echo '<a class="dropdown-item p-1 link" onclick=\'r("'.$team_role[$j]['role']."@".strrev($_team[$i]['UID']).'")\' href="#">Assign to ('.$team_role[$j]['value'].')</a>';
                        }
                      echo '</div>';
                    }
                  ?>
                </td>
              </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="_member_add">
  <div class="modal-dialog">
    <div class="modal-content bg-dark">
      <div class="modal-header bg-dark">
        <h3 class="featurette-header text-center" > Add New Member <i class="mdi mdi-account-plus"></i></h3>
      </div>
      <form class="modal-body bg-dark" method="post" action="" enctype="multipart/form-data" >
        <input type="text" name="type" value="_add_user" hidden readonly autocomplete="OFF">
        <div class="grid-body">
          <div class="item-wrapper">
            <div class="form-group">
              <input type="text" name="fName" id="firstname" placeholder="First Name" required autocomplete="OFF" class="form-control" />
            </div>
            <div class="form-group">
              <input type="text" name="lName" id="lastname" placeholder="Last Name" required autocomplete="OFF" class="form-control" />
            </div>
            <div class="form-group">
              <input type="text" name="username" id="username" placeholder="Username" required autocomplete="ON" class="form-control" />
            </div>
            <div class="form-group">
              <input type="email" name="email" id="email" placeholder="Email Address" required autocomplete="OFF" class="form-control" />
            </div>
            <div class="form-group">
              <input type="password" name="pwd1" id="_pwd1" placeholder="Password" required autocomplete="OFF" class="form-control" />
            </div>
             <div class="form-group">
              <input type="password" name="pwd2" id="_pwd2" placeholder="Password Verify" required autocomplete="OFF" class="form-control" />
            </div>
            <div class="form-group">
              <input type="team" name="team" id="_teams" value="<?php echo  $User[1]['Tid']; ?>" placeholder="Assigned Team" required autocomplete="OFF" class="form-control" readonly="" />
            </div>
            <div class="form-group">
              <label for="_role" class="label"> Assign User Role : </label>
              <select type="role" name="role" id="_role" placeholder="User Role" required class="form-control text-dark" >
              <?php
                //get the user role associated with this team
                $_user_roles = json_decode($server->_team_roles($User[1]['Tid']),true);
                print_r($_user_roles);
                for($i=0;$i<sizeof($_user_roles);$i++){
                  echo "<option value='".$_user_roles[$i]['role']."' class='text-dark' >".$_user_roles[$i]['value']."</option>";
                }
              ?>
              </select>
            </div>
            <div class="row showcase_row_area mb-3 mt-4">
              <div class="col-md-3 showcase_text_area">
                <label>Profile Photo</label>
              </div>
              <div class="col-md-12 showcase_content_area">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFile" name="photo">
                  <label class="custom-file-label" for="customFile">Choose file (Max.size 3MB)</label>
                </div>
              </div>
            </div>
            <hr class="featurette-divider bg-success"/>
            <button type="submit" class="btn btn-xs btn-primary btn-rounded">Submit <span class="icon"><i class="fa fa-paper-plane fa-md" ></i></span> </button>
            <button data-dismiss="modal" type="button" class="btn btn-xs btn-danger btn-rounded">Close <span class="icon"><i class="fa fa-close fa-md" ></i></span> </button>
          </div>
        </div>
      </form>
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
