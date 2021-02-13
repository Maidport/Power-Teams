<div class="container px-0 py-0">
	<?php

		$teams = ['technical','choir','mc'];
		$_User_team = $User[1]['team'];
		if(in_array($_User_team, $teams)){
			switch ($_User_team) {
				case 'mc':
					echo    '<div class="row">
								<div class="col-md-6 mb-2 py-1">
									<button class="btn btn-primary btn-xs btn-rounded has-icon aria-haspopup" data-toggle="modal" data-target="#_event_add" > Add Event <i class="mdi mdi-plus mdi-xs ml-1 aria-expanded" ></i> </button>
								</div>
							</div>';
					break;		
				default:
					# code...
					break;
			}
		}

	?>
	<div class="row pt-1 px-1">
		<div class="col-md-1"></div>
		<div class="col-md-10 equel-grid" >
			<div class="grid" style="background-color: transparent;">
				<div class="grid-body py-3 bg-success">
					<p class="card-title ml-n1 text-light has-icon">Event List <span> <i class="mdi mdi-calendar mdi-md" ></i> <i class="mdi mdi-clock mdi-md" ></i> </span> </p>
				</div>
				<div class="table-responsive bg-success">
					<table class="table table-hover table-sm table-dark">
						<thead>
							<tr class="solid-header">
								<th colspan="2" class="pl-4">Event</th>
								<th>Title</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$events = json_decode($server->get_events(),true);
								if($events){
									if(sizeof($events)>0){
										for($i = sizeof($events)-1;$i > -1;$i-- ){
											echo'<tr>
													<td class="pr-0 pl-4">
														<img class="profile-img img-sm" src="'.$events[$i]['banner'].'" alt="Event image">
													</td>
													<td class="pl-md-0">
														<small class="text-black font-weight-medium d-block text-light">Host : '.$events[$i]['host'].'</small>
														<span class="text-gray">
															<span class="status-indicator rounded-indicator small bg-primary"></span>
															<button class="btn btn-primary btn-xs btn-rounded" data-toggle="modal" data-target="#_read_event" onclick="load_event(\''.$events[$i]['EID'].'\')" >View <i class="mdi mdi-eye mdi-xs ml-1" ></i></button>
														</span>
													</td>
													<td>
														<small>'.$events[$i]['title'].'</small>
													</td>
													<td>'.$events[$i]['start_date'].'</td>
												</tr>';

										}
									}
								}
							?>				
						</tbody>
					</table>
				</div>
				<a class="border-top px-3 py-2 d-block text-gray bg-success" href="#">
				<small class="font-weight-medium"><i class="mdi mdi-chevron-down mr-2"></i>View All Event</small>
				</a>
			</div>
		</div>
		<div class="col-md-1"></div>
	</div>
</div>

<div class="modal fade" id="_read_event">
	<div class="modal-dialog">
		<div class="modal-content bg-dark">
			<div class="modal-header">
				<h4 class="featurette-header text-center" >
					Event Preview
				</h4>
			</div>
			<div class="modal-body border-top border-success">
				<div class="row">
					<div class="col-md-12">
						<img src="" class="carousel-item bg-light" id="_banner" alt="Event image" style="width: 100%; height: 200px; display: table;">
					</div>
					<div class="col-md-12">
						<div class="container">
							<h2 class="featurette-header text-center" id="_title">Title : ajdlkjalskd</h2>
							<h5 class="featurette-header text-left" id="_host">Host : laksjdlkajslkd</h5>
							<p class="card-text py-2 px-2 mt-1 border-top border-light" id="_description">
							</p>
						</div>
					</div>
					<div class="col-md-12 featurette-divider p-0 m-0">
						<hr class="p-0 my-2 bg-light" >
					</div>
					<div class="col-md-6 col-xs-6 my-0 py-0">
						<div class="card-body my-0 py-0">
							Start
							<br class="p-0 m-0" >
							<span class="badge badge-md badge-success border-light" id="_start_date">15-09-2019 16:00:00</span                                                                                                                                                                                >
						</div>
					</div>
					<div class="col-md-6 col-xs-6 my-0 py-0">
						<div class="card-body my-0 py-0">
							End
							<br class="p-0 m-0" >
							<span class="badge badge-md badge-black border border-light bg-black" id="_end_date">19-09-2019 13:30:00</span>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer border-top-light">
			<?php
				if($User[1]['team']){
			?>
				<!-- <button type="submit" class="btn btn-warning btn-xs btn-rounded has-icon" > Edit <i class="mdi mdi-pen mdi-xs ml-1" ></i></button> -->
			<?php } ?>
				<button type="button" class="btn btn-danger btn-xs btn-rounded has-icon" data-dismiss="modal">Close <i class="mdi mdi-close mdi-xs ml-1" ></i></button>
			</div>
		</div>
	</div>
</div>

<!--Event Addition modal-->
<div class="modal fade" id="_event_add">
	<div class="modal-dialog" type="dialog">
		<div class="modal-content bg-dark">
			<div class="modal-header">
				<div class="grid-body p-0">
					<div class="card-title p-2">
						<h3 class="bg-dark text-light" > <i class="mdi mdi-plus-circle mdi-lg text-light" ></i> Event  </h3>
					</div>
				</div>
			</div>
			<form class="modal-body form form-group bg-dark" method="post" id="_event_form" enctype="multipart/form-data">
				<div class="grid p-0 bg-dark">
					<input type="text" name="type" value="_add_event" class="form-control" readonly="true" hidden="true">
					<div class="form-group">
						<input type="text" name="event_title" class="form-control" required autocomplete placeholder="Event Title" >
					</div>
					<div class="form-group">
						<input type="text" name="event_host" class="form-control" required autocomplete placeholder="Event Host" >
					</div>
					<div class="form-inline row">
						<div class="col-md-1"></div>
						<div class="form-group col-md-4">
							Start Date <i class="input-frame"></i>
							<input class="form-control" name="start_date" type="date" required>
						</div>
						<div class="col-md-1" ></div>
						<div class="form-group col-md-4">
							End Date <i class="input-frame"></i>
							<input class="form-control" name="end_date" type="date" required placeholder="dd/mm/yyy hh:mm:ss">
						</div>
					</div>
					<div class="form-group my-2">
						<textarea class="form-control textarea valid border-success" cols="12" rows="3" name="description" placeholder="Event Descrition"></textarea>
					</div>
					<div class="row showcase_row_area mb-3">
						<div class="col-md-12 showcase_text_area">
							<label>Event Attachment Image</label>
						</div>
						<div class="col-md-12 showcase_content_area">
							<div class="custom-file">
								<input type="file" class="custom-file-input input-xs" name="file" id="customFile">
								<label class="custom-file-label label-xs" for="customFile">Choose file</label>
							</div>
						</div>
					</div>
				</div>
				<button class="btn btn-success btn-xs btn-rounded has-icon" type="submit" > Submit <i class="mdi mdi-paper-plane mdi-xs ml-1" ></i> </button>
				<button class="btn btn-danger btn-xs btn-rounded has-icon aria-haspopup" type="button" data-dismiss="modal"> Close <i class="mdu mdi-close mdi-xs ml-1" ></i> </button>
			</form>
		</div>
	</div>
</div>