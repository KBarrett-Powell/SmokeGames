<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Smoke Games - Contact
    </title>

    <?php 
        include "references.php"; 
        include "requireMail.php";
        
        function verifyContact() {
            $username = $_POST['uname'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
            $errors = array();

            if ($uname != strip_tags($uname)) {
                array_push($errors, "Please don't use tags in your username\n");
            }
            if ($subject != strip_tags($subject)) {
                array_push($errors, "Please don't use tags in your email subject\n");
            }
            if ($message != strip_tags($message)) {
                array_push($errors, "Please don't use tags in your message\n");
            }

            return $errors;
        }
    ?>
</head>

<body>
    <?php include "navigation.php"; ?>

    <div id="all">
        <div id="content">
            <div class="container">

                <!-- Top of page links back to home -->
                <div class="col-md-12">

                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li>Contact</li>
                    </ul>

                </div>

                <!-- Side bar menu -->
                <div class="col-md-3">

                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Pages</h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <a href="faq.php">Terms & Conditions</a>
                                </li>
                                <li>
                                    <a href="#">Contact page</a>
                                </li>
                            </ul>
                        </div>
                    </div>            
                </div>

                <!-- Information part of page -->
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
                            
                            <div class="col-sm-4">

                                <h3><i class="fa fa-phone"></i> Call center</h3>
                                <p class="text-muted">This number is toll free if calling from Great Britain otherwise we advise you to use the electronic form of communication. (General enquireies for Cardiff University).</p>
                                <p><strong>+44(0)20920874000</strong>
                                </p>
                            </div>

                            <div class="col-sm-4">

                                <h3><i class="fa fa-envelope"></i> Electronic support</h3>
                                <p class="text-muted">Please feel free to write an email to us or to use our electronic ticketing system.</p>
                                <ul>
                                    <li><strong>help@smokegames.com</strong></li>
                                    <li>We aim to respond or act on messages within 24 hours.</li>
                                </ul>
                            </div>

                        </div>

                        <hr>

                        <!-- Display google maps in site -->
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d8854.259464543067!2d-3.1713377680972283!3d51.48307448912269!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2suk!4v1519879877813" width="780" height="480" frameborder="0" style="border:0" allowfullscreen></iframe>

                        <hr>

                        <h2>Contact form</h2>

                        <form action="contact.php" method="post">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="uname">Username</label>
                                        <input type="text" class="form-control" id="uname" name="uname">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" required="required" id="email" name="email">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="subject">Subject</label>
                                        <input type="text" class="form-control" required="required" id="subject" name="subject">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="message">Message</label>
                                        <textarea id="message" name="message" class="form-control" required="required"></textarea>
                                    </div>
                                </div>

                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary" id="mesSend" name="mesSend"><i class="fa fa-envelope-o"></i> Send message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
    include "footer.php"; 

    try {
        include "config.php";

        if(isset($_POST['mesSend'])) {
            $cErrors = verifyContact();
            if (empty($cErrors)) {
                $username = $_POST['uname'];
                $email = $_POST['email'];
                $subject = $_POST['subject'];
                $message = $_POST['message'];

                try {
                    // Adding variables to the email
                    // Check if user is logged in, to give admin idea who the email is from
                    if (isset($_SESSION['username'])) {
                        $mail->SetFrom($email, $_SESSION['username']);
                    }else if($username != null) {
                        $mail->SetFrom($email, $username);
                    } else {
                        $mail->SetFrom($email, 'Unknown User');
                    }
                    
                    // Sending to admin email
                    $mail->AddAddress('smokegames2018@gmail.com');
                    $mail->Subject = $subject;

                    // Filling email body with message entered
                    $mail->Body = $message;
                    
                    // Sending Email
                    $mail->Send();
                        
                    // Send user success message, and take them to main page
                    echo "<script type='text/javascript'>alert('Successfully Sent Email. You should get a response in a few days.')</script>";
                
                } catch (phpmailerException $e) {
                    echo "<script type='text/javascript'>alert('Email could not be sent. Please check details and try again later.')</script>";
                    echo $e->errorMessage(); 
                }
            } else {
                echo "<script type='text/javascript'>alert(". json_encode($cErrors) .");</script>";
            }
        }

    }catch(PDOException $e) {
        echo "<script type='text/javascript'>location.href = '404.php'";
    }
    $gamesdb = null;
?>

</body>
</html>