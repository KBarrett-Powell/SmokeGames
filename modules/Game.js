
// Raw (game logic only) Class
class Game {

    // Setting up instance variables that store game state...
    constructor(roomId, io, endScore, endTime) {
      this.endScore = 8;
      this.endTime = null;  //Note: will add a countdown timer to games, perhaps decide on max time allowed for any game
      this.roomId = roomId;
      this.io = io;
      this.Users = []; // --> Stores the games user's state including their username and score.
      this.gUsers = []; // --> Stores the socket objects and their respective names, which is used when removing a user from the game, on disconnect.

      }


showUsers() {
  console.log("Number of players in the lobby: " + this.gUsers.length);
  if (this.gUsers.length == 2) { // Sets the maximum number of users needed to start the game, this should really be dynamic instead of hardcoded (user choice?)
    //this.startGame(); // When number of users required has been met, the game is started and game logic starts execution.z
    this.io.sockets.in(this.roomId).emit("gameStarted");
    this.dummyStart();
    console.log("game should start...");
    }
  }


addUsertoGame(socketId, name) { // When a new user has connected to a particular lobby, we add thre socketId and associcated name for reference in
      // various methods.
      this.Users.push(socketId);
      this.Users.push(name);

          this.num = this.num + 1;
          this.getSide(socketId, this.num);
          console.log("your side: " + this.num );


    };

    InformUserOfLobby(socket) {
      socket.emit("test", this.roomId);
    }


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


            console.log("");
            console.log("PLAYER " + user + " HAS LEFT THE GAME...");
            console.log("");
        };
    };

    if (this.gUsers.length == 1) {
        this.endGame();
    }
}


updateUsers() {

    // Broadcast all the user names of the users that are in the game to all of the users...
    console.log("Users present in the game: " + this.gUsers.length);
    //this.io.sockets.in(this.roomId).emit("users", this.gUsers);
};

soundEffects(soundFile){
  this.io.sockets.in(this.roomId).emit("soundEffect", soundFile);
  console.log("server detects...")
}

// This will cause the client loading screen to be hidden and the first question of the game generated by the updateQuestion() method
startGame() {
    //this.io.sockets.in(this.roomId).emit("gameStarted", true);
    //this.updateQuestion();  This needs to call dummyStart()
}


/*This method is triggered in the case when there is only one user left in the game and so they win by default.
IMPORTANT: This method will need to redirect the user back to the game page when the game ends so that they are not just stuck on the game
page. In addition when the game is over the game instance needs it summary data written to the SQL database and it will then need to be removed
from the myGameInstances array.*/
endGame() {

    console.log("endGame() is called");
    var destination = '/home.html';
    clearInterval(this.tester);
    this.io.sockets.in(this.roomId).emit("gameEnded",{"destination": destination, "users": this.gUsers});
  }


updateScores(increment, player){


    player.score = player.score + increment; // Calculating new score

    if(player.score == this.endScore){  // Check if winning score has been achieved by player.
      this.endGame();
    }


    this.io.sockets.in(this.roomId).emit("scoreUpdate", {"player": player.name, "score": player.score});
    console.log("score increase triggered");
  }

}

module.exports = Game;
