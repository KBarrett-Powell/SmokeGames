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
            echo "<script type='text/javascript'>location.href = '404.php'";
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
                        <?php 
                            try{
                                include "config.php";
                                $fileName = $gamesdb->prepare("SELECT fileName FROM Games WHERE GameID = ?");
                                $fileName->execute([$id]);
                                
                                if ($fileName->rowCount() > 0) { 
                                    foreach($fileName as $row) {
                                        $fName = $row['fileName'];
                                        echo $fName;
                                        echo "<script type='text/javascript'>location.replace('scriptGames/".$fName."/index.php')</script>";
                                        
                                        //include "scriptGames/" . $fName . "/index.php";
                                    }
                                }
                                
                            }
                            catch(PDOException $e) {
                                echo "<script type='text/javascript'>location.href = '404.php'";
                            }
                        ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include "footer.php"; ?>
</body>
</html>