<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>graph 2</title>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript"></script>

<!--  load CSS -->
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
   	<link rel="stylesheet" href="http://getbootstrap.com/examples/cover/cover.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.1/dygraph-combined.js"></script>
</head>


<body>

    <div id="wrapper">

        <!-- Navigation -->

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">


        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">

            <ul class="nav navbar-nav side-nav">
                <li><a href="index.php">
                    <i class="fa fa-fw fa-dashboard"></i> Home</a>
                </li>
                <li class="active"><a href="graph01.php">
                    <i class="fa fa-fw fa-dashboard"></i> Graph 1</a>
                </li>
                <li><a href="tables.html">
                    <i class="fa fa-fw fa-table"></i> Tables</a>
                </li>
                <li><a href="forms.html">
                    <i class="fa fa-fw fa-edit"></i> Forms</a>
                </li>
                <li><a href="bootstrap-elements.html">
                    <i class="fa fa-fw fa-desktop"></i> Bootstrap Elements</a>
                </li>
                <li><a href="bootstrap-grid.html">
                    <i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>
                </li>
                <li><a href="javascript:;" data-toggle="collapse" data-target="#demo">
                    <i class="fa fa-fw fa-arrows-v"></i> Sensors
                    <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo" class="collapse">
                        <li><a href="#">Dropdown Item</a></li>
                        <li><a href="#">Dropdown Item</a></li>
                    </ul>
                </li>
                <li><a href="blank-page.html">
                    <i class="fa fa-fw fa-file"></i> Blank Page</a>
                </li>
                <li><a href="index-rtl.html">
                    <i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>


                <!-- USER -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i> User
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="fa fa-fw fa-user"></i> Profile</a></li>
                        <li><a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li><a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a></li>
                    </ul>
                </li>

            </ul>
        </div>

        <!-- /.navbar-collapse -->
        </nav>

        <!-- viewport -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <p> test </p>
                <?php include 'map_location.html'; ?>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


</body>


</html>
