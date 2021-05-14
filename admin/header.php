<?php include_once 'engine/conn.php'; ?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>4return | Admin</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    
</head>

<body class="top-navigation">

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom white-bg">
                <nav class="navbar navbar-expand-lg navbar-static-top" role="navigation">
                    <!--<div class="navbar-header">-->
                        <!--<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">-->
                            <!--<i class="fa fa-reorder"></i>-->
                        <!--</button>-->

                        <a href="#" class="navbar-brand">4return</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa fa-reorder"></i>
                        </button>

                    <!--</div>-->
                    <div class="navbar-collapse collapse" id="navbar">
                        <ul class="nav navbar-nav mr-auto">
                            <li><a aria-expanded="false" role="button" href="index.php"><i class="fa fa-home"></i> Home</a></li>
                            <li><a aria-expanded="false" role="button" href="products.php"><i class="fa fa-table"></i> Products</a></li>
                            <li><a aria-expanded="false" role="button" href="users.php"><i class="fa fa-users"></i> Users</a></li>
                        </ul>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <a href="login.html">
                                    <i class="fa fa-sign-out"></i> Log out
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="wrapper wrapper-content">
                <div class="container-fluid">