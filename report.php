<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Smoke Games - Report User
    </title>

    <?php 
        include "references.php"; 
        include "require.php";
        $rUser = $_GET['id'];

        try{
            include "config.php";

            // Collecting info on current user
            $retrieve = $gamesdb->prepare("SELECT * FROM Users WHERE UID = ?");
            $retrieve->execute([$rUser]);
    
            if ($retrieve->rowCount() == 1 && isset($_SESSION['id']) && $_SESSION['id'] != $rUser) {
                $retrieve = $gamesdb->prepare("SELECT * FROM Profiles WHERE UID = ?");
                $retrieve->execute([$rUser]);

                $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                $pname = $row['ProName'];
            } else {
                echo "<script type='text/javascript'>location.href = '404.php';</script>";
            }

        } catch(PDOException $e) {
            echo "<script type='text/javascript'>location.href = '404.php'";
        }
        $gamesdb = null;

        // Checking description of report alright for database
        function verifyReport() {
            $desc = $_POST['desc'];
            $errors = array();

            // Checking description doesn't include any tags
            if ($desc != strip_tags($desc)) {
                array_push($errors, ' Please don\'t use tags in your description');
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

                <div class="col-md-12">

                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <?php echo "<li><a href='profile.php?id=$rUser'>$pname</a></li>"; ?>
                        <li>Reports</li>
                    </ul>

                </div>
                
                <div class="col-md-3">
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <?php echo "<h3 class='panel-title'>$pname</h3>"; ?>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <?php echo "<a href='profile.php?id=$rUser'>Profile </a>"; ?>
                                </li>
                                <li class="active">
                                    <a href="#">Report User</a>
                                </li>
                            </ul>     
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="box">
                        <?php echo "<h1>Reporting $pname</h1>"; ?>

                        <p class="lead">Please enter the reason for report, and a description of the specific activity that lead you to report this user.</p>

                        <hr>

                        <?php echo "<form action='report.php?id=$rUser' method='post'>"; ?>
                            <div class="form-group">
                                <label for="reason">Report <span class="required">*</span></label>
                                <select class="form-control" name='reason'>
                                    <option value="Aggressive Language">Aggressive Language</option>
                                    <option value="Threatening Another User">Threats</option>
                                    <option value="Suspicious Activity">Suspicious Activity</option>
                                    <option value="Harrassment">Harrassment</option>
                                    <option value="Other">Other (please explain below)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea class="form-control" id="desc" name="desc" rows="4"></textarea>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit" value="Report" name="report_user"><i class="fa fa-sign-in"></i> Send Report</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<?php 
    try{
        include "config.php";
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            // If login form has been filled out:
            if(isset($_POST['report_user'])) {
                $rErrors = verifyReport();
                if (empty($rErrors)) {
                    $report = $_POST['reason'];
                    $desc = $_POST['desc'];

                    // Create new report id for the report
                    $retrieve = $gamesdb->prepare("SELECT max(ReportNum) FROM Reports");
                    $retrieve->execute();
                    $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                    $rid = $row["max(FID)"] + 1;

                    // Insert new report into database
                    $retrieve = $gamesdb->prepare("INSERT INTO Reports(ReportNum, UID1, Report, RDesc, UID2) VALUES (?, ?, ?, ?, ?)");
                    $retrieve->execute([$rid, $rUser, $report, $desc, $_SESSION['id']]);

                    echo "<script type='text/javascript'>alert('Report successfully filed.'); location.href = 'index.php';</script>";
                }
            } else {
                echo "<script type='text/javascript'>alert(". json_encode($rErrors) .");</script>";
            } 
        }
    }catch(PDOException $e) {
        echo "<script type='text/javascript'>location.href = '404.php'";
    }
    $gamesdb = null;
?>
</div>

<?php include "footer.php"; ?>
    
</body>
</html>