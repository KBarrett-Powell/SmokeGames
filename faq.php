<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    include "config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Smoke Games
    </title>

    <?php 
      include "references.php";
    ?>
</head>

<body>

   <?php include "navigation.php"; ?>

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="#">Home</a>
                        </li>
                        <li>FAQ</li>
                    </ul>

                </div>

                <div class="col-md-3">
                    <!-- *** PAGES MENU ***
 _________________________________________________________ -->
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
                                    <a href="contact.php">Contact page</a>
                                </li>
                                <li>
                                    <a href="faq.html">FAQ</a>
                                </li>

                            </ul>

                        </div>
                    </div>

                    <!-- *** PAGES MENU END *** -->
                </div>

                <div class="col-md-9">

                    <div class="box" id="contact">
                        <h1>Smoke Games - Terms & Conditions</h1>

                        <p class="lead">Please read very carefully.</p>
                        <p>These Terms are a legal agreement between you and SmokeGames (referred to as us/we/our in these Terms). The Terms set out how you may use the website www.smokegames.co.uk ("Website"), our apps and any games, products, forums and services we offer through the apps or Website or other dedicated websites</p>
                        
                        <p>These Terms were last updated on 1st May 2018.</p>
                        <hr>

                        <div class="panel-group" id="accordion">

                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">

					    <a data-toggle="collapse" data-parent="#accordion" href="#faq1">

						1. Our Objective & Obligation to You.

					    </a>

					</h4>
                                </div>
                                <div id="faq1" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p>We aim to make Smoke Games a platform where all users enjoy games, compete with others, and make new friends. Your safety is our priority.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel -->

                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">

					    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">

						2. What do I do if I have an issue? How do I get help?

					    </a>

					</h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        Our contact details can be found in the contact us page, and you can fill out a form stating your concern that will be sent to us. Screenshots relating to your issue are appreciated, as they will help us with our investigation. Investigations are conducted thoroughly, regardless of the authenticity of the report, and we aim to make consequences fitting for the crime in the interest of deterring attackers and preventing further incidents. For particularly serious cases and cases beyond the scope of Smoke Games, Smoke Games may contact law enforcement, though we urge you to contact law enforcement directly if the issue involves an emergency.
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel -->


                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">

					    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">

						3. Privacy and Data Collection

					    </a>

					</h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        We treat cases of technical intrusions seriously; if you feel your personal information and/ privacy have been compromised as a result of using our site, we advise you to change your password immediately and report your situation to us. We do not use your account contact details to reach out to you unless you have reached out to us or are under suspicion of abuse. We also do not give away your personal details to third-party individuals.

                                        In the interest of research and data analytics, we may collect data as a whole, such as the ages and sexes of players of a particular game. We do not publish statistics that reveal your data as an individual.

                                        To protect your data, we encrypt stored and transmitted data so that sensitive information is safer from interception and database breaches. In addition, the development team uses up-to-date, reputable antivirus software, and we recommend our users to do the same. Please do not reveal personal information or passwords to anyone over any media, and while we make every effort to protect your data, please consider updating your password a few times a year and using unique passwords for your accounts (on Smoke and other websites) in order to maximise security.

                                        The Computer Misuse Act of 1990 is designed to protect computer users against attacks and theft of information. Offences under the act include hacking, unauthorised access to computer systems and purposefully spreading malicious and damaging software such as viruses. Unauthorised access to modify computers include altering software and data, and changing passwords and settings to prevent others accessing the system, and are prohibited by law.

                                    </div>
                                </div>
                            </div>
                            <!-- /.panel -->
                            
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">

					    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">

						4. Cookies

					    </a>

					</h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        'Cookies' refer to small pieces of text used to store information on web browsers. Smoke Games receives and uses cookies to make using Smoke Games quicker and to make the experience more personalised.
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel -->
                            
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">

					    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">

						5. Trademark

					    </a>

					</h4>
                                </div>
                                <div id="collapseFive" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        The Smoke logo is not to be used in third-party promotional material without the express permission of Smoke Games moderators.
                                        Care has been taken to credit games to the rightful developers, whether the developer is Smoke Games or a third-party. All third-party material is credited.

                                    </div>
                                </div>
                            </div>
                            <!-- /.panel -->
                            
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">

					    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">

						6. Abuse

					    </a>

					</h4>
                                </div>
                                <div id="collapseSix" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        The internet and computers have made it easier for people to anonymously attack other people. This has led to many serious incidents of cyberbullying involving all demographics. 
                                        
                                        Any abuse or harassment conducted on our site is considered inappropriate behaviour and is taken very seriously. We encourage you to report any unlawful, malicious, or outright inappropriate players, games, and reviews.

                                        Cyberbullying is a form of bullying or harassment over the internet and is a common problem among youngsters. As the demographic will likely be young adults and children, cyberbullying may become a serious problem, as the Protection from Harassment Act 1997 and Crime and Disorder Act 1998 may apply as cyberbullying laws in terms of harassment and/or threatening behaviour.

                                        Spam is considered a digital form of harassment that causes distress and frustration to our clientele. This includes repeated posting of material, even when asked by others to stop. This also includes commercial promotions. It is recommended that ongoing incidents involving spam be reported.

                                    </div>
                                </div>
                            </div>
                            <!-- /.panel -->

                        </div>
                        <!-- /.panel-group -->


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
