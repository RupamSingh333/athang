<style>
  .skin-blue .main-header .navbar .sidebar-toggle1 {
    color: #fff;
  }

  .main-header .sidebar-toggle1 {
    float: left;
    background-color: transparent;
    background-image: none;
    padding: 17px 15px;
    font-family: fontAwesome;
  }
</style>

<header class="main-header">

  <!-- Logo -->

  <a href="<?php echo SITEPATH; ?>admin/dashboard.php" class="logo"> <span class="logo-mini"><img src="<?php echo SITEPATH; ?>upload/logo.png"></span> <span class="logo-lg"> <img src="<?php echo SITEPATH; ?>upload/logo.png" style="width: 160px;height: 55px;"></span> </a>

  <!-- Navbar-->

  <nav class="navbar navbar-static-top" role="navigation">

    <!-- Sidebar toggle button-->

    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?php echo SITEPATH; ?>upload/thumb/<?php echo $r["user_logo"]; ?>" class="user-image" alt="User Image"> <span class="hidden-xs"><?php echo $r["first_name"]; ?></span> <i class="fa fa-angle-down"></i></a>
          <ul class="dropdown-menu">

            <!-- User image -->

            <li class="user-header"> <img src="<?php echo SITEPATH; ?>upload/thumb/<?php echo $r["user_logo"]; ?>" class="img-circle" alt="User Image">
              <p><?php echo $r["first_name"]; ?><small><?php echo $r["user_startfrom"]; ?></small> </p>
            </li>
            <li class="user-footer">
              <div class="pull-left"> <a href="<?php echo SITEPATH; ?>admin/user/add-new-user.php?id=<?php echo  urlencode(encryptIt($r['user_id'])); ?>" class="btn btn-default btn-flat">Profile</a> </div>
              <div class="pull-right"> <a href="<?php echo SITEPATH; ?>admin/logout.php" class="btn btn-default btn-flat">Logout</a> </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu"> </li>
      </ul>
    </div>
  </nav>
</header>

<!--header close here, starts Left side column  -->

<aside class="main-sidebar">
  <section class="sidebar">

    <!-- sidebar user panel -->

    <div class="user-panel">
      <div class="pull-left image"> <img src="<?php echo SITEPATH; ?>upload/thumb/<?php echo $r["user_logo"]; ?>" class="img-circle" alt="User Image"> </div>
      <div class="pull-left info">
        <p style="color:#666666"><small>Welcome,</small></p>
        <p><?php echo $r["first_name"]; ?></p>
      </div>
    </div>

    <ul class="sidebar-menu">

      <?php
      // pr($per);exit;
      if ($per['user']['add'] == 1 or $per['user']['view'] == 1) { ?>
        <li class="treeview"> <a> <i class="fa fa-users"></i> <span>Employee Management</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <ul class="treeview-menu">
            <?php if ($per['user']['add'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/user/add-new-user.php"><i class="fa fa-caret-right"></i>Add New</a></li>
            <?php } ?>
            <?php
            if ($per['user']['view'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/user"><i class="fa fa-caret-right"></i> View All</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <?php if ($per['customer']['add'] == 1 or $per['customer']['view'] == 1) { ?>
        <li class="treeview"> <a> <i class="fa fa-user"></i> <span>Customer Management</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <ul class="treeview-menu">
            <?php if ($per['customer']['add'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/customer/add-new-customer.php"><i class="fa fa-caret-right"></i> Add New</a></li>
            <?php }
            if ($per['customer']['view'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/customer"><i class="fa fa-caret-right"></i> View All</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <?php if ($per['district']['add'] == 1 or $per['district']['view'] == 1) { ?>

        <li class="treeview"> <a> <i class="fa  fa-rss-square nav_icon"></i> <span>District Management</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <ul class="treeview-menu">
            <?php if ($per['district']['add'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/district/add_new_district_page.php"><i class="fa fa-caret-right"></i>Add New</a></li>
            <?php }
            if ($per['district']['view'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/district"><i class="fa fa-caret-right"></i> View All</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <?php if ($per['taluka']['add'] == 1 or $per['taluka']['view'] == 1) { ?>
        <li class="treeview"> <a> <i class="fa  fa-rss-square nav_icon"></i> <span>Taluka Management</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <ul class="treeview-menu">
            <?php if ($per['taluka']['add'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/taluka/add_new_taluka_page.php"><i class="fa fa-caret-right"></i>Add New</a></li>
            <?php }
            if ($per['taluka']['view'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/taluka"><i class="fa fa-caret-right"></i> View All</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <?php if ($per['food_license']['add'] == 1 or $per['food_license']['view'] == 1) { ?>
        <li class="treeview">
          <a> <i class="fa  fa-rss-square nav_icon"></i> <span>Food License</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <ul class="treeview-menu">
            <?php if ($per['food_license']['add'] == 1) { ?>
              <!-- <li><a href="<?php //echo SITEPATH; 
                                ?>admin/taluka/add_new_taluka_page.php"><i class="fa fa-caret-right"></i>Add New</a></li> -->
            <?php }
            if ($per['food_license']['view'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/food_shop_bank_demate/food_license.php"><i class="fa fa-caret-right"></i> View All</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <?php if ($per['shop_act_license']['add'] == 1 or $per['shop_act_license']['view'] == 1) { ?>
        <li class="treeview">
          <a> <i class="fa fa-shopping-cart"></i> <span>Shop Act License</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <ul class="treeview-menu">
            <?php if ($per['shop_act_license']['add'] == 1) { ?>
              <!-- <li><a href="<?php echo SITEPATH; ?>admin/taluka/add_new_taluka_page.php"><i class="fa fa-caret-right"></i>Add New</a></li> -->
            <?php }
            if ($per['shop_act_license']['view'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/food_shop_bank_demate/shop_act_license.php"><i class="fa fa-caret-right"></i> View All</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <?php if ($per['bank_account']['add'] == 1 or $per['bank_account']['view'] == 1) { ?>
        <li class="treeview">
          <a> <i class="fa fa-university"></i> <span>Bank Account</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <ul class="treeview-menu">
            <?php if ($per['bank_account']['add'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/food_shop_bank_demate/add_view_bank_link.php"><i class="fa fa-caret-right"></i>Add New Link</a></li>
            <?php }
            if ($per['bank_account']['view'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/food_shop_bank_demate/bank_account.php"><i class="fa fa-caret-right"></i> View All</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <?php if ($per['demat_account']['add'] == 1 or $per['demat_account']['view'] == 1) { ?>
        <li class="treeview">
          <a> <i class="fa  fa-rss-square nav_icon"></i> <span>Demat Account</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <ul class="treeview-menu">
            <?php if ($per['demat_account']['add'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/food_shop_bank_demate/add_view_demat_link.php"><i class="fa fa-caret-right"></i>Add New Link</a></li>
            <?php }
            if ($per['demat_account']['view'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/food_shop_bank_demate/demate_account.php"><i class="fa fa-caret-right"></i> View All</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <?php if ($per['itr_management']['add'] == 1 or $per['itr_management']['view'] == 1) { ?>
        <li class="treeview">
          <a> <i class="fa  fa-rss-square nav_icon"></i> <span>ITR Management</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <ul class="treeview-menu">
            <?php if ($per['itr_management']['add'] == 1) { ?>
              <!-- <li><a href="<?php echo SITEPATH; ?>admin/taluka/add_new_taluka_page.php"><i class="fa fa-caret-right"></i>Add New</a></li> -->
            <?php }
            if ($per['itr_management']['view'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/food_shop_bank_demate/itr_management.php"><i class="fa fa-caret-right"></i> View All</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <?php if ($per['bs']['add'] == 1 or $per['bs']['view'] == 1) { ?>
        <li class="treeview">
          <a> <i class="fa  fa-rss-square nav_icon"></i> <span>B/S</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <ul class="treeview-menu">
            <?php if ($per['bs']['add'] == 1) { ?>
              <!-- <li><a href="<?php echo SITEPATH; ?>admin/taluka/add_new_taluka_page.php"><i class="fa fa-caret-right"></i>Add New</a></li> -->
            <?php }
            if ($per['bs']['view'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/food_shop_bank_demate/bs.php"><i class="fa fa-caret-right"></i> View All</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <?php if ($per['attendance_management']['add'] == 1 or $per['attendance_management']['view'] == 1) { ?>
        <li class="treeview">
          <a> <i class="fa fa-clock-o"></i> <span>Attendance Management</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <ul class="treeview-menu">
            <?php if ($per['attendance_management']['add'] == 1) { ?>
              <!-- <li><a href="<?php //echo SITEPATH; 
                                ?>admin/taluka/add_new_taluka_page.php"><i class="fa fa-caret-right"></i>Add New</a></li> -->
            <?php }
            if ($per['attendance_management']['view'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/attendance"><i class="fa fa-caret-right"></i> View All</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

      <?php if ($per['salary_management']['add'] == 1 or $per['salary_management']['view'] == 1) { ?>
        <li class="treeview">
          <a> <i class="fa fa-money"> </i> <span> Salary Management</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <ul class="treeview-menu">
            <?php if ($per['salary_management']['add'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/salary/generate_salary.php"><i class="fas fa-file-invoice-dollar"></i> Generate Salary</a></li>
            <?php }
            if ($per['salary_management']['view'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/salary"><i class="fas fa-list-alt"></i> View All</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>


      <?php if ($per['report_management']['add'] == 1 or $per['report_management']['view'] == 1) { ?>
        <li class="treeview">
          <a> <i class="fa fa-file"></i> <span>Report Management</span> <i class="fa fa-angle-left pull-right"></i> </a>
          <ul class="treeview-menu">
            <?php if ($per['report_management']['add'] == 1) { ?>
              <!-- <li><a href="<?php echo SITEPATH; ?>admin/taluka/add_new_taluka_page.php"><i class="fa fa-caret-right"></i>Add New</a></li> -->
            <?php }
            if ($per['report_management']['view'] == 1) { ?>
              <li><a href="<?php echo SITEPATH; ?>admin/report"><i class="fa fa-caret-right"></i> View All</a></li>
            <?php } ?>
          </ul>
        </li>
      <?php } ?>

    </ul>
  </section>
</aside>

<!--close Left side column, starts page contets  -->