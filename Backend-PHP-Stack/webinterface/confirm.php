<?php

///////////////////////////////////////////////////////////////////////////
//Webstart
require_once('../webstart.inc.php');
///////////////////////////////////////////////////////////////////////////

if(isset($_GET["emailtoken"]) && $_GET["emailtoken"] != "") {

    $emailToken = $_GET["emailtoken"];

    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="pictures/logo_prototype.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <title>Unveiled</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!--link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"-->
    <!-- Custom styles for this template -->
    <link href="css/main.css" rel="stylesheet">
    <link href="css/sweetalert.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/jquery.toaster.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script type="text/javascript" src="js/Userlist.js"></script>
    <script type="text/javascript" src="js/navbar.js"></script>
    <script type="text/javascript" src="js/controller.js"></script>
</head>
<body style="background-color: #5a5a5a">
<div class="navbar-wrapper">
    <div class="container">

        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">Unveiled</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse" style="position: relative">
                    <ul class="nav navbar-nav">
                        <li ><a href="index.html">Home</a></li>
                        <li ><a href="http://unveiled.systemgrid.de/wp/blog/" >Blog</a></li>
                        <!--li ><a href="contact.html">Contact</a></li-->
                        <li id="loginPage"><a  data-toggle="modal" href="#myModal">Login</a></li>
                        <li id="mediaPage"><a href="media.html">Media</a></li>
                    </ul>
                    <div  id="userMenu" class="btn-group dropdown">
                        <a id="usernameField" class="btn btn-primary" href="#" style="background-color: #222; border-color: #5a5a5a"><i class="fa fa-user fa-fw"></i> </a>
                        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#" style="background-color: #222; border-color: #5a5a5a">
                            <span class="fa fa-caret-down"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="profile.html"><i class="fa fa-pencil fa-fw"></i> Edit</a></li>
                            <li id="deleteUser" class="deleteUserAccount"><a href="usermanagement.html"><i class="fa fa-trash-o fa-fw"></i> Maintain Users</a></li>
                            <li class="divider"></li>
                            <li><a id="logoutPage" data-toggle="alert" href="#"><i class="fa fa-sign-out"></i> Logout</a></li>
                        </ul>

                    </div>

                    </ul>
                </div>
            </div>
        </nav>

    </div>
</div>
<div style="height: 150px; margin-top: 150px; margin-left: 25%;color: #FFF; font-size: 30px;">
    Ihre Registrierung wurde bestätigt!!!
</div>
<!-- Modal -->
<div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:35px 50px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style=" color:white !important; text-align: center; font-size: 30px;"><span class="glyphicon glyphicon-lock"></span> Login</h4>
            </div>
            <div class="modal-body" style="padding:40px 50px;">
                <form role="form">
                    <div class="form-group">
                        <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
                        <input type="text" class="form-control" id="usrname" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
                        <input type="password" class="form-control" id="psw" placeholder="Enter password">
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" value="" checked>Remember me</label>
                    </div>
                    <button id="loginBtn" type="button" class="btn btn-primary btn-block" ><span class="glyphicon glyphicon-off"></span> Login</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                <p>Not Registered. <a data-toggle="modal" href="#mySignUp" data-dismiss="modal">Sign Up!</a></p>
                <p>Forgot <a href="#">Password?</a></p>
            </div>
        </div>

    </div>
</div>
</div>
</body>
</html>