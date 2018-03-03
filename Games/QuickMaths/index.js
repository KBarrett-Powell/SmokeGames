/* Author: Benedict Uttley
   Last Revision: 13/02/2018
   Version 1.1
   */

/* The code contained in index.js sets up a web server using the Node js run time environment. I have created a set of functions that allow simple
   client to server communication. Although the functions actual data will change (perhaps only slightly) from game to game, the structure can be used
   as the foundation of most of the games we will make.*/

/* For this simple maths game and games in the future, a number of tools have been used in addition to the basic Node install. Firstly to make the 
   creation of the web server easier, the express framework has been used which just makes the same functionality possible in fewer lines and it makes
   tasks like serving the html pages to the users much easier. Secondly, what has made this multiplayer game creation not only possible but fast to
   create is the use of Socket.io which is a javascript library that allows for bi-directional communication between the users web browser and the 
   server but also makes this communication real time, which is what gives it an interactive feel. It basically manages socket connections meaning
   when a new user connects (at the moment just to localhost:8080 on my computer) they have a socket created for them. This socket is like a 
   communication channel between them and the server. This means that you can essentially send messages from server to client (or server to all 
   clients, a broadcast) and from client to server.*/

 /* When you have installed node you can install express and socket.io from the command line using the node package manager(npm). For example to 
    install socket.io you would type npm install socket.io and it should then be installed.*/

//////////////////////////////////////////////////////////// CODE START //////////////////////////////////////////////////////////////////////////

/*  Firstly we define the main variables of the application which are needed regardless of the game logic or numer of players the game is for, 
    meaning that every game should have these as they are needed to create the http server and use sockets*/

// We use express to set up the application
var express = require('express');
var app = express();
// We create the http server 
var server = require('http').createServer(app);
// We use sockets for our communication and the sockets will communicate on the server created above
var io = require('socket.io').listen(server);


// This module is needed for this application as the game creates random usernames, the moniker module is used to generate these names 
var Moniker = require('moniker');

// Here we declare the file we want to send to the client when a new user connects to the server, in this example it is index.php
app.get('/', function(req,res) {
	res.sendFile(__dirname + '/index.php');
});
// We will run the web server on port 8080 which is the standard for a web server application
server.listen(process.env.PORT || 8080);



/* This is the first use of socket.io in this application. io.sockets.on() is used when you are referring to all connections, so all the current
   players in the maths game. Here we are saying that when a new connection is established (which is detected automatically) then a socket is
   created for that connection and this socket is unique to that client. */

io.sockets.on('connection', function(socket){
	
	// Print out a log indicating there has been a new connection, just useful for testing
	console.log("Successful Connection!");

	// Here is where a new users state, in this case their name and current score(which will be initially zero) are set in the function addUser()
	// which is defined below, the new user values are stored in a variable user so that they can be displayed to the client.
	var user = addUser();
	// Here is the first use of emit, emit is a message and when it is socket.emit, then this means that a message is being sent to one client
	// only which will be the one defined by the socket argument passed in when the connection is established
	// Here the emit has a label of "Welcome", if you go to page .html you will see code starting with socket.on("Welcome", ...) which is acting as 
	// a listener waiting that causes some code to execute in the listener body. It is useful to imagine socket.on as listen and socket.emit as speak.
	// The second argument of socket.emit is the data to be sent across to the client, in this case we are sending the contents of the user variable
	// which if we remember is the state of the user (name and score).
	socket.emit("Welcome", user);

	// Method  to add new user to a list that contains all the connected users of the game.
	updateUsers();
	
	// Here socket.on (listening) is used to call a function that removes a user from the list of users when a user disconnects. If the user closes
	// the tab or turns off their computer, the connection is severed and so this disconnect listener is activated.
	socket.on('disconnect', function(){
		removeUser(user);
	});


	// Here we listen for an emit from a individual client containing their answer to the current question and check their answer against the actual 
	// answer, if it is correct then the server issues an emit to every connected user and the data attatched to that emit is a string containing the 
	// name of the user who answered the question correctly.
	// Finally we call the updateQuestion() function which will generate a new question and emit it to all users

	// Remember: io.sockets.emit is a message to all connected users
	// Remember: socket.emit is a message to one connected user (therefore socket.emit is contained within the connection body otherwise we would not
	// know who this user is).


	

	// Most of the code below is relates to the game logic but the code above is fairly core to whatever game you are creating



	socket.on('mathAnswer', function(data) {

		if(data == Gl_ans){
			user.score +=1;
			io.sockets.emit("corr_ans", { message: "<strong>" + user.name + "</strong> got it correct!" } );
			updateQuestion();
			
		};


		// First user to answer 10 questions correctly wins the game
		if(user.score == 10){
			io.sockets.emit("gameWon", { message: "<strong>" + user.name + "</strong> won the game!" });
			endGame();

		};

		updateUsers();

	});

});


// Initialise variables that will hold the games state
var initialWidth = 50;
var currentWidth = initialWidth;
var winWidth = 600;
var users = [];
var Gl_ans = 0;



// When a new user connects to the game, this function is called which creates a new entry containing the state for that player. The entry 
// is then added to the list of users, Moniker.choose() generates a random name
var addUser = function() {
		var user = {
		name: Moniker.choose(),
		clicks: 0,
		score: 0
	}
	
	users.push(user);


	// Currently when the number of users is equal to 2, the game is started. However in future versions I hope to not have this hard coded but
	// rather let the user decide how many users they want to play with and then be added to the appropriate game.
	if(users.length == 2){


		// Future Changes...
		// Game logic and variables for those two players may have to be put in a function that is called 'inside'
		// the chatroom like environment and then the outer users.length could be reset to 0 for the next two players to
		// join


		// When the number of users is equal to 2, the game is started
		startGame();
}

	return user;
};

// Function to remove a user from the list of users when they have disconnnected
var removeUser = function(user){
	for(var i=0; i<users.length; i++){
		// Iterate through list of users until correct user is identified...
		if(user.name === users[i].name){
			// Removing user entry from list of users...
			users.splice(i,1);
			console.log("User: " + user.name + " has left the game");
			updateUsers();
			 
		};
	};

	// Here we check that if the number of users after a user has left is equal to 1, we end the game as the user has not other players to 
	// play against and so they automatically win.
	if(users.length == 1){
		
	endGame();
	return;
};



};

/*Function to update the array of users, this function could be called when an existing user leaves or when a new user joins. Then we send a emit
  to all the currently connected users with the updated array of users. Tis function is useful as it means that we can essentially display the current
  users in the game so that a player knows the username and score of the players they are against.*/
var updateUsers = function(){
	var str = '';
	var gUsers = [];
	for(var i=0; i<users.length; i++){
		var user = users[i];
		str += user.name + ' (' + user.clicks + ' clicks)' + ' (' + user.score + ' score)';
		gUsers.push(user.name);
		gUsers.push(user.score);
	};
	// Broadcast all the user names of the users that are in the game to all of the users...
	io.sockets.emit("users", {users: gUsers});
}


// Function to update all users with the current width of the div
var updateWidth = function() {
	io.sockets.emit("update", {currentWidth: currentWidth});
}


/* This function generates a simple random maths question that contains either a +, -, * or / operation.
   The function also calculates the correct answer so that it can be compared with the users submitted 
   answers so that we know when the user has achieved the correct answer and update the game state accordingly.*/
function updateQuestion(){
	console.log("");
	var a = Math.floor(Math.random() * 10) + 1;
	var b = Math.floor(Math.random() * 10) + 1;
	var op = ["*", "+", "/", "-"];
	// Choose an operator from the above list at random...
	var opChoice = [Math.floor(Math.random()*4)]
	var answer = eval(a + op[opChoice] + b);
	console.log("How much is " + a + " " + op[opChoice] + " " + b + "?");
	// Logging the answer to the current question for tetsing purposes...
	console.log("Answer to current question is: " + answer);
	Gl_ans = answer;
	// Broadcast the new question to all connected users...
	io.sockets.emit("newQuestion", "How much is " + a + " " + op[opChoice] + " " + b + "?");
}

// The function emits a message informing all connnected users that the game has started which causes users 
// loading screens to be hidden and for the game to be displayed.
function startGame(){
	io.sockets.emit("gameStarted", true);
	updateQuestion();
}

/* This function is called when a user has answered 10 questions correctly and when executed a message is sent to all
   the current users that the game is ended. In future versions this will result in the user being routed back to a main
   menu where they can search for another game or exit the game. */
function endGame(){
	console.log("endGame() is called");
	io.sockets.emit("gameEnded", true);
}



/*Just a quick overview of what has happened in the above core functions:

  The addUser function creates a new user with a unique random name and appends it to the array called users.
  The removeUser function removes a given user form the array called users.
  The updateUsers function sends a string containing a list of all the current users in the game including the users name and score.*/
