<div class="row">
<div class="col-md-1"></div>
<div class="col-md-6 equel-grid m-0">
  <div class="col-md-6">
    <div class="grid">
      <div class="grid-body">
        <h2 class="grid-title text-dark "> <i class="mdi mdi-harddisk mdi-2x text-dark" ></i> : Disk Usage <small><small class="text-dark"> GB </small></small></h2>
        <div class="item-wrapper">
          <canvas id="chartjs-doughnut-chart" width="600" height="400"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-lg-5 m-0 p-0">
  <div class="grid">
    <p class="grid-header text-dark">Server <i class="mdi mdi-server mdi-md text-dark" ></i></p>
    <div class="item-wrapper">
      <div class="table-responsive">
        <table class="table p-1">
          <thead>
            <tr>
              <th>Server <i class="fa fa-server fa-xs" ></i></th>
              <th>Host</th>
              <th>Arch</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody class="p-0">
            <tr>
              <td>
                <?php
                  echo explode("/", $_SERVER['SERVER_SOFTWARE'])[0];
                ?>
              </td>
              <td>
                <?php
                  if(isset($_SERVER['WINDIR'])){
                    echo 'Windows <i class="mdi mdi-windows mdi-md text-dark" ></i>';
                  }else{
                    echo 'Linux <i class="mdi mdi-linux  mdi-md text-dark" ></i>';
                  }
                ?>
              </td>
              <td>
                <?php
                  print_r(explode(" ", $_SERVER['SERVER_SOFTWARE'])[1]);
                ?>
              </td>
              <td> <span class="badge badge-success badge-md"> Online </span> </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="col-md-1"></div>

</div>
