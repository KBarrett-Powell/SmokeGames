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
      include "require.php";

      $id = $_GET['id'];
        try {
          include 'config.php';
          $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE GameID = ?");
          $retrieve->execute([$id]);

          if ($retrieve->rowCount() == 1) {
            $row = $retrieve->fetch(PDO::FETCH_ASSOC);

            $gname = $row["Gname"];
            $desc = $row["Description"];
            $img = $row["Gimg1"];
            $category = $row["Category"];
            $age = $row["AgeRating"];
            $credit = $row["Credits"];
          } else {
            echo "<script type='text/javascript'>location.href = '404.php';</script>";
          }

        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
	?>
	
	<script>
        function test(game_type) {

          var game_name = <?php echo $gname; ?>;
          var game_username = <?php echo $_SESSION['username']; ?>;
          var game_proname = <?php echo $_SESSION['proname']; ?>;

          // For now, allow user to pick username, will need to be provided from php code durinng integration...

          var form = document.createElement('form');
          document.body.appendChild(form);
          form.method = 'post';
          form.action = 'https://'+ game_name + '.smoketestergames.co.uk' // Need lookup for game address, will be subdomain ie.'https://pong.smokegames.co.uk'

          var input_name = document.createElement('input'); // Username.
          input_name.type = 'hidden';
          input_name.name = 'user[name]';
          input_name.value = game_username;
          form.appendChild(input_name);

          var input_type = document.createElement('input'); // Private or public lobby.
          input_type.type = 'hidden';
          input_type.name = 'lobby[type]';
          input_type.value = game_type;
          form.appendChild(input_type);

          var input_type = document.createElement('input'); // If Private, then the name of the lobby to join.

          let lobby_name = document.getElementById('input_lobby').value;

          input_type.type = 'hidden';
          input_type.name = 'lobby[name]';
          input_type.value = lobby_name;
          form.appendChild(input_type);

          form.submit();
        }
    </script>
</head>

<body>
  <?php include "navigation.php"; ?>

   <div id="all">
        <div id="content">
            <div class="container">

                <!-- Links back to home page -->
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="games.php">Games</a></li>
                        <li><?php echo "Play $gname"; ?></li>
                    </ul>
                </div>

				<div class="col-md-9">
					<div class="row" id="productMain">

						<div class="col-sm-6">
							<div id="mainImage">
								<img src="<?php echo $img; ?>" alt="" class="img-responsive">
							</div>
						</div>

						<div class="col-sm-6">

							<div class="box">
								<h1 class="text-center"><?php echo $gname; ?></h1>
								<hr>

								<div class="form-group">
									<h4>Play random game:</h4>
									<button class="btn btn-primary" style="float: right; margin-bottom: 5%" onClick="test('Random')" id="Pong" value="Pong">Random Game</button>
								</div>
								<br>
								<div class="form-group">
									<label for="lastname"><h4>Create private game: </h4></label>
									<input placeholder="Enter name"  type="text" class="form-control" id="input_lobby">
									<button class="btn btn-primary" style="float: right; margin-top: 2%" onClick="test('Private')" id="Pong" value="Pong">Private Game</button>
								</div>
							</div>
						</div>
					</div>
				</div>

                <div class="col-md-3">
                    <div class="panel panel-default sidebar-menu">

                        <!-- Display high scores for this game --> 
                        <div class="panel-heading">
                            <h3 class="panel-title">Leaderboards</h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked category-menu">
                                <li>
                                    <?php
                                        try {
                                            include "config.php";
                                            
                                            // Retrieve top 10 scores from the Scores table
                                            $retrieve = $gamesdb->prepare("SELECT Uname, Score FROM Scores WHERE GameID = ? ORDER BY Score DESC LIMIT 10");
                                            $retrieve->execute([$_GET['id']]);

                                            if ($retrieve->rowCount() > 0) {
                                                echo "<a href='#'>High Scores: <span class='badge pull-right'></span></a><ul>";
                                                foreach ($retrieve as $row) {
                                                    // For each score retrieved, display the name of the user, and their score
                                                    $uname = $row['Uname'];
                                                    $score = $row['Score'];

                                                    $findpro = $gamesdb->prepare("SELECT ProName FROM Profiles WHERE Uname = ?");
                                                    $findpro->execute([$uname]);

                                                    $prow = $findpro->fetch(PDO::FETCH_ASSOC);
                                                    $pname = $prow['ProName'];

                                                    echo "<li style='margin-left:10%; margin-bottom:3%;'>$pname: $score</li>";
                                                }
                                                echo "</ul>";

                                            } else {
                                                // If no scores are found, display message informing user of this instead of leaving blank space
                                                echo "<a href='#'>--No Scores Found--</a>";
                                            }

                                        } catch(PDOException $e) {
                                            echo "Connection failed: " . $e->getMessage();
                                        }
                                        $gamesdb = null;
                                    ?>
                                </li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include "footer.php"; ?>
</body>
</html>