<!DOCTYPE html>
<html>   
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= COMPANY_NAME; ?> | Assign Category</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- All CSS and JS File -->
  <?php $this->load->view('admin_panel/common_file/header'); ?>
  
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">
  
  <!-- category  -->
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2019.1.115/styles/kendo.common-material.min.css" />
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2019.1.115/styles/kendo.material.min.css" />
    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2019.1.115/styles/kendo.material.mobile.min.css" />

    <script src="https://kendo.cdn.telerik.com/2019.1.115/js/jquery.min.js"></script>
    <script src="https://kendo.cdn.telerik.com/2019.1.115/js/kendo.all.min.js"></script>
  
</head> 
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <?php $selected_data    = json_encode($selected_data); ?>    
    <?php $select_id        = json_encode($select_id); ?>    
  <!-- Header and Sidebar Conent -->
  <?php $this->load->view('admin_panel/common_file/sidebar'); ?>
  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $this->session->userdata('module_name'); ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>admin_panel/Dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url(); ?>admin_panel/Users">Assign Order</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
         <div class="box-header with-border">
            <h3 class="box-title">Assign Order</h3>

         </div>
         <div class="box-body">

                <!-- <div class="row"> -->
                    <div class="demo-section k-content">
                        <div id="dialog">
                            <div class="dialogContent">
                                <input id="filterText" type="text" placeholder="Search categories" />
                                <div class="selectAll">
                                    <input type="checkbox" id="chbAll" class="k-checkbox" onchange="chbAllOnChange()" />
                                    <label class="k-checkbox-label" for="chbAll">Select All</label>
                                    <span id="result">0 categories selected</span>
                                </div>
                                <div id="treeview"></div>
                            </div>
                        </div>
                        <select id="multiselect"></select>
                        <br />
                        <button id="openWindow" class="k-primary">SELECT CATEGORIES</button>
                    </div>
                <!-- </div> -->
                
                <div class="row">
                  <!-- Button -->
                   <div class="form-group">
                     <label class="control-label"></label>
                     <div class="col-md-6 col-md-offset-5">
                        <a href="#" id="category" class="btn btn-primary pull-right">Send <span class="glyphicon glyphicon-send"></span></a>
                     </div>
                   </div>
                </div>
                     
          
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

<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/category/dist/tree-multiselect.js"></script>
<script type="text/javascript">
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  });
</script>
<!-- <script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script> -->
<script type="text/javascript">
    $(document).ready(function () {
        var selected_data   = <?php echo $selected_data; ?>;
        var select_id       = <?php echo $select_id; ?>;
        // select_id           = JSON.parse(select_id);
        var treeView_select = $("#treeview").data("kendoTreeView");
        getCheckedNodes(treeView_select.dataSource.view(), selected_data);
        populateMultiSelect(selected_data);
        setCheckedNodes(treeView_select.dataSource.view(),selected_data,select_id);
        setMessage(selected_data.length);

        function setCheckedNodes(nodes, checkedNodes,select_id) {
            var node;
            for (var i = 0; i < nodes.length; i++) {
                node = nodes[i];
                

                if (select_id.indexOf(node.id) != -1) {
                // console.log('select');    
                    nodes[i].set("checked", 'true');
                }

                // if (node.hasChildren) {
                //     setCheckedNodes(node.children.view(), checkedNodes,select_id);
                // }
            }
        }

    });
</script>
<script>
        var selectNodes;
        var jsonData = <?php echo $tree_view; ?>;
        var myDataSource = new kendo.data.HierarchicalDataSource({
            data: jsonData
        });

        $("#multiselect").kendoMultiSelect({
            dataTextField: "text",
            dataValueField: "id"
        });

        $("#treeview").kendoTreeView({
            loadOnDemand: false,
            checkboxes: {
                checkChildren: true
            },
            dataSource: myDataSource,
            check: onCheck,
            expand: onExpand
        });

        $(document).ready(function () {
            var dialog = $("#dialog");
            var multiSelect = $("#multiselect").data("kendoMultiSelect");
            $("#openWindow").kendoButton();

            multiSelect.readonly(true);

            $("#openWindow").click(function () {
                dialog.data("kendoDialog").open();
                $(this).fadeOut();
            });

            dialog.kendoDialog({
                width: "400px",
                title: "Categories",
                visible: false,
                actions: [
                  {
                      text: 'Cancel',
                      primary: false,
                      action: onCancelClick
                  },
                  {
                      text: 'Ok',
                      primary: true,
                      action: onOkClick
                  }
                ],
                close: onClose
            }).data("kendoDialog").open();
        });

        function onCancelClick(e) {
            e.sender.close();
        }

        function onOkClick(e) {
            var checkedNodes = [];
            var treeView = $("#treeview").data("kendoTreeView");

            getCheckedNodes(treeView.dataSource.view(), checkedNodes);
            populateMultiSelect(checkedNodes);

            e.sender.close();
        }

        function onClose() {
            $("#openWindow").fadeIn();
        }

        function populateMultiSelect(checkedNodes) {
            var multiSelect = $("#multiselect").data("kendoMultiSelect");
            multiSelect.dataSource.data([]);

            var multiData = multiSelect.dataSource.data();
            if (checkedNodes.length > 0) {
                var array = multiSelect.value().slice();
                for (var i = 0; i < checkedNodes.length; i++) {
                    multiData.push({ text: checkedNodes[i].text, id: checkedNodes[i].id });
                    array.push(checkedNodes[i].id.toString());
                }

                multiSelect.dataSource.data(multiData);
                multiSelect.dataSource.filter({});
                multiSelect.value(array);
            }
        }

        function checkUncheckAllNodes(nodes, checked) {
            // console.log(checked);
            for (var i = 0; i < nodes.length; i++) {
                nodes[i].set("checked", checked);

                if (nodes[i].hasChildren) {
                    checkUncheckAllNodes(nodes[i].children.view(), checked);
                }
            }
        }

        function chbAllOnChange() {
            var checkedNodes = [];
            var treeView = $("#treeview").data("kendoTreeView");
            var isAllChecked = $('#chbAll').prop("checked");

            checkUncheckAllNodes(treeView.dataSource.view(), isAllChecked)

            if (isAllChecked) {
                setMessage($('#treeview input[type="checkbox"]').length);
            }
            else {
                setMessage(0);
            }
        }

        function getCheckedNodes(nodes, checkedNodes) {
            var node;
            // console.log(checkedNodes);
            selectNodes = checkedNodes;
            for (var i = 0; i < nodes.length; i++) {
                node = nodes[i];
                // console.log(node);
                if (node.checked) {
                    checkedNodes.push({ text: node.text, id: node.id });
                }

                if (node.hasChildren) {
                    getCheckedNodes(node.children.view(), checkedNodes);
                }
            }
        }

        function onCheck() {
            var checkedNodes = [];
            var treeView = $("#treeview").data("kendoTreeView");
            // console.log(checkedNodes);
            getCheckedNodes(treeView.dataSource.view(), checkedNodes);
            setMessage(checkedNodes.length);
        }

        function onExpand(e) {
            if ($("#filterText").val() == "") {
                $(e.node).find("li").show();
            }
        }

        function setMessage(checkedNodes) {
            var message;

            if (checkedNodes > 0) {
                message = checkedNodes + " categories selected";
            }
            else {
                message = "0 categories selected";
            }

            $("#result").html(message);
        }

        $("#filterText").keyup(function (e) {
            var filterText = $(this).val();

            if (filterText !== "") {
                $(".selectAll").css("visibility", "hidden");

                $("#treeview .k-group .k-group .k-in").closest("li").hide();
                $("#treeview .k-group").closest("li").hide();
                $("#treeview .k-in:contains(" + filterText + ")").each(function () {
                    $(this).parents("ul, li").each(function () {
                        var treeView = $("#treeview").data("kendoTreeView");
                        treeView.expand($(this).parents("li"));
                        $(this).show();
                    });
                });
                $("#treeview .k-group .k-in:contains(" + filterText + ")").each(function () {
                    $(this).parents("ul, li").each(function () {
                        $(this).show();
                    });
                });
            }
            else {
                $("#treeview .k-group").find("li").show();
                var nodes = $("#treeview > .k-group > li");

                $.each(nodes, function (i, val) {
                    if (nodes[i].getAttribute("data-expanded") == null) {
                        $(nodes[i]).find("li").hide();
                    }
                });

                $(".selectAll").css("visibility", "visible");
            }
        });
    </script>
    <script type="text/javascript">
        $("#category").click(function(){
            var base_url = '<?= base_url(); ?>';
            var user_id = "<?php echo $this->uri->segment(4); ?>";
            // console.log(user_id);
            $.ajax({
                url: base_url+'admin_panel/Users/assign_category/',
                type: "POST",
                data: {user_id:user_id,data:selectNodes},
                dataType: "html",
                success: function(result){
                    if(result == 1){
                        window.location.replace(base_url+"admin_panel/Users");
                    }else{
                        window.location.replace(base_url+"admin_panel/Dashboard");
                    }  
                }
            });
        });
    </script>
    <style>
        html .k-dialog .k-window-titlebar {
            padding-left: 17px;
        }

        .k-dialog .k-content {
            padding: 17px;
        }

        #filterText {
            width: 100%;
            box-sizing: border-box;
            padding: 6px;
            border-radius: 3px;
            border: 1px solid #d9d9d9;
        }

        .selectAll {
            margin: 17px 0;
        }

        #result {
            color: #9ca3a6;
            float: right;
        }

        #treeview {
            height: 300px;
            overflow-y: auto;
            border: 1px solid #d9d9d9;
        }

        #openWindow {
            min-width: 180px;
        }
    </style>
</body>
</html>
