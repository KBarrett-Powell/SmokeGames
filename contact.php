<!DOCTYPE html>
<html lang="en">

<head>

    <title>
        Smoke Games Contact
    </title>

    <?php include "references.php"; ?>

</head>

<body>
    <?php include "navigation.php"; ?>

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a>
                        </li>
                        <li>Contact</li>
                    </ul>

                </div>

                <div class="col-md-3">
                    <!-- PAGES MENU -->
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Menu</h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <a href="#">Contact Information</a>
                                </li>
                                <!-- <li>
                                    <a href="#">Profile</a>
                                </li>
                                <li>
                                    <a href="#">Report a Player</a>
                                </li> -->

                            </ul>

                        </div>
                    </div>

                    <!-- *** PAGES MENU END *** -->

                    <!-- incase we want to add a side picture, like a helping report player message -->
                    <!-- <div class="banner">
                        <a href="#">
                            <img src="" alt="sales 2014" class="img-responsive">
                        </a>
                    </div>-->
                    
                </div>

                <div class="col-md-9">

                    <div class="box" id="contact">
                        <h1>Contact</h1>

                        <p class="lead">Are you curious about something? Do you have some kind of problem with our platform?</p>
                        <p>Please feel free to contact us, our friendly staff are available 24/7.</p>

                        <hr>

                        <div class="row">
                            <div class="col-sm-4">
                                <h3><i class="fa fa-map-marker"></i> Address</h3>
                                <p>Smoke Games
                                    <br>Queens Building
                                    <br>Cardiff University
                                    <br>Cardiff, Wales
                                    <br>CF24 3AA
                                    <br>
                                    <strong>United Kingdom</strong>
                                </p>
                            </div>
                            <!-- /.col-sm-4 -->
                            <div class="col-sm-4">
                                <h3><i class="fa fa-phone"></i> Call center</h3>
                                <p class="text-muted">This number is toll free if calling from Great Britain otherwise we advise you to use the electronic form of communication. (General enquireies for Cardiff University).</p>
                                <p><strong>+44(0)20920874000</strong>
                                </p>
                            </div>
                            <!-- /.col-sm-4 -->
                            <div class="col-sm-4">
                                <h3><i class="fa fa-envelope"></i> Electronic support</h3>
                                <p class="text-muted">Please feel free to write an email to us or to use our electronic ticketing system.</p>
                                <ul>
                                    <li><strong><a href="mailto:">help@smokegames.com</a></strong>
                                    </li>
                                    <li>We aim to respond or act on messages within 24 hours.</li>
                                </ul>
                            </div>
                            <!-- /.col-sm-4 -->
                        </div>
                        <!-- /.row -->

                        <hr>

                        <!--<div id="map"></div>-->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d8854.259464543067!2d-3.1713377680972283!3d51.48307448912269!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2suk!4v1519879877813" width="780" height="480" frameborder="0" style="border:0" allowfullscreen></iframe>

                        <hr>
                        <h2>Contact form</h2>
                        <!-- Still needs implementing to send an email. -->

                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">Firstname</label>
                                        <input type="text" class="form-control" id="firstname">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lastname">Lastname</label>
                                        <input type="text" class="form-control" id="lastname">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="subject">Subject</label>
                                        <input type="text" class="form-control" id="subject">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea id="message" class="form-control"></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send message</button>

                                </div>
                            </div>
                            <!-- /.row -->
                        </form>
                    </div>
                </div>
                <!-- /.col-md-9 -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->
    </div>
    <!-- /#all -->

<?php include "footer.php"; ?>
</body>

</html>
