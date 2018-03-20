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
    <style>
      div.navigation {
        border-style: hidden;
      }

      div.gameContainer {
        margin: auto;
      }

      div.game {
        width:1280px;
        height:720px;
        border-color: #555555;
        border-width: 1px;
        border-style: solid;
        margin: auto;
      }

      div.gameDetails {
        margin-bottom: 600px;
        margin-left: auto;
        margin-right: auto;
        width:1280px;
      }

      div.gameInfo {
        margin-top: 50px;
        float: left;
        width: 45%;
        margin: auto;
        width: 50%;
      }

      h2.gameInfo {
        font-size: 50pt;
        text-align: center;
      }

      h3.gameInfo {
        font-size: 36pt;
        text-align: center;
      }

      p.gameInfo {
        color: white;
        line-height: 20px;
      }

      div.gameReviews {
        float: right;
        width: 50%;
        padding-left: 50px;
      }

      table.reviews {
        color: white;
      }

      tr.reviews {
        margin-bottom: 15px;
        border-bottom: 2pt solid #555555;
      }

      td.reviews {
        padding: 10px;
        vertical-align: top;
      }

      p.reviews {
        line-height: 20px;
      }
    </style>
</head>

<body>
    <div class="navigation"><?php include "navigation.php"; ?></div>
    <div class="gameContainer" style="margin: auto; width: 100%;">
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
    </div>
    <div class="game">
      <?php
        //include "Games/MathsMania/page.html";
        //$sock = socket_create(AF_INET, SOCK_STREAM, 0); // create a streaming socket, of type TCP/IP
        //socket_bind($sock, 0, 8081); // "bind" the socket to the address to "localhost", on port $port
        //socket_listen($sock); // start listen for connections

        //exec('/usr/local/bin/node Games/MathsMania/start.js > /dev/null &');
        // so change the directory to where node is installed on the server. Also Games/'.str_replace(" ","",$GLOBALS['gameName']).'/start.js
        //exec("kill " . $processid);
        //socket_close($sock); // close the listening socket
        ?>
    </div>
  </div>

  <div class="gameDetails">
    <div class="gameInfo">
      <?php
        echo "<h3 class='gameInfo'>".$GLOBALS['gameName']." Game Details</h2><br>
        <p class='gameInfo' style='font-size: 14pt;'>".$GLOBALS['gameDesc']."</p><br><p class='gameInfo'>
        Category: ".$GLOBALS['gameCategory']."<br>
        Age Rating: ".$GLOBALS['gameAgeRating'] . "+<br>
        Credits: ".$GLOBALS['gameCredits']."<br>
        Tags: ".$GLOBALS['gameTags']."</p>";
      ?>
    </div>
    <div class="topScores">
    </div>
    <div class="gameReviews">
      <?php
      echo "<h3 class=\"gameReviews\" style=\"text-align: center;\">".$GLOBALS['gameName']." Reviews</h2><br><table class=\"reviews\">";

      //if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
      echo '<form id="reviewForm">
        <input type="text" id="review" placeholder="Be sure to leave a rating and a review to help us improve the Smoke gaming experience." style="width: 75%; height: 100px; color: black; padding-top: 0px"><br><br>
        <img src="images/logo.png" onclick="setRating(1)" width=75px>
        <img src="images/logo.png" onclick="setRating(2)" width=75px>
        <img src="images/logo.png" onclick="setRating(3)" width=75px>
        <img src="images/logo.png" onclick="setRating(4)" width=75px>
        <img src="images/logo.png" onclick="setRating(5)" width=75px>
        <input type="hidden" id="rating" value="">
        <p id="currentRating" style="display:inline;"></p>
        <input type="submit" name=submitReview value="Submit Review" alt="Submit review" onsubmit="validateReview()" style="color: black;">
      </form><br><br>';
      //} else { echo '<p>Log in to leave your own review.</p>'; }
      ?>
      <script>
        function setRating(num) {
          document.getElementById("rating").value = num.toString();
          document.getElementById("currentRating").innerHTML = "Your rating: " + num + "   ";
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
            echo "<img src=\"images/logo.png\" width=\"25px;\">";
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