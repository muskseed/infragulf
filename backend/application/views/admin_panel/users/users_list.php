<!DOCTYPE html>
<html>
<head>  
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= COMPANY_NAME; ?>| User List</title>
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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">   
  <style type="text/css">
    .content{
      min-height: 140px !important;
    }

    .box{
          padding: 5px 5px 10px 5px;
    }
  </style>
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
        Customers List
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>admin_panel/Dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Customers List</li>
      </ol>
    </section>
    <?php 
    $time       = strtotime("-1 year", time());
    $from_date  = date("Y-m-d", $time);
    ?>
    <section class="content">
        <div class="box">
          <div class="row">
            <div class="col-md-12">

                <div class="col-md-2">
                  <strong>From Date</strong><br>
                  <input type="text" class="form-control" name="from_date" id="from_date" value="<?php echo $from_date ?>" placeholder="Enter From date">
                </div> 

                <div class="col-md-2">
                  <strong>To Date</strong><br>
                  <input type="text" class="form-control" name="to_date" id="to_date" value="<?php echo date('Y-m-d'); ?>" placeholder="Enter To date">
                </div> 

                <div class="col-md-2">
                  <strong>User Type</strong><br>
                  <select name="user_type" id="user_type" class="form-control selectpicker user_type">
                    <option value="0">Select User Type</option>
                    <?php foreach ($usertype_data as $key => $value) {
                      echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';
                    } ?>
                  </select>
                </div> 
            </div>
          </div>
        <br>
        <div class="row">
          <div class="col-md-12">
           
           <div class="col-md-4">
            <a href="javascript:void(0);" id="search" class="btn btn-primary">Search</a>
           </div>  
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <a href="#" class="btn btn-danger" id="delete_all" style="width: 100px;"><i class=""></i> Delete All</a>
              <a href="<?php echo base_url(); ?>admin_panel/Users/frontend_view/add" class="btn btn-success" style="float: right;width: 100px;"><i class=""></i> Add</a>
            </div>

            <!-- /.box-header -->
            <div class="box-body" style="overflow-x:auto;">
              <table id="country_list" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                  <th><input type="checkbox" id="flowcheckall" value="" /></th>
                  <th>Full Name</th>
                  <th>Mobile Number</th>
                  <th>Email ID</th>
                  <th>User Type</th>
                  <th>User Status</th>
                  <th>Products in Cart</th>
                  <th>Product Assign</th>
                  <th>Cart Status</th>
                  <th>Action</th>
                  <th>Delete</th>
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

<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<!-- page script -->
  <script>
     $(function() {
        $( "#from_date").datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#to_date").datepicker({ dateFormat: 'yy-mm-dd' });
     });
  </script>
 <script type="text/javascript">
  $(document).ready(function() {
      load_data();
  });

  $("#search").click(function(){
    load_data();
  })

  function load_data(){
    var from_date   = $("#from_date").val();
    var to_date     = $("#to_date").val();
    var user_type   = $("#user_type").val();

    oTableStaticFlow = $('#country_list').DataTable({
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
      "bDestroy": true,
        "ajax": {
            url : "<?php echo base_url("admin_panel/Users/frontend_list") ?>",
            type : 'POST',
            data: {
                from_date: from_date , to_date : to_date , user_type : user_type
            },
        },
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [0]
        }],
    });
  }
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
        alert('Please select one Users');
    }else{
      if (confirm("Are you sure?")) {
        $.ajax({
          url : "<?php echo base_url("admin_panel/Users/delete_all") ?>",
          type: "POST",
          data: {delete_id : delete_id},
          dataType: "json",
          success: function(results){
            if(results.status == 'success'){
              window.location = "<?php echo base_url('admin_panel/Users') ?>";
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
          text: 'User Added Succesfully',
          type: 'success'
      });
    <?php } ?>
    
    <?php if ($this->session->flashdata('error')) { ?>
      new PNotify({
          title: 'Error!',
          text: 'User Name Already Exist',
          type: 'error'
      });
    <?php } ?>
    <?php if ($this->session->flashdata('sms_sent')) { ?>
      new PNotify({
          title: 'Success!',
          text: 'SMS Sent Succesfully',
          type: 'success'
      });
    <?php } ?>
  });
</script>
</body>
</html>
