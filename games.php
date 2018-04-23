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
        Smoke Games - Homepage
    </title>

    <?php include "references.php"; ?>

</head>

<body>
    <?php include "navigation.php"; ?>

    <div id="all">

        <div id="content">

            <!-- Games listing -->
            <div id="allGames">

                <div class="box">
                    <div class="container">
                        <div class="col-md-12">
                            <h2>All Games</h2>
                        </div>
                    </div>
                </div>

                <!-- forms for the sort and filters for the games -->
                <div class='forms'>

                    <form id="filterForm" method="POST" action="<?php $_SERVER['PHP_SELF']?>">

                        <!-- filter by type of game - NOT IMPLEMENTED YET-->
                        <select name='filterby'>
                            <option value=''>All</option>
                            <option value='action'>Action</option>
                            <option value='arcade'>Arcade</option>
                            <option value='multi'>Multi-Player</option>
                            <option value='puzzle'>Puzzle</option>
                            <option value='shooter'>Shooter</option>
                            <option value='sports'>Sports</option></select>
                        <input type="submit" value="Filter">
                    </form>

                        <!-- sort by several different options - NOT FULLY INTEGRATED as we havent started storing other options in database-->
                    <form id="sortForm" method="GET" action="<?php $_SERVER['PHP_SELF']?>">

                        <select name='sortwhat'>
                                <option value='Gname'>Name</option>
                                <option value='Popularity'>Popularity</option>
                                <option value='Rating'>Rating</option>
                                <option value='Recommended'>Recommended</option></select><br>

                        <select name='sorthow'>
                                <option value='ASC'>Ascending</option>
                                <option value='DESC'>Descending</option></select>
                        <input type="submit" value="Sort">
                    </form>
                </div>
                
                <div id='hot'> 
                    <div class="container">
                        <div class="product-slider">
                    
                            <?php
                                try{
                                    include "config.php";

                                     // This SQL query defines how the items are sorted and what they are filtered by
                                    if (isset($_POST['sortwhat']) && isset($_POST['filterby'])) {
                                        $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE Category LIKE '%?%' ORDER BY ? ? ");
                                        $retrieve->execute([$_POST['filterby'], $_POST['sortwhat'], $_GET['sorthow']]);
                                    } else if (isset($_POST['sortwhat'])) {
                                        $retrieve = $gamesdb->prepare("SELECT * FROM Games ORDER BY ? ?");
                                        $retrieve->execute([$_POST['sortwhat'], $_POST['sorthow']]);
                                    } else if (isset($_POST['filterby'])) {
                                        $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE Category LIKE '%?%' ORDER BY Gname ASC");
                                        $retrieve->execute([$_POST['filterby']]);
                                    } else {    
                                        $retrieve = $gamesdb->prepare("SELECT * FROM Games ORDER BY Gname ASC");
                                        $retrieve->execute();
                                    }
                                    
                                    if ($retrieve->rowCount() > 0) {
                                        foreach ($retrieve as $row) {
                                            $id = $row["GameID"];
                                            $name = $row["Gname"];
                                            $img = $row["Gimg1"];
                                            $flip = $row["Gimg2"];
                                            echo "<div class='item'><div class='product'><div class='flip-container'>";
                                            echo "<div class='flipper'><div class='front'>";
                                            echo "<a href='detail.php?id=$id'><img src='$img' alt='' class='img-responsive'></a></div>";
                                            echo "<div class='back'><a href='detail.php?id=$id'><img src='$img' alt='' class='img-responsive'></a></div></div></div>";
                                            echo "<a href='detail.php?id=$id' class='invisible'><img src='$img' alt='' class='img-responsive'></a>";
                                            echo "<div class='text'><h3><a href='detail.php?id=$id'>$name</a></h3><p class='price'>PLAY!</p>";
                                            echo "</div></div></div>";
                                        }
                                        echo "</div></div>";
                                    } else { echo "No results";}

                                }catch(PDOException $e) {
                                    echo "Connection failed: " . $e->getMessage();
                                }
                                $gamesdb = null;
                            ?>
                    


                            </div>
     
                        </div>

                    </div>

                </div>

            </div>

        </div>

    <!-- footer -->
    <?php include "footer.php"; ?>
</body>

</html>