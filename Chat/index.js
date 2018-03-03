/*

TODO:
Make a leaderboard
Clean up code considerably! -- /// CURRENT TASK /// --> Due: 25th Febuary
Prevent users from joining when the game has begun -- for now an error message or redirect is adequate
Have dummy list of current lobbies that have spaces - 'could be in a view lobbies section'
Writing code to database



Author: Benedict Uttley
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

/////////// Game Class ///////////


var myGameInstances = []; // Stores the game instances so that the state of different game lobbies is not lost

class Game {

    // Setting up instance variables that store game state...
    constructor(roomId) {
        this.roomId = roomId; // --> Stores the unique id for the lobby, 'lobby = room' in our case and is reference throughout when we want to send messages
        //     from the server to every connection, 'user' of a particular room, such as updating the front end state for that room,
        //     but critically not for other rooms.

        this.Users = []; // --> Stores the games user's state including their username and score.
        this.gUsers = []; // --> Stores the socket objects and their respective names, which is used when removing a user from the game, on disconnect.
        this.initialWidth = 50;
        this.currentWidth = this.initialWidth; // Progress display settings for user (visually represents how close they, or others are to winning).
        this.winWidth = 600;
        this.Gl_ans = 0; // Stores the answer to the current question displayed to users, whcih is used to 'mark' user answers.
    }

    showUsers() {
        console.log("Number of players in the lobby: " + this.gUsers.length);
        if (this.gUsers.length == 3) { // Sets the maximum number of users needed to start the game, this should really be dynamic instead of hardcoded (user choice?)
            this.startGame(); // When number of users required has been met, the game is started and game logic starts execution.z
        }
    }

    addUsertoGame(socketId) { // When a new user has connected to a particular lobby, we add thre socketId and associcated name for reference in
        // various methods.
        this.Users.push(socketId);
        this.Users.push(name);

    }

    InformUserOfLobby(socket) {
        socket.emit("test", this.roomId);
    }


    // Game logic needs to be placed here and be in OO form...

    // Game state stored in the following instance variables...

    addUser(playerName) { // A new users state is strored in a user variable which is then added to the list of users.
        var user = {
            name: playerName,
            score: 0
        }
        this.gUsers.push(user);

        this.updateUsers();
    }

    // Method to remove a user from the list of users when they have disconnnected
    removeUser(user) {

        for (var i = 0; i < this.gUsers.length; i++) {
            // Iterate through list of users until correct user is identified...
            if (user == this.gUsers[i].name) {
                // Removing user entry from list of users...
                this.gUsers.splice(i, 1);
                console.log("User: " + user + " has left the game");
                this.updateUsers();

            };
        };

        if (this.gUsers.length == 1) {
            this.endGame();
        }
    }


    /*Method to update the array of users, this method is executed when an existing user leaves or when a new user joins. Then we send a emit
     to all the currently connected users with the updated array of users. This method is useful as it means that we can essentially display the current
     up to date list of users in the game so that a player knows the username and score of the players they are against.*/
    updateUsers() {

        // Broadcast all the user names of the users that are in the game to all of the users...
        console.log("Users present in the game: " + this.gUsers.length);
        io.sockets.in(this.roomId).emit("users", this.gUsers);
    };

    // This will cause the client loading screen to be hidden and the first question of the game generated by the updateQuestion() method
    startGame() {
        io.sockets.in(this.roomId).emit("gameStarted", true);
        this.updateQuestion();
    }


    /*This method is triggered in the case when there is only one user left in the game and so they win by default.
    IMPORTANT: This method will need to redirect the user back to the game page when the game ends so that they are not just stuck on the game
    page. In addition when the game is over the game instance needs it summary data written to the SQL database and it will then need to be removed
    from the myGameInstances array.*/
    endGame() {

        console.log("endGame() is called");
        var destination = '/home.html';
        io.sockets.in(this.roomId).emit("gameEnded",destination);
    }


    // This method is called when a user has submitted an answer and checks if it is correct. If the submitted answer is correct then an emit is
    // sent that will result in the client updating the view of the divs as to be longer for the one representing the user that has indeed answered
    // the question correctly.
    evalAnswer(data) {

        // need to get player info from gUsers...
        if (data.answer == this.Gl_ans) {
            console.log("correct answer supplied");
            for (var i = 0; i < this.gUsers.length; i++) {
                if (this.gUsers[i].name == data.player) {
                    this.gUsers[i].score += 1; // Increment the score for that player

                }

                // First user to answer 10 questions correctly wins the game
                if (this.gUsers[i].score == 10) {
                    io.sockets.emit("gameWon", {
                        message: "<strong>" + this.gUsers[i].name + "</strong> won the game!"
                    });
                    this.endGame();
                };
            }

            io.sockets.in(this.roomId).emit("corr_ans", {
                message: "<strong>" + data.player + "</strong> got it correct!"
            });
            this.updateQuestion(); // Now that a user has correctly answered the question we need to generate and transmit a new question, this is
            // done through the updateQuestion method.

        }
    }

    // This method generates a new question aswell as calculating the answer in advance so that it can be evaluated against submitted answers.

    updateQuestion() {
        console.log("");
        var a = Math.floor(Math.random() * 10) + 1;
        var b = Math.floor(Math.random() * 10) + 1;
        var op = ["*", "+", "/", "-"]; // One of four operators will be randomly chosen for the new question.
        // Choose an operator from the above list at random...
        var opChoice = [Math.floor(Math.random() * 4)]
        var answer = eval(a + op[opChoice] + b);
        console.log("How much is " + a + " " + op[opChoice] + " " + b + "?");
        // Logging the answer to the current question for tetsing purposes...
        console.log("Answer to current question is: " + answer);
        this.Gl_ans = answer;
        // Broadcast the new question to all connected users...
        io.sockets.in(this.roomId).emit("newQuestion", "How much is " + a + " " + op[opChoice] + " " + b + "?");
        console.log("Question for lobby: " + this.roomId + "How much is " + a + " " + op[opChoice] + " " + b + "?");
        io.sockets.in(this.roomId).emit('test', this.roomId);
        this.updateUsers();
    }
}



/////////// Application Setup ///////////


// We use express to set up the application
var express = require('express');
var app = express();
// We create the http server
var server = require('http').createServer(app);
// We use sockets for our communication and the sockets will communicate on the server created above
var io = require('socket.io').listen(server);


// This module is needed for this application as the game creates random usernames, the moniker module is used to generate these names
var Moniker = require('moniker');

// Here we declare the file we want to send to the client when a new user connects to the server, in this example it is page.HTML
app.use(express.static(__dirname + '/public'));
app.get('/', function(req, res) {
    res.sendFile(__dirname + '/page.html');
});
// We will run the web server on port 8080 which is the standard for a web server application
server.listen(process.env.PORT || 8080);





/////////// Listeners (required regardless of game played) ///////////


/* This is the first use of socket.io in this application. io.sockets.on() is used when you are referring to all connections, so all the current
   players in the maths game. Here we are saying that when a new connection is established (which is detected automatically) then a socket is
   created for that connection and this socket is unique to that client. */


var name; // =Holds the username of connection
var game; // Holds the game instance

io.sockets.on('connection', function(socket) {

    // Print out a log indicating there has been a new connection, just useful for testing
    console.log("Successful Connection!");


    socket.on('login', function(playerName) {
        name = playerName;
        socket.username = playerName;
        console.log("player name is: " + playerName);
    });

    socket.on('room', function(room) {


        if (io.sockets.adapter.rooms[room]) { // Check if room the user wants to join already exists...
            socket.join(room); // joining the new room

            // search for existing game object...
            for (var i = 0; i < myGameInstances.length; i++) {
                // joining the existing room;
                if (myGameInstances[i] == room) {
                    // Fetch the respective game instance...
                    game = myGameInstances[i + 1];
                }
            }

            // Don't create new game but add user to exiting one
            // should really store game data in Json or some other more readable format rather than a object array...

            // If the user wants to join a new lobby...
        } else {

            socket.join(room); // joining the new room
            socket.room = room;
            game = new Game(socket.room);
            myGameInstances.push(room);
            myGameInstances.push(game);

        };

        io.sockets.in(room).emit('message', 'User ' + socket.username + ' has joined the lobby');
        game.addUsertoGame(socket.id);
        game.addUser(name);
        game.showUsers();


        socket.on('disconnect', function() {
            // when a user disconnects we need to locate there name and the game they belong to...

            for (var i = 0; i < game.Users.length; i += 2) { // Search for player name corresponding to this unique socket so that we know which
                // user is to be removed.
                if (game.Users[i] == socket.id) {
                    var playerToRemove = game.Users[i + 1];
                    game.removeUser(playerToRemove);
                    io.sockets.in(room).emit('message', 'User ' + socket.username + ' has left the lobby');
                }
            }
        });

        console.log("Number of lobbies for the game: " + (myGameInstances.length / 2));



/////////// Listeners (chat specific) ///////////


socket.on('clientMessage', function(data){
  io.sockets.in(room).emit('message', socket.username + ' ~ ' + data );
});














        /////////// Listeners (game specific) ///////////

        socket.on('mathAnswer', function(data) {
            game.evalAnswer(data);
            });
        });
      });

// /*Just a quick overview of what has happened in the above core functions:
//
//   The addUser function creates a new user with a unique random name and appends it to the array called users.
//   The removeUser function removes a given user form the array called users.
//   The updateUsers function sends a string containing a list of all the current users in the game including the users name and score.*/
