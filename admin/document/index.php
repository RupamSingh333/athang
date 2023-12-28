<?php 
include("../../system_config.php");
include_once("../common/head.php");
$rows_list = getdocument_byList();
?>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
  <?php include_once("../common/left_menu.php");?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>View All Document </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo SITEPATH;?>admin/dashboard.php"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">View All Category</li>
      </ol>
    </section>
    <section class="content">
      <h1 align="center" style="color: #337ab7;"><?php echo $_SESSION['msg']; unset($_SESSION['msg']);?></h1>
      <div class="table-responsive" style="overflow-x: auto;">
        <table id="exportable" align="center" class="table table-bordered table-condensed table-hover">
          <thead>
            <tr>
              <td><strong>Sr no</strong></td>
              <td><strong>Sample File</strong></td>
              <td><strong>Original File</strong></td>
               <td><strong>Category</strong></td>
              <td><strong>Document  Title</strong></td>
              <td><strong>Record Count</strong></td>
              <td><strong>Price</strong></td>
              <td><strong>Description</strong></td>
              <td><strong>Create Date</strong></td>
              <?php if($r['user_type']=="1")
			{ ?>
              <td><strong>Action</strong></td>
              <?php }?>
            </tr>
          </thead>
          <tbody>
            <?php 
$i=1;
foreach ($rows_list as $rows) { 
$parts=explode(",",$rows['p_cat']);
$resvvv = getCategory_byID($rows['cat_id']);


?>
            <tr>
              <td><?php echo $i; ?></td>
              <td ><a href="<?php  echo SITEPATH;?>/upload/document_sample/<?php  echo $rows['document_sample']; ?>">Sample</a></td>
               <td ><a href="<?php  echo SITEPATH;?>/upload/document_file/<?php  echo $rows['document_file']; ?>">Original File</a></td>
               <td ><?php  echo $resvvv['cat_name']; ?></td>
              <td ><?php  echo $rows['document_name']; ?></td>
              <td ><?php  echo $rows['count']; ?></td>
              <td ><?php  echo $rows['price']; ?></td>
               <td ><?php  echo $rows['document_description']; ?></td>
              <td ><?php echo $rows['document_startfrom']; ?></td>
              <?php if($r['user_type']=="1")
			{ ?>
              <td id="font12" width="20%"><?php if( $per['categories']['edit']==1 ){?>
                <a href="<?php  echo SITEPATH;?>/admin/action/document.php?action=status&id=<?php echo  urlencode(encryptIt($rows['document_id'])); ?>"<?php if($rows['document_status']=="0"){ ?> onMouseOver="showbox('active<?php echo $i;?>')" onMouseOut="hidebox('active<?php echo $i;?>')" ><i class="fa fa-angle-double-up"></i>
                <?php }else{?>
                onMouseOver="showbox('inactive<?php echo $i;?>')" onMouseOut="hidebox('inactive<?php echo $i;?>')"> <i class="fa fa-angle-double-down"></i>
                <?php }?>
                </a>
                <div id="active<?php echo $i;?>" class="hide1">
                  <p>Active</p>
                </div>
                <div id="inactive<?php echo $i;?>" class="hide1">
                  <p>Inactive</p>
                </div>
                &nbsp;&nbsp; <a href="<?php echo SITEPATH; ?>admin/Document/add_new_document_page.php?id=<?php echo  urlencode(encryptIt($rows['document_id'])); ?>"onMouseOver="showbox('Edit<?php echo $i;?>')"  onMouseOut="hidebox('Edit<?php echo $i;?>')"> <i class="fa fa-pencil"></i></a>
                <div id="Edit<?php echo $i;?>" class="hide1">
                  <p>Edit</p>
                </div>
                &nbsp;&nbsp;
                <?php }?>
                <?php if( $per['categories']['del']==1 ){?>
                <a href="<?php  echo SITEPATH;?>/admin/action/document.php?action=del&id=<?php echo  urlencode(encryptIt($rows['document_id'])); ?>"onClick="return confirmDelete();" onMouseOver="showbox('Delete<?php echo $i;?>')" onMouseOut="hidebox('Delete<?php echo $i;?>')"><i class="fa fa-times"></i></a>
                <div id="Delete<?php echo $i;?>" class="hide1">
                  <p>Delete</p>
                </div>
                <?php }?></td>
              <?php }?>
            </tr>
            <?php 
$i++;
} ?>
          </tbody>
        </table>
      </div>
    </section>
  </div>
  <footer class="main-footer">
    <?php include_once("../common/copyright.php");?>
  </footer>
</div>
<?php include_once("../common/footer.php");?>
</body>
</html>