<!DOCTYPE html>
<html>
<head>  
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= COMPANY_NAME; ?> | Team List</title>
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
        Staff List
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>admin_panel/Dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Staff List</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <a href="#" class="btn btn-danger" id="delete_all" style="width: 100px;"><i class=""></i> Delete All</a>
              <a href="<?php echo base_url(); ?>admin_panel/office_staff/frontend_view/add" class="btn btn-success" style="float: right;width: 100px;"><i class=""></i> Add</a>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="country_list" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                  <th><input type="checkbox" id="flowcheckall" value="" /></th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Designation</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
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

<!-- page script -->
 <script type="text/javascript">
  $(document).ready(function() {
      oTableStaticFlow = $('#country_list').DataTable({
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
          "ajax": {
              url : "<?php echo base_url("admin_panel/office_staff/frontend_list") ?>",
              type : 'POST'
          },
          "aoColumnDefs": [{
              'bSortable': false,
              'aTargets': [0]
          }],
      });
  });

  $("#flowcheckall").click(function () {
      //$('#flow-table tbody input[type="checkbox"]').prop('checked', this.checked);
      var cols = oTableStaticFlow.column(0).nodes(),
          state = this.checked;
      
      for (var i = 0; i < cols.length; i += 1) {
        cols[i].querySelector("input[type='checkbox']").checked = state;
      }
  });

  $(document).on('click', '#delete_all', function () {

    var delete_id = [];
    $('input[name="check_id"]:checked').each(function() {
       delete_id.push(this.value);
    });  
    if (delete_id.length === 0) {
        alert('Please select one Staff');
    }else{
      if (confirm("Are you sure?")) {
        $.ajax({
          url : "<?php echo base_url("admin_panel/office_staff/delete_all") ?>",
          type: "POST",
          data: {delete_id : delete_id},
          dataType: "json",
          success: function(results){
            if(results.status == 'success'){
              window.location = "<?php echo base_url('admin_panel/office_staff') ?>";
            }else{
              alert(results.msg);
            }
          }
        });
      }
    }
  });
</script>

<!-- PNotify -->
<script type="text/javascript">
  $(document).ready(function(){
    <?php if ($this->session->flashdata('success')) { ?>
      new PNotify({
          title: 'Success!',
          text: 'Team member Added Succesfully',
          type: 'success'
      });
    <?php } ?>
    <?php if ($this->session->flashdata('error')) { ?>
      new PNotify({
          title: 'Error!',
          text: 'Something Went Wrong',
          type: 'error'
      });
    <?php } ?>
  });
</script>
</body>
</html>
