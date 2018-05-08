<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>
        Smoke Games - Games
    </title>

    <?php include "references.php"; ?>

</head>

<body>
    <?php include "navigation.php"; ?>

    <div id="all">
        <div id="content">
            <div id="allGames">
                <div class="box">
                    <div class="container">
                        <div class="col-md-12">
                            <h2>All Games</h2>

                            <!-- forms for the sort and filters for the games -->
                            <form id="filterForm" method="POST" action="<?php $_SERVER['PHP_SELF']?>">
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <label for="filterby">Filter:</label>
                                        <select class="form-control" name='filterby'>
                                            <option value=''>All</option>
                                            <option value='Action'>Action</option>
                                            <option value='Arcade'>Arcade</option>
                                            <option value='Multi-Player'>Multi-Player</option>
                                            <option value='Puzzle'>Puzzle</option>
                                            <option value='Shooter'>Shooter</option>
                                            <option value='Sports'>Sports</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="sortwhat">Sort By:</label>
                                        <select class="form-control" name='sortwhat'>
                                            <option value='Gname'>Name</option>
                                            <option value='AvgRating'>Rating</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="sorthow">Order:</label>
                                        <select class="form-control" name='sorthow'>
                                            <option value='DESC'>Descending</option>
                                            <option value='ASC'>Ascending</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <h3 class='invisible'></h3>
                                        <button style='border:none; margin-top:7%; background-color: transparent;' type="submit" value="Sort">Filter & Sort</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div id='hot'> 
                    <div class="container">
                        <div class="product-slider">
                            <?php
                                try{
                                    include "config.php";
                                    
                                    // This SQL query defines how the items are sorted and what they are filtered by
                                    if($_SERVER["REQUEST_METHOD"] == "POST") {
                                        $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE Category LIKE ? ORDER BY ".$_POST['sortwhat']." ".$_POST['sorthow']."");
                                        $retrieve->execute(['%'.$_POST['filterby'].'%']);
                                    } else {
                                        $retrieve = $gamesdb->prepare("SELECT * FROM Games ORDER BY Gname DESC");
                                        $retrieve->execute();
                                    }
                                    
                                    if ($retrieve->rowCount() > 0) {
                                        foreach ($retrieve as $row) {
                                            $id = $row["GameID"];
                                            $name = $row["Gname"];
                                            $img = $row["Gimg1"];

                                            echo "<div class='item'><div class='product'><div class='flip-container'>";
                                            echo "<div class='flipper'><div class='front'>";
                                            echo "<a href='detail.php?id=$id'><img src='$img' alt='' class='img-responsive'></a></div>";
                                            echo "<div class='back'><a href='detail.php?id=$id'><img src='$img' alt='' class='img-responsive'></a></div></div></div>";
                                            echo "<a href='detail.php?id=$id' class='invisible'><img src='$img' alt='' class='img-responsive'></a>";
                                            echo "<div class='text'><h3><a href='detail.php?id=$id'>$name</a></h3><p class='price'><a href='detail.php?id=$id'>View Info</a></p>";
                                            echo "</div></div></div>";
                                        }
                                        echo "</div></div>";
                                    } else { echo "<h3 style='margin-left: 35%;'>--No results--</h3>";}

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
    <?php include "footer.php"; ?>
</body>
</html>