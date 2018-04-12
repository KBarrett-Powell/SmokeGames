<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>

   <title>
        Smoke Games - 404 Page Not Found
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
                        <li><a href="index.php">Home</a></li>
                        <li>Page not found</li>
                    </ul>

                    <div class="row" id="error-page">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="box">

                                <p class="text-center">
                                    <img src="images/Logos/logo-small.png">
                                </p>

                                <h3>We are sorry - either this page is not here anymore, or the page cannot be viewed.</h3>
                                <!--<h4 class="text-muted">Error 404 - Page not found</h4>-->

                                <p class="text-center">To continue please use the <strong>Search form</strong> or <strong>Menu</strong> above.</p>
                                <p class="text-center">If you feel you should be able to see this page, please check if you're logged in first, then feel free to contact us.</p>

                                <p class="buttons"><a href="index.php" class="btn btn-primary"><i class="fa fa-home"></i> Go to Homepage</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "footer.php"; ?>

</body>
</html>