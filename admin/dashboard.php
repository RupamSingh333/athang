<?php
include("../system_config.php");
include_once("common/head.php");
?>
<style>
    .cdsdf {
        color: white;
        font-size: 70px;
    }

    /*--chit chart layer start here--*/
    .panel {
        padding: 1em 1em;
        margin-bottom: 0px;
        background: none;
        box-shadow: none;
    }

    .chit-chat-layer1 {
        margin: 2em 0em;
    }

    .chit-chat-heading {
        font-size: 1.2em;
        font-weight: 700;
        color: #5F5D5D;
        text-transform: uppercase;
        font-family: 'Carrois Gothic', sans-serif;
    }

    .work-progres {
        box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.15);
        padding: 1.34em 1em;
        background: #fff;
    }

    /*--geochart start here--*/
    section#charts1 {
        padding: 0px;
    }

    .geo-chart {
        box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.15);
        padding: 1em 1em;
        background: #fff;
    }

    .revenue {
        padding: 1em;
        background: #fff;
        box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.15);
    }

    div#geoChart {
        width: 100% !important;
        height: 305px !important;
        border: 4px solid #fff;
    }

    h3#geoChartTitle {
        font-size: 1.3em;
        font-weight: 700;
        color: #5F5D5D;
        text-transform: uppercase;
        font-family: 'Carrois Gothic', sans-serif;
    }

    /*--climate start here--*/
    .climate-grid1 {
        background: url(../images/climate.jpg)no-repeat;
        min-height: 375px;
        background-size: cover;
        box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.15);
    }

    .climate-gd1top-left h4 {
        font-size: 1.2em;
        color: #fff;
        margin-bottom: 0.5em;
        font-family: 'Carrois Gothic', sans-serif;
    }

    .climate-gd1top-left h3 {
        font-size: 2em;
        color: #FC8213;
        margin-bottom: 0.5em;
        font-family: 'Carrois Gothic', sans-serif;
    }

    .climate-gd1top-left p {
        font-size: 1em;
        color: #fff;
        line-height: 2em;
    }

    .climate-gd1top-right {
        font-size: 1em;
        color: #fff;
        line-height: 2em;
    }

    .climate-gd1-top {
        padding: 1em 1em;
        margin-bottom: 1.6em;
    }

    .climate-gd1-bottom {
        padding: 1em 0em;
        background: rgba(252, 130, 19, 0.86);
    }

    .cloudy1 h4 {
        font-size: 1em;
        color: #fff;
        margin-bottom: 0.5em;
    }

    .cloudy1 {
        text-align: center;
    }

    i.fa.fa-cloud {
        color: #fff;
        font-size: 2.5em;
        margin: 0.2em 0em 0.2em 0em;
    }

    .cloudy1 h3 {
        font-size: 1.2em;
        color: #fff;
    }

    span.timein-pms {
        font-size: 0.4em;
        vertical-align: top;
        color: #fff;
    }

    span.clime-icon {
        display: block;
        margin-bottom: 0.3em;
    }

    .climate-grid2 {
        background: url(../assets/images/shoppy.jpg)no-repeat bottom;
        min-height: 310px;
        background-size: cover;
        position: relative;
    }

    .shoppy {
        padding: 1.4em 1em;
        background: #fff;
        box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.15);
    }

    .climate-grid2 ul {
        position: absolute;
        bottom: -10px;
        right: 0px;
        list-style: none;
    }

    .climate-grid2 ul li {
        display: inline-block;
        margin-right: 0.5em;
    }

    .climate-grid2 ul li i.fa.fa-credit-card {
        width: 35px;
        height: 30px;
        display: inline-block;
        background: #337AB7;
        font-size: 1em;
        color: #FFFFFF;
        line-height: 2em;
        text-align: center;
        border-radius: 4px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -o-border-radius: 4px;
    }

    .climate-grid2 ul li i.fa.fa-credit-card:hover {
        background: #ec8526;
    }

    .climate-grid2 ul li i.fa.fa-usd {
        width: 35px;
        height: 30px;
        display: inline-block;
        background: #337AB7;
        font-size: 1em;
        color: #fff;
        line-height: 2em;
        text-align: center;
        border-radius: 4px;
    }

    .climate-grid2 ul li i.fa.fa-usd:hover {
        background: #ec8526;
    }

    span.shoppy-rate {
        background: #FC8213;
        margin: 1em 1em;
        width: 70px;
        height: 70px;
        text-align: center;
        border-radius: 49px;
        -webkit-border-radius: 49px;
        -moz-border-radius: 49px;
        -o-border-radius: 49px;
        display: inline-block;
    }

    span.shoppy-rate h4 {
        font-size: 1.2em;
        line-height: 3.5em;
        color: #fff;
        font-family: 'Carrois Gothic', sans-serif;
    }

    .shoppy h3 {
        font-size: 1.2em;
        color: #68AE00;
        font-family: 'Carrois Gothic', sans-serif;
    }

    .popular-brand {
        box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.15);
    }

    .popular-bran-right {
        background: #FC8213;
        padding: 3em 1em;
    }

    .popular-bran-left {
        background: #fff;
        padding: 2em 1em;
    }

    .popular-bran-left h3 {
        font-size: 1.2em;
        color: #68AE00;
        margin-bottom: 0.2em;
        font-family: 'Carrois Gothic', sans-serif;
    }

    .popular-bran-left h4 {
        font-size: 0.9em;
        color: #FC8213;
    }

    .popular-bran-right h3 {
        font-size: 1.3em;
        color: #fff;
        text-align: center;
    }

    .popular-bran-right h3 {
        font-size: 1.55em;
        color: #fff;
        width: 77px;
        height: 77px;
        margin: 0 auto;
        line-height: 2.8em;
        border-radius: 62px;
        -webkit-border-radius: 62px;
        -moz-border-radius: 62px;
        -o-border-radius: 62px;
        border: 3px solid #fff;
        font-family: 'Carrois Gothic', sans-serif;
    }

    .popular-follo-left {
        background: #FDBB30;
    }

    .popular-follow {
        margin-top: 2.35em;
        background: #fff;
        box-shadow: 0px 0px 2px 1px rgba(0, 0, 0, 0.15);
    }

    .popular-follo-right {
        padding: 3em 1em;
        text-align: center;
    }

    .popular-follo-left {
        background: #68AE00;
        padding: 2.5em 1em;
    }

    .popular-follo-left p {
        font-size: 1em;
        color: #fff;
        line-height: 1.8em;
    }

    .popular-follo-right h4 {
        font-size: 1.5em;
        color: #FC8213;
        margin-bottom: 0.3em;
        font-family: 'Carrois Gothic', sans-serif;
    }

    .popular-follo-right h5 {
        font-size: 1em;
        color: #68AE00;
    }

    .popular-bran-left p {
        font-size: 1em;
        color: #000;
        margin-top: 1.3em;
        line-height: 1.5em;
    }

    .climate-gd1top-right p {
        font-size: 1em;
        color: #fff;
    }

    /*--climate end here--*/
    #style-2::-webkit-scrollbar-thumb {

        background-color: #000;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        padding: 5px;
    }

    .table {
        margin-bottom: 6px;
    }

    .custom-box {
        background-color: #3498db;
        color: #fff;
        border-radius: 10px;
        border: 8px solid #fff;
        padding: 6px;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    .custom-box.user {
        background-color: #e74c3c;
    }

    .custom-box.product {
        background-color: #27ae60;
    }

    .custom-box.order {
        background-color: #f39c12;
    }

    .custom-icon {
        font-size: 40px;
    }

    .inner {
        text-align: center;
    }

    .custom-box:hover {
        background-color: #f39c12;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    }

    /* Add margin between sections */
    .chit-chat-layer1 {
        margin-top: 20px;
    }

    /* Style for tables */
    .table {
        border-collapse: collapse;
        width: 100%;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .table th {
        background-color: #f5f5f5;
    }

    /* Style for table headings */
    .table thead th {
        font-weight: bold;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body class="hold-transition skin-blue sidebar-mini fixed">
    <div class="wrapper">
        <?php include_once("common/left_menu.php"); ?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1> Dashboard </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <?php if ($_SESSION['AdminLogin'] == 1) { ?>

                <section class="content">

                    <!-- Cart start form here -->
                    <div class="row">

                        <div class="col-lg-6 col-xs-6">
                            <div class="custom-box user">
                                <div class="inner">
                                    <h3 class="text-center"><?= count(getuser_byList()); ?></h3>
                                    <p class="text-center">User List Count</p>
                                </div>
                                <a href="<?php echo SITEPATH; ?>admin/user">
                                    <div class="icon custom-icon user text-center"><i class="fas fa-user"></i></div>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xs-6">
                            <div class="custom-box customer">
                                <div class="inner">
                                    <h3 class="text-center"><?= count(getcustomer_byList()); ?></h3>
                                    <p class="text-center">Customer List Count</p>
                                </div>
                                <a href="<?php echo SITEPATH; ?>admin/customer">
                                    <div class="icon custom-icon customer text-center"><i class="fas fa-users"></i></div>
                                </a>
                            </div>
                        </div>


                        <!-- <div class="col-lg-4 col-xs-6">
                            <div class="custom-box product">
                                <div class="inner">
                                    <h3 class="text-center">42</h3>
                                    <p class="text-center">Product List Count</p>
                                </div>
                                <div class="icon custom-icon product text-center"><i class="fas fa-shopping-cart"></i></div>
                            </div>
                        </div> -->

                        <!-- <div class="col-lg-4 col-xs-6">
                            <div class="custom-box order">
                                <div class="inner">
                                    <h3 class="text-center">23</h3>
                                    <p class="text-center">Order List Count</p>
                                </div>
                                <div class="icon custom-icon order text-center"><i class="fas fa-list-alt"></i></div>
                            </div>
                        </div> -->
                    </div>
                    <!-- Cart start form end -->


                    <div class="row">
                        <div class="chit-chat-layer1">
                            <!-- customer list  -->
                            <div class="col-md-12 chit-chat-layer1-left">
                                <div class="work-progres">
                                    <div class="chit-chat-heading">Latest Top 10 Customer List </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th><strong>Name</strong></th>
                                                    <th><strong>Email</strong></th>
                                                    <th><strong>Number</strong></th>
                                                    <th><strong>Address</strong></th>
                                                    <th><strong>Status</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $customerList = getcustomer_byList(10);
                                                foreach ($customerList as $index => $customer) {
                                                    $custState = getState_byID($customer['cust_state']);
                                                    $cust_taluka = gettaluka_byID($customer['cust_taluka_id']);
                                                    $getdistrict_byID = getdistrict_byID($customer['cust_district_id']);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $index + 1; ?></td>
                                                        <td><?php echo $customer['cust_first_name']; ?></td>
                                                        <td><?php echo $customer['cust_email']; ?></td>
                                                        <td><?php echo $customer['cust_phone']; ?></td>
                                                        <td>
                                                            <div style="font-weight: bold;">
                                                                <?php echo $customer['cust_address'] ?>,
                                                                <span style="color: #333;"><?php echo $custState['name']; ?></span>
                                                                <span style="color: #333;"><?php echo $getdistrict_byID['district_name']; ?></span>
                                                                <span style="color: #333;"><?php echo $cust_taluka['taluka_name']; ?></span>-
                                                                <span style="color: #333;"><?php echo $customer['cust_pincode']; ?></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php if ($customer['cust_status'] == 0) { ?>
                                                                <i class="fa fa-check-circle" title="Active" style="color: green;"></i>
                                                            <?php } else { ?>
                                                                <i class="fa fa-times-circle" title="Pending" style="color: red;"></i>
                                                            <?php  } ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <!-- order list  -->
                            <div class="chit-chat-layer1" style="margin-top: 20px;">
                                <!-- order list  -->
                                <!-- <div class="col-md-12">
                                    <div class="work-progres">
                                        <div class="chit-chat-heading">Latest Top 10 Order List </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Order Number</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Mobile</th>
                                                        <th>Address</th>
                                                        <th>Payment Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // $orderList = getorders_list(10);
                                                    // pr($orderList);
                                                    foreach ($orderList as $index => $order) {

                                                    ?>
                                                        <tr>
                                                            <td><?php echo $index + 1; ?></td>
                                                            <td><?php echo $order['order_number']; ?></td>
                                                            <td><?php echo $order['first_name'] . ' ' . $order['last_name']; ?></td>
                                                            <td><?php echo $order['email']; ?></td>
                                                            <td><?php echo $order['mobile_number']; ?></td>
                                                            <td><?php echo $order['cust_billing_address']; ?>
                                                                <?php echo $order['customer_city'] . ' ' . $order['customer_state'] . '-' . $order['zip_code'] . ' ' . $order['customer_country']; ?></td>
                                                            <td><?= ($order['payment_status'] == 0) ? 'Pending' : 'Success'; ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> -->

                            </div>

                        </div>
                    </div>

                    <!-- <div class="clearfix"></div> -->
                </section>

            <?php } else { ?>

                <section id="none-admin">
                    <style>
                        #none-admin {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background-color: #f4f4f4;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        }

                        .welcome-container {
                            text-align: center;
                            padding: 40px;
                            background-color: #ffffff;
                            border-radius: 8px;
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                            max-width: 80%;
                            color: #333;
                        }

                        h1 {
                            color: #007bff;
                            font-size: 36px;
                            margin-bottom: 20px;
                        }

                        p {
                            color: #666;
                            line-height: 1.6;
                            margin-bottom: 20px;
                        }

                        a {
                            text-decoration: none;
                            color: #007bff;
                            font-weight: bold;
                            transition: color 0.3s ease;
                        }

                        a:hover {
                            color: #0056b3;
                            /* Darker shade of blue on hover */
                        }
                    </style>

                    <div class="welcome-container">
                        <h1>Welcome!</h1>
                        <p>Oops! It seems you do not have access to this dashboard.</p>
                        <p>If you believe this is an error, please contact support for assistance.</p>
                    </div>
                </section>

            <?php } ?>



        </div>
    </div>
    <footer class="main-footer">
        <?php include_once("common/copyright.php"); ?>
    </footer>
    </div>
    <?php include_once("common/footer.php"); ?>
</body>

</html>