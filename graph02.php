<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>graph 2</title>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
    <script src="https://openlayers.org/en/v3.19.1/build/ol.js"></script>
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

        <!-- /.navbar-collapse --> </nav>

        <!-- viewport -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <?php include 'core/map_location.html'; ?>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


</body>


</html>
