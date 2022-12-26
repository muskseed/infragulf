<!DOCTYPE html>
<html>
<head>  
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= COMPANY_NAME; ?> | Setting List</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">

  <!-- PNotify -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/pnotify/pnotify.custom.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Sidebar of System -->
  <?php $this->load->view('admin_panel/common_file/sidebar'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Setting List
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>admin_panel/Dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Setting List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <!-- /.box -->

          <div class="box">
            <div class="box-header">

              <!-- <a href="<?php echo base_url(); ?>admin_panel/Products/frontend_view/add" class="btn btn-success" style="float: right;width: 100px;"><i class=""></i> Add</a> -->
            </div>

            <!-- /.box-header -->
            <div class="box-body" style="overflow-x:auto;">
              <?php
               //form open
                  $form_attributes = array('class' => 'form-horizontal', 'id' => 'setting_form', 'method' => 'post');

                  echo form_open_multipart('admin_panel/System_settings/form_action', $form_attributes);

               ?>
              <table id="country_list" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                  <th>Sr Number</th>
                  <th>Key</th>
                  <th>Values</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($system_data)){
                  $count = 1;
                  foreach ($system_data as $key => $value) {
                ?>
                <tr>
                  <td><?php echo $count; ?></td>
                  <td><?php echo strtoupper($value['key']); ?></td>
                  <td><input type="text" name="<?php echo strtolower($value['key']); ?>" value="<?php echo strtolower($value['value']); ?>"></td>
                </tr>
                <?php
                  $count++;
                  }
                } ?>
                </tbody>
              </table>
               <div class="row">
                  <!-- Button -->
                   <div class="form-group">
                     <label class="control-label"></label>
                     <div class="col-md-6 col-md-offset-6">
                       <button type="submit" class="btn btn-primary pull-right" >Send <span class="glyphicon glyphicon-send"></span></button>
                     </div>
                   </div>
                </div>

                <?php echo form_close(); ?>  
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Modal -->
  <div class="modal fade" id="orderNotesDisapproved" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Dis-approved Notes</h4>
        </div>
        <div class="modal-body">
          <?php
            $form_attributes = array('class' => 'form-horizontal', 'id' => 'addOrderNotes', 'method' => 'post','autocomplete'=>'off');

            echo form_open('admin_panel/Order/custom_disapproved_details', $form_attributes);

         ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group col-md-12">
                  <label class="col-md-4 control-label">Add Notes:<span style="color: red;">*</span></label>

                  <div class="col-md-8">
                    <textarea rows="4" cols="50" name="order_notes_val_det" id="order_notes_val_det"></textarea>
                    <span  id="order_details_error" style="color: red;"></span>
                    
                  </div>
                </div>
              </div>
            </div>
            <input type="hidden" name="order_id_dis" id="order_id_dis" value="">
         <?php echo form_close(); ?> 
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary pull-right" name="save_details" id="save_details" >Save<span class="glyphicon glyphicon-send"></span></button>
        </div>
      </div>
      
    </div>
  </div>
  <?php $this->load->view('admin_panel/common_file/common_footer'); ?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<!-- PNotify JQuery -->
<script src="<?php echo base_url(); ?>assets/pnotify/pnotify.custom.min.js"></script>


</body>
</html>
