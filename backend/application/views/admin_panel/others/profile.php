<!DOCTYPE html>
<html>   
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= COMPANY_NAME; ?> | Profile Form</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- All CSS and JS File -->
  <?php $this->load->view('admin_panel/common_file/header'); ?>
  
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bower_components/select2/dist/css/select2.min.css">
  
</head> 
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <!-- Header and Sidebar Conent -->
  <?php $this->load->view('admin_panel/common_file/sidebar'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>admin_panel/Dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>admin_panel/Dashboard/profile">Profile Form</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Profile Form</h3>

         </div>
         <div class="box-body">

            <!-- Container of Form -->
               <?php
               //form open
                  $form_attributes = array('class' => 'form-horizontal', 'id' => 'contact_form', 'method' => 'post');

                  echo form_open(isset($edit_data[0]['id']) ? 'admin_panel/Dashboard/profile_action/'.$edit_data[0]['id'] : 'admin_panel/Dashboard/profile_action', $form_attributes);

               ?>
                <div class="row">

                  <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">Name:<span style="color: red;">*</span></label>

                    <div class="col-md-8">
                      <input type="text" class="form-control" name="full_name" id="full_name" value="<?php echo isset($edit_data[0]['full_name']) ? $edit_data[0]['full_name'] : ''; ?>" placeholder="Enter Full Name">
                    </div>
                  </div>

                  <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">Email ID:<span style="color: red;">*</span></label>

                    <div class="col-md-8">
                      <input type="text" class="form-control" name="email_id" id="email_id" value="<?php echo isset($edit_data[0]['email_id']) ? $edit_data[0]['email_id'] : ''; ?>" placeholder="Enter Email ID">
                    </div>
                  </div>
                </div>

                <div class="row">

                  <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">User Name:<span style="color: red;">*</span></label>

                    <div class="col-md-8">
                      <input type="text" class="form-control" name="username" id="username" value="<?php echo isset($edit_data[0]['username']) ? $edit_data[0]['username'] : ''; ?>" placeholder="Enter User Name">
                    </div>
                  </div>

                  <div class="form-group col-md-6">
                    <label class="col-md-4 control-label">Password:<span style="color: red;">*</span></label>

                    <div class="col-md-8">
                      <input type="text" class="form-control" name="password" id="password" value="<?php echo isset($edit_data[0]['password']) ? $edit_data[0]['password'] : ''; ?>" placeholder="Enter Password">
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <!-- Button -->
                   <div class="form-group">
                     <label class="control-label"></label>
                     <div class="col-md-6 col-md-offset-5">
                       <button type="submit" class="btn btn-primary pull-right" >Send <span class="glyphicon glyphicon-send"></span></button>
                     </div>
                   </div>
                </div>
               

              <?php echo form_close(); ?>          
          
        </div>
        <!-- /.box-body -->
        <!-- <div class="box-footer">
          Footer
        </div> -->
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

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

<?php $this->load->view('admin_panel/common_file/footer_script'); ?>

<!-- Select2 -->
<script src="<?php echo base_url(); ?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  });
</script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>

<script type="text/javascript">
     $(document).ready(function() {
    $('#contact_form').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {

            full_name: {
                validators: {
                    notEmpty: {
                        message: ' '
                    }
                }
            },
            email_id: {
                validators: {
                    notEmpty: {
                        message: ' '
                    }
                }
            },
            username: {
                validators: {
                    notEmpty: {
                        message: ' '
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: ' '
                    }
                }
            }
            }
        })
        .on('success.form.bv', function(e) {
            $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#contact_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });
});
</script>

</body>
</html>
