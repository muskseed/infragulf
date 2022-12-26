<!DOCTYPE html>
<html>
<head>  
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= COMPANY_NAME; ?> | Property List</title>
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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">  

  <!-- JS Tree -->
  <link rel="stylesheet" href="https://static.jstree.com/3.0.9/assets/dist/themes/default/style.min.css">

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
        Property List
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>admin_panel/Dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Property List</li>
      </ol>
    </section>


    <?php 
    $from_date       = date('Y-m-d' ,strtotime("-3 month"));
    // $from_date  = '2020-01-01';
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
                  <strong>Business Type</strong><br>
                  <select name="business_type" id="business_type" class="form-control selectpicker business_type">
                      <option value="">Select Property Type</option>
                      <option value="buy">Buy</option>
                      <option value="rent">Rent</option>
                  </select>
                </div> 

            </div>
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
              
              <a href="#" class="btn btn-danger" id="bulk_delete" style="float: right;width: 100px;"><i class=""></i> DELETE</a>
              <a href="<?php echo base_url(); ?>admin_panel/Products/frontend_view/add" class="btn btn-success" style="float: right;"><i class=""></i> ADD</a>
            </div>

            <!-- /.box-header -->
            <div class="box-body" style="overflow-x:auto;">
              <table id="country_list" class="table table-bordered table-striped table-hover country_list">
                <thead>
                <tr>
                  <th><input type="checkbox" id="flowcheckall" value="" /></th>
                  <th>Property Title</th>
                  <th>Price</th>
                  <th>Sq Ft</th>
                  <th>Location</th>
                  <th>Region</th>
                  <th>Images</th>
                  <th>Created</th>
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
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Category</h4>
        </div>
        <div class="modal-body">
          <div class="container">
          <div class="row">
            <div id="jstree-tree" class="well col-sm-3"></div>
            <div id="jstree-result" class="col-sm-6">Selected Category</div>  
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
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
<script src="<?php echo base_url(); ?>assets/jstree/jstree.min.js"></script>

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

  $("#from_date , #to_date , #business_type").change(function(){
    load_data();
  })

  function load_data(){
    var from_date   = $("#from_date").val();
    var to_date     = $("#to_date").val();
    var business_type   = $("#business_type").val();

    oTableStaticFlow = $('#country_list').DataTable({
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
      "bDestroy": true,
        "ajax": {
            url : "<?php echo base_url("admin_panel/Products/frontend_list") ?>",
            type : 'POST',
            data: {
                from_date: from_date , to_date : to_date , business_type : business_type
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
</script>

<!-- PNotify -->
<script type="text/javascript">
  $(document).ready(function(){
    <?php if ($this->session->flashdata('success') == 'yes') { ?>
      new PNotify({
          title: 'Success!',
          text: 'Property Added Succesfully',
          type: 'success'
      });
    <?php } ?>
    <?php if ($this->session->flashdata('error') == 'no') { ?>
      new PNotify({
          title: 'Error!',
          text: 'Something Went Wrong',
          type: 'error'
      });
    <?php } ?>
  });
</script>

<script type="text/javascript">
  $(document).on('click', '#bulk_delete', function () {

    var delete_id = [];
    $('input[name="check_id"]:checked').each(function() {
       delete_id.push(this.value);
    });  
    if (delete_id.length === 0) {
        alert('Please select one Products');
    }else{
      $.ajax({
        url : "<?php echo base_url("admin_panel/Products/delete_bulk_products") ?>",
        type: "POST",
        data: {delete_id : delete_id},
        dataType: "json",
        success: function(results){
          // console.log(results.status);
          if(results.status == 'success'){
            window.location = "<?php echo base_url('admin_panel/Products') ?>";
          }else{
            alert(results.msg);
          }
        }
      });
    }
  });
</script>

<script type="text/javascript">
  $(document).on('click', '#product_active', function () {

    var delete_id = [];
    $('input[name="check_id"]:checked').each(function() {
       delete_id.push(this.value);
    });  
    if (delete_id.length === 0) {
        alert('Please select one Products');
    }else{
      $.ajax({
        url : "<?php echo base_url("admin_panel/Products/product_active") ?>",
        type: "POST",
        data: {delete_id : delete_id},
        dataType: "json",
        success: function(results){
          // console.log(results.status);
          if(results.status == 'success'){
            window.location = "<?php echo base_url('admin_panel/Products') ?>";
          }else{
            alert(results.msg);
          }
        }
      });
    }
  });

  $(document).on('click', '#product_deactive', function () {

    var delete_id = [];
    $('input[name="check_id"]:checked').each(function() {
       delete_id.push(this.value);
    });  
    if (delete_id.length === 0) {
        alert('Please select one Products');
    }else{
      $.ajax({
        url : "<?php echo base_url("admin_panel/Products/product_deactive") ?>",
        type: "POST",
        data: {delete_id : delete_id},
        dataType: "json",
        success: function(results){
          // console.log(results.status);
          if(results.status == 'success'){
            window.location = "<?php echo base_url('admin_panel/Products') ?>";
          }else{
            alert(results.msg);
          }
        }
      });
    }
  });

  $(document).on('click', '#delete_all', function () {

    var delete_id = [];
    $('input[name="check_id"]:checked').each(function() {
       delete_id.push(this.value);
    });  
    if (delete_id.length === 0) {
        alert('Please select one Products');
    }else{
      if (confirm("Are you sure?")) {
        $.ajax({
          url : "<?php echo base_url("admin_panel/Products/delete_all_products") ?>",
          type: "POST",
          data: {delete_id : delete_id},
          dataType: "json",
          success: function(results){
            if(results.status == 'success'){
              window.location = "<?php echo base_url('admin_panel/Products') ?>";
            }else{
              alert(results.msg);
            }
          }
        });
      }
    }
  });
</script>
<script type="text/javascript">
  var jsonData = <?php echo $tree_view; ?>;
  $('#jstree-tree')
    .on('changed.jstree', function (e, data) {
      if (data.node.children.length > 0) {
          $('#jstree-tree').jstree(true).deselect_node(data.node);                    
          // $('#jstree-tree').jstree(true).toggle_node(data.node);                    
      }
      else
      {
        var base_url = '<?= base_url(); ?>';
        var objNode = data.instance.get_node(data.selected);
        $('#jstree-result').html('Selected: <br/><strong>' + objNode.id+'-'+objNode.text+'</strong>');
        $('#category_id').val(objNode.id);
        $('#category_val').val(objNode.text);
        $.ajax({
          url: base_url+'admin_panel/Products/get_code/'+objNode.id,
          type: "POST",
          data: {},
          dataType: "html",
          success: function(result){
            result = result.trim();  
            $("#collection_sku_code").val(result);
            // $('#contact_form').bootstrapValidator('revalidateField', 'collection_sku_code');
          }
        });
      }
    })
    .jstree({
    core: {
      data: jsonData
    }
  });

  $(document).on('click', '.print_qr_code', function () {
    var sku_code = $(this).attr("data-sku");
    var gross_weight = $(this).attr("data-gross_weight");
    var net_weight = $(this).attr("data-net_wt");
    var less = $(this).attr("data-less");
    var amount = $(this).attr("data-amount");
    var url = 'https://chart.googleapis.com/chart?chs=90x90&cht=qr&chl='+sku_code+'&choe=UTF-8';
    // console.log(sku_code);
    // console.log(gross_weight);
    var design = '<strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'+sku_code+'<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Gross-Wt &nbsp- &nbsp&nbsp'+gross_weight+'<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Less &nbsp- &nbsp&nbsp'+less+'<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Net-Wt &nbsp- &nbsp&nbsp'+net_weight+' <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Amount &nbsp- &nbsp&nbsp'+amount+'';
    var win = window.open('');
    win.document.write('<img src="' + url + '" style="margin: -5 0 0 5px" onload="window.print();window.close()" /><p style="margin: -80px -35px 0 90px;font-size: 16px;">'+design+'</p>');
    win.focus();
  })

  $(document).on('click', '#download_qr', function () {

    var delete_id = [];
    $('input[name="check_id"]:checked').each(function() {
    delete_id.push(this.value);
    });  
    if (delete_id.length === 0) {
        alert('Please select one Products');
    }else{
    if (confirm("Are you sure?")) {
        $.ajax({
        url : "<?php echo base_url("admin_panel/Products/download_qr_file") ?>",
        type: "POST",
        data: {delete_id : delete_id},
        dataType: "json",
        success: function(results){
            if(results.status == 'success'){
            var download_url = "<?php echo base_url('admin_panel/Products/download_qrcode_file') ?>";
            var win = window.open(download_url, '_blank');
            if (win) {
                win.focus();
            } else {
                alert('Please allow popups for this website');
            }
            }else{
            alert(results.msg);
            }
        }
        });
    }
    }
  });
  </script>
</body>
</html>
