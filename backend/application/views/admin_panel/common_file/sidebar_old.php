<?php 
$access_permission_list = $this->db->query('SELECT m.module_name FROM module AS m LEFT JOIN access_permission AS a ON m.id = a.module_id WHERE a.usertype_id='.$this->session->userdata('usertype_id'))->result_array();
$module_name = array_column($access_permission_list, 'module_name');
?>
<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url(); ?>admin_panel/Dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b></b>IG</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Infra</b>Gulf</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <a href="<?php echo base_url(); ?>admin_panel/Dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b></b>IG</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo BRAND_NAME ?></b> </span>
    </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- Notifications: style can be found in dropdown.less -->
          
          <!-- Tasks: style can be found in dropdown.less -->
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url(); ?>assets/logo.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $this->session->userdata('username'); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url(); ?>assets/logo.png" class="img-circle" alt="User Image">

                <p>
                 <?php echo $this->session->userdata('username'); ?> - <?php echo $this->session->userdata('designation'); ?>
                  <!-- <small>Member since Nov. 2012</small> -->
                </p>
              </li>
              <!-- Menu Body -->
               <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url(); ?>admin_panel/Dashboard/profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo base_url(); ?>admin_panel/Dashboard/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      
      <!-- search form -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- <li class="header">MAIN NAVIGATION</li> -->
        <?php if(in_array('Dashboard', $module_name)){ ?>
        <li class="active">
          <a href="<?php echo base_url(); ?>admin_panel/Dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <?php } ?>  
          
        <li class="treeview">
            <?php if(in_array('Property_type', $module_name)){ ?>
              <a href="#">
                <i class="fa fa-location-arrow"></i>
                <span>Masters</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
            <?php } ?>
              <ul class="treeview-menu">
                  <?php if(in_array('Property_type', $module_name) || in_array('Region', $module_name) || in_array('Project_features', $module_name)){ ?> 
                    <li><a href="<?php echo base_url(); ?>admin_panel/Property_type"><i class=""></i>Property Type</a></li>
                  <?php } if(in_array('Region', $module_name)){ ?> 
                    <li><a href="<?php echo base_url(); ?>admin_panel/Region"><i class=""></i>Region</a></li>
                  <?php } ?>
                  <?php if(in_array('Project_features', $module_name)){ ?> 
                    <li><a href="<?php echo base_url(); ?>admin_panel/Project_features"><i class=""></i>Project Features</a></li>
                  <?php }?>
                  <?php if(in_array('Amenities', $module_name)){ ?> 
                    <li><a href="<?php echo base_url(); ?>admin_panel/Amenities"><i class=""></i>Amenities</a></li>
                  <?php }?>
              </ul>
        </li>

        <?php if(in_array('Team', $module_name)){ ?>
          <li class="">
            <a href="<?php echo base_url(); ?>admin_panel/Team">
              <i class="fa fa-users"></i>
              <span>Team</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
        <?php } ?>

        <?php if(in_array('Client_reviews', $module_name)){ ?>
          <li class="">
            <a href="<?php echo base_url(); ?>admin_panel/Client_reviews">
              <i class="fa fa-users"></i>
              <span>Client Reviews</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
        <?php } ?>

        <?php if(in_array('Products', $module_name)){ ?>
          <li class="">
            <a href="<?php echo base_url(); ?>admin_panel/Products">
              <i class="fa fa-folder"></i>
              <span>Property</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
        <?php } ?>

        <?php if(in_array('Registration', $module_name)){ ?>
          <li class="">
            <a href="<?php echo base_url(); ?>admin_panel/Registration">
              <i class="fa fa-folder"></i>
              <span>New Enquiry</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
        <?php } ?>

        <?php if(in_array('Sell_registration', $module_name)){ ?>
          <li class="">
            <a href="<?php echo base_url(); ?>admin_panel/Sell_registration">
              <i class="fa fa-folder"></i>
              <span>Sell Registration</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
        <?php } ?>

        <?php if(in_array('Projects', $module_name)){ ?>
          <li class="">
            <a href="<?php echo base_url(); ?>admin_panel/Projects">
              <i class="fa fa-folder"></i>
              <span>Projects</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
        <?php } ?>

        <?php if(in_array('Off_plan', $module_name)){ ?>
          <li class="">
            <a href="<?php echo base_url(); ?>admin_panel/Off_plan">
              <i class="fa fa-folder"></i>
              <span>Off Plan</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
        <?php } ?>

        <?php if(in_array('Office_staff', $module_name) && $_SESSION['usertype_id'] == 1){ ?>
          <li class="">
            <a href="<?php echo base_url(); ?>admin_panel/Office_staff">
              <i class="fa fa-folder"></i>
              <span>Office Staff</span>
              <span class="pull-right-container">
              </span>
            </a>
          </li>
        <?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>