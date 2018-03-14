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

    <?php include "references.php"; ?>
	<link rel="stylesheet" type="text/css" href="css/GameFrameStyle.css">

</head>

<body>
    <div class="navigation"><?php include "navigation.php"; ?></div>
    <div class="gameContainer">
    <?php
		$gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
		if (!$gamesdb) { die("Failed to connect: " . mysqli_connect_error()); } 
		$retrieve = "SELECT * FROM Games WHERE GameID = " . $_GET["GameID"] . ";";
		$result = mysqli_query($gamesdb, $retrieve);

       	$gameInfo = mysqli_fetch_assoc($result);

       	$GLOBALS['gameName'] = $gameInfo["Gname"];
       	$GLOBALS['gameDesc'] = $gameInfo["Description"];
       	$GLOBALS['gameImg1'] = $gameInfo["GImg1"];
       	$GLOBALS['gameImg2'] = $gameInfo["GImg2"];
       	$GLOBALS['gameCategory'] = $gameInfo["Category"];
       	$GLOBALS['gameAgeRating'] = $gameInfo["AgeRating"];
       	$GLOBALS['gameCredits'] = $gameInfo["Credits"];
       	$GLOBALS['gameTags'] = $gameInfo["Tags"];
       	echo "<h2 class='gameInfo' style=\"color: white;\">$gameName</h2>";

      mysqli_close($gamesdb);
    ?>
    <div class="chat">
    	<?php
        //include "Games/MathsMania/page.html";
        // create a streaming socket, of type TCP/IP
        //$sock = socket_create(AF_INET, SOCK_STREAM, 0);
        // "bind" the socket to the address to "localhost", on port $port
        // so this means that all connections on this port are now our resposibility to send/recv data, disconnect, etc..
        //socket_bind($sock, 0, 8081);
        // start listen for connections
        //socket_listen($sock);

        // create a list of all the clients that will be connected to us..
        // add the listening socket to this list
        //$clients = array($sock);
        
        /*while (true) {
            // create a copy, so $clients doesn't get modified by socket_select()
            $read = $clients;
            
            // get a list of all the clients that have data to be read from
            // if there are no clients with data, go to next iteration
            if (socket_select($read, $write = NULL, $except = NULL, 0) < 1)
                continue;
            
            // check if there is a client trying to connect
            if (in_array($sock, $read)) {
                // accept the client, and add him to the $clients array
                $clients[] = $newsock = socket_accept($sock);
                
                // send the client a welcome message
                socket_write($newsock, "no noobs, but ill make an exception :)\n".
                "There are ".(count($clients) - 1)." client(s) connected to the server\n");
                
                socket_getpeername($newsock, $ip);
                echo "New client connected: {$ip}\n";
                
                // remove the listening socket from the clients-with-data array
                $key = array_search($sock, $read);
                unset($read[$key]);
            }
        }*/

        //exec('/usr/local/bin/node Games/'.str_replace(" ","",$GLOBALS['gameName']).'/start.js &', $output);
        exec('/usr/local/bin/node Games/MathsMania/start.js > /dev/null &');
        // so change the directory to where node is installed on the server
        //echo $output;
	    	//exec("kill " . $processid);


        // close the listening socket
        //socket_close($sock);
    	?></div>
	<div class="game">
	</div>
	</div>

	<div class="gameDetails">
		<div class="gameInfo">
			<?php
	       	echo "<h3 class='gameInfo'>".$GLOBALS['gameName']." Game Details</h2><br>
				<p class='gameInfo'>".$GLOBALS['gameDesc']."<br><br>
				Category: ".$GLOBALS['gameCategory']."<br>
				Age Rating: ".$GLOBALS['gameAgeRating'] . "+<br>
				Credits: ".$GLOBALS['gameCredits']."<br>
				Tags: ".$GLOBALS['gameTags']."</p>";
			?>
		</div>
		<div class="gameReviews">
      <?php
      echo "<h3 class=\"gameReviews\" style=\"text-align: center;\">".$GLOBALS['gameName']." Reviews</h2><br><table class=\"reviews\">";

      //if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
      echo '<form id="reviewForm">
        <input type="text" id="review" placeholder="Leave a review?" style="width: 75%; height: 100px; color: black; padding-top: 0px"><br><br>
        <img src="images/1star.png" onclick="setRating(1)" width=75px>
        <img src="images/1star.png" onclick="setRating(2)" width=75px>
        <img src="images/1star.png" onclick="setRating(3)" width=75px>
        <img src="images/1star.png" onclick="setRating(4)" width=75px>
        <img src="images/1star.png" onclick="setRating(5)" width=75px>
        <input type="hidden" id="rating" value="">
        <p id="currentRating"></p>
        <input type="submit" name=submitReview value="Review" alt="Submit review" onsubmit="validateReview()" style="color: black;">
      </form>';
      //} else { echo '<p>Log in to leave your own review.</p>'; }
      ?>
      <script>
        function setRating(num) {
          document.getElementById("rating").value = num.toString();
          document.getElementById("currentRating").innerHTML = "Your rating: " + num;
        }

        function validateReview() {
          var text = "";
          try {
            if (document.getElementById("newReview").value.length <= 10) {
              text += "Leave a brief review, please.\n"
            } if (rating == 0) {
              text += "Leave a 1-5 rating by clicking one of the Smoke icons."
            }
          } catch(err) {
            text = err.message + "\n\n";
          }
          if (text !== "") {
            window.alert(text);
          } else {
            submitForm();
            reviewForm.innerHTML = "Thanks for your review!";
          }
        }

        function submitForm() {
          var http = new XMLHttpRequest();
          http.open("POST", "./cgi-bin/ReviewAction.php", true);
          http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
          var params = "review=" + document.getElementById("review").value + "&rating=" + document.getElementById("rating").value;
          http.send(params);
        }
      </script>
      <noscript>Javascript is not enabled!</noscript>
      


      <?php
      $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
      if (!$gamesdb) { die("Failed to connect: " . mysqli_connect_error()); } 
      $retrieve = "SELECT * FROM Reviews WHERE GameID = " . $_GET["GameID"] . ";";
      $result = mysqli_query($gamesdb, $retrieve);

      if (mysqli_num_rows($result) <= 0) echo "<p style=\"text-align: center;\">No reviews for this game</p>";
      else {
        while ($row = mysqli_fetch_assoc($result)) {
          $date = $row['Date'];
          $uname = $row['Uname'];
          $rating = $row['Rating'];
          $review = $row['Review'];
          $retrieveProfilePic = "SELECT ProPic FROM Profiles WHERE Uname='".$uname."';";
          $resultProfilePic = mysqli_query($gamesdb, $retrieveProfilePic);
          $profilepic = mysqli_fetch_assoc($resultProfilePic);
          $profilepicfilename = $profilepic["ProPic"];
          echo "<tr class=\"reviews\"><td><img src=\"images/profilepictures/$profilepicfilename\" style=\"width: 75px;\"></td><td class=\"reviews\"><p class=\"reviews\"><b>$uname</b> posted on $date  <br>";

          for ($i = 1; $i <= $rating; $i++) {
            echo "<img src=\"images/1star.png\" width=\"25px;\">";
          }

          echo "<br>$review</p></tr>";
        }
        echo "</table>";
      }
      mysqli_close($gamesdb);
      ?>

    </div>
	</div>
	<div class="footer"><?php include "footer.php"; ?></div>

</body>
</html>