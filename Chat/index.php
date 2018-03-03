<!-- Author: Benedict Uttley
	 Last Revision: 13/02/2018
	 Version 1.1 -->

<!-- This html file is served to users upon connection. It essentially consists of three elements. The CSS for some extremelly simple styling. Secondly there is the javascript which contains emits to the node server and there are also listeners that listen for incoming messages from the node server. Finally there is the HTML which is very simple. The HTML mostly consists of divs that contain various data such as the question, others that will increase in size, the size for a div increase when the corresponding user that the div represents answers a question correctly. -->

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="emojionearea.min.css" media="screen">
	<script type="text/javascript" src="emojionearea.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title>Real time game</title>


<style>  .span6{
		float: left;
		width: 250px;
		display: inline-block;

	}

	.emojionearea-editor:not(.inline) {
		min-height: 30px!important;
		max-height: 100px!important;
	}




	body{
			padding: none;
			background-color:#13133a;
			font-family: 'Times New Roman';
			color: white;
			margin:0px;
	}
	#container{
 vertical-align:top;
 position: absolute;
 width: auto;
border-right: 2px solid white;
 margin: none;
 height: 100%;
 padding: 8px;

	}

	#emoji_list{
			width: 250px;
			height: 50px;
			background-color: white;
	}
	#game{
		position: absolute;
		right: 500px;
		width: 600px;
		height: 600px;
		border: 5px solid white;
	}
	#texttest{

	height: 100px;
	overflow: auto;
	width: 250px;

	}

	.messagesnew{
		width: 220px;
		background-color: #13133a;
		margin: 8px;
		padding: 4px;
		border-radius: 5px;
		display: inline-block;
		word-wrap: break-word;
		white-space: pre-wrap;
		font-size: 10px;

	}
	.j{
		width: 250px;
		resize: none;
		font-family: 'Times New Roman';


	}
	.ts{
		background-color: white;
		width: 250px;
		height: 300px;
		overflow-y: scroll;
		overflow-x: hidden;
	}

	/* width */
	::-webkit-scrollbar {
			width: 10px;
	}

	/* Track */
	::-webkit-scrollbar-track {
			background: #f1f1f1;
	}

	/* Handle */
	::-webkit-scrollbar-thumb {
			background: #888;
	}

	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
			background: #555;
	}
</style>













	<style type="text/css">
		html,
		body {
			margin: 0;
			padding: 20px;
			font-family: Tahoma;
			font-size: 14px;

		}


		#gameWindow {

			border: 3px solid black;
			padding: 20px;
			position: absolute;
			margin: auto;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
			width: 800px;
			height: 600px;


		}

		#QuestionAnswer {

			border: 3px solid black;
			padding: 5px;
			display: inline-block
		}

		#progress {
			cursor: pointer;
			background: #61AC33;
			padding: 10px;
			text-align: right;
			font-weight: bold;
			color: #FFF;
		}

		#progress:active {
			color: #FFF;
			background: #000;
		}

		#win {
			width: 600px;
			padding: 10px;
			text-align: right;
			font-weight: bold;
			border-right: solid 1px #000;
		}

		#Div1 {

			cursor: pointer;
			background-color: Red;
			padding: 10px;
			text-align: right;
			font-weight: bold;
			color: #FFF;
			width: 80px;

		}

		#Div2 {

			cursor: pointer;
			background-color: Green;
			padding: 10px;
			text-align: right;
			font-weight: bold;
			color: #FFF;
			width: 80px;


		}
	</style>

	<style>
		#loader {
			position: absolute;
			left: 50%;
			top: 50%;
			z-index: 1;
			width: 150px;
			height: 150px;
			margin: -75px 0 0 -75px;
			border: 16px solid #f3f3f3;
			border-radius: 50%;
			border-top: 16px solid #3498db;
			width: 120px;
			height: 120px;
			-webkit-animation: spin 2s linear infinite;
			animation: spin 2s linear infinite;
		}

		/* Safari */

		@-webkit-keyframes spin {
			0% {
				-webkit-transform: rotate(0deg);
			}
			100% {
				-webkit-transform: rotate(360deg);
			}
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}
			100% {
				transform: rotate(360deg);
			}
		}
	</style>

	<script src="/socket.io/socket.io.js"></script>


	<script type="text/javascript">

// Chat code...

$("#facea").click(function() {
  $("#texttest").append('<img src="https://cdn.okccdn.com/media/img/emojis/apple/1F60C.png"/>');
});


// set-up a connection between the client and the server

// set-up a connection between the client and the server


$(document).ready(function() {
	$("#example1").emojioneArea({

		events: {
			keydown: function(editor, event) {
				// catches everything but enter
				if (event.which == 13) {
					$('#rs').append(this.getText());
					socket.emit('clientMessage', this.getText());
					 $("div.emojionearea-editor").data("emojioneArea").setText('');
					 event.preventDefault();
					 return false;
				} else {

				}
			}
		},
		autocomplete: false,
		 emojiPlaceholder: ":smile_cat:",
		 useInternalCDN: true,
		 buttonTitle: "Browse emoji's!",
			pickerPosition: "left",
		 search: false,
		 tones: false,

		 textcomplete: {
			maxCount  : 5,
			placement : 'absleft'
	},

attributes: {
		 spellcheck : true,

	 }
 }
);
});








		/* The front-end part of the game involves connecting the client to the http server that node provides, on port 8080.
					   There are also several listeners that update various div containers when the listener is triggered as a result of an
					   emit from the server.*/

		var socket = io();



		var username = prompt('What username would you like to use?');
		var playerName = username;



		var room = prompt('Lobby to join:');
		socket.on('connect', function() {
			// Connected, let's sign-up for to receive messages for this room
			socket.emit('login', username);
			console.log('logged in as: ' + username);
			socket.emit('room', room);
			console.log('Chat Room: ' + room);

		});


			window.onload = function() {

				socket.on('message', function(content) {
					console.log('MESSAGE IS MEANT TO BE:' + content);
					addMessage(content);
				});



			// Assigning the HTML elements to be used to variables...
			var welcome = document.getElementById("welcome");
			var allUsers = document.getElementById("users");
			var results = document.getElementById("results");

			var messagesElement = document.getElementById('logged_in_users');
			console.log("logged in users div: " + messagesElement);
			var messagesElement2 = document.getElementById('messages');
			var lastMessageElement = null;
			var lastMessageElement2 = null;

			function addMessage(message) {
				console.log('MESSAGE IS MEANT TO BE:');
				var newMessageElement = document.createElement('div');
				newMessageElement.className="messagesnew";
				console.log(lastMessageElement);
					lastMessageElement
				var newMessageText = document.createTextNode(message);

				newMessageElement.appendChild(newMessageText);
				messagesElement.insertBefore(newMessageElement,
					lastMessageElement);
				lastMessageElement = newMessageElement;
				var elem = document.getElementById('logged_in_users');
				elem.scrollTop = 0;
			}





			// We make the socket connection to the web server that is on port 8080
			//var socket = io();

			// Global Variable to store name of player


			// 	Display maths question in container held within this variable
			var mQuestion = document.getElementById("mathsQuestion");


			/* When a 'welcome' emit is sent from the node server then the contents of the welcome div is updated
			   to contain the username of the player. The data property has compnents including the name of the
			   player and the current score of the player which will be zero initially.*/
			socket.on('Welcome', function(data) {
				welcome.innerHTML = "<br> Welcome to the game <strong>" + data.name + "</strong>";
				//playerName = data.name;
			});

			socket.on("recieved", function(data) {
				console.log(data);
			});


			// When a 'users' emit is sent from the node server, the contents of the allUsers div is updated
			// to contain a list of the current users in the game.
			socket.on('users', function(data) {
				console.log("activated");
				allUsers.innerHTML = "";
				console.log(data.length);
				for (var i = 0; i < data.length; i++) {
					console.log(data[i].name);
					console.log(playerName);
					var user = data[i].name;
					var user_score = data[i].score;

					// Create a div for each player
					var newDiv = document.createElement("div");
					newDiv.setAttribute("id", "Div1");

					/*If the user currently selected on this iteration is the same as the username of the player then
					  give the player a different div with a different style. This style has a green background and
					  differentiates the players div from the otehr players div which is red.*/
					if (user == playerName) {
						console.log("style should be added...");
						newDiv.setAttribute("id", "Div2");
					};
					newDiv.setAttribute("style", "width:" + ((user_score * 50) + 100) + "px");
					newDiv.innerHTML = "<strong>Users:</strong><br />" + user + " " + user_score;
					allUsers.appendChild(newDiv);
					var br = document.createElement("br");
					allUsers.appendChild(br);

				};

			});



			// When a 'win' emit is sent from the node server then the contents of the results div is updated
			// so that it displays a message stating who answered the question correctly.
			socket.on('win', function(data) {
				results.innerHTML = data.message;
			});

			socket.on('test', function(data) {
				prompt('Welcome to the room: ' + data);
			});
			/* When the user answers 10 questions correctly the server emits a gameWon emit and the game winner
			   div is updated so that it displays a message stating who the winner of the game was. In future
			   versions i hope to have a game stats or leaderboard table will be shown. */

			socket.on('gameWon', function(data) {
				gameWinner.innerHTML = data.message;
			});



			// Update the div to contain the new question sent from the node server
			socket.on('newQuestion', function(data) {
				mQuestion.innerHTML = "<strong>Maths Question:</strong><br />" + data;
			});


			// When a user clicks the submit button, then contents of the input field is retrieved and sent to the node
			// server for evaluation (is it corect or incorrect).
			mAnswer.onclick = function myAnswer() {
				var ans = document.getElementById("myAnswerToQuestion").value;
				socket.emit('mathAnswer', {
					answer: ans,
					player: playerName
				});
			}

			// If a user has correctly answerd a question, a div is updated so that it displays the message that contains the
			// username of the user who answerd the question correctly.
			socket.on('corr_ans', function(data) {
				mathsWinner.innerHTML = data.message;
			});

			/* Start game when enough users have joined. Currntly this just means hiding the loading screen and displaying the game
			   window. In future versions i will make a sort of waiting lobby that then closes (or a new html page is displayed) when
			   the start game emit is recieved. */
			socket.on('gameStarted', function(data) {
				console.log("WTF IS GOING ON!!??");
				document.getElementById('loader').style.display = "none";
				document.getElementById("gameWindow").style.display = "block";
			});

			/* When the game is over and the emit is recieved, the game window is hidden and the final stats div, that still needs to be
			   developed, is displayed to the user. There eill then need to be options displayed including finding a new game or exiting
			   the game (bare minimum). */
			socket.on('gameEnded', function(data) {
				console.log("Game Over!");
				document.getElementById("gameWindow").style.display = "none";
				//document.getElementById('finalStats').style.display = "block";
				window.location.href = data;
			});


			/* Listener that will result in a player being allocated a new game after they have chosen to find a new game. Currently no action
			   is performed when a user chooses to find a new game. This will be integrated into the final stats display and when clicked, it
			   should be possible for the user to join a new game. */
			fGame.onclick = function newGame() {

				// Player would be entered into a new game lobby...
			};
		}
	</script>

</head>




<body class="main">

	<!-- This div is the loading screen which is shown untill enough players have joined the game -->
	<div id='container'>

	    <h5 id='roomName'></h5>
	    <h5 id='uname'></h5>



	  <div  id='logged_in_users' class="ts" >
	  </div>

	<br/>


	<div class="span6" id="lol">
	<textarea id="example1"></textarea>
	</div>


	</div>

	<div id="loader" class="loader"></div>

	<!--Div displayed to winner of game when they have scored 10 points -->
	<div id="finalStats" style="display:none;">
		<p>You are the winner of the game, congratulations!</p>
		<br>

		<!-- Form to search for new game when you are only player left in game, this can eventually just be that
				 the player is routed to the main menu but is awarded winner points. In addition this form will need
				 to be integrated into the final stats display -->
		<form id="findGame">
			<input id="fGame" type="button" value="Find New Game">
		</form>

	</div>

	<div id="gameWindow" style="display:none;">


		<h1>Maths Question Game</h1>
		<h5> This is a maths game where the first player to correctly answer all 10 questions is the winner of the game. The green rectangles will show yours and others' progress!</h5>
		<br>


		<!-- Shows the user the latest maths question-->
		<div id="QuestionAnswer">
			<div id="mathsQuestion"></div>
			<br>
			<!-- Allows user to enter answer for the currently displayed question -->
			<form id="answerForm">
				Enter Answer: <input type="text" id="myAnswerToQuestion">
				<input id="mAnswer" type="button" value="Submit Answer">
			</form>
		</div>


		<!-- Welcome container will show welcome message and the username of the current user -->
		<div id="welcome"></div>
		<!-- A marker to indicate where the endpoint of the growing div is -->
		<div id="win">10 points</div>

		<!-- Shows the current users and the number of clicks they have done -->
		<div id="users"></div>

		<!-- Shows the user that won the latest game-->
		<div id="results"></div>


		<!-- Shows the user the latest maths question-->
		<div id="mathsWinner"></div>



		<div id="gameWinner"></div>
	</div>
</body>

</html>
