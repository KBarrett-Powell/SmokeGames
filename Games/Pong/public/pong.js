
function game() {
  console.log("activated");

  // Assigning the HTML elements to be used to variables...
    var link = document.querySelector('link[rel="import"]');
    console.log(link);
    var content = link.import;

    console.log("test test 123");

    // Grab DOM from warning.html's document.
    var el = content.querySelector('#pong');
    document.getElementById("o").appendChild(el.cloneNode(true));	// load the games HTML file
    fitToContainer(document.getElementById("pong"));
    console.log(document.getElementById("pong").width);
    console.log(document.getElementById("pong").height);

    function fitToContainer(canvas){
      // Make it visually fill the positioned parent
      canvas.style.width ='100%';
      canvas.style.height='100%';
      // ...then set the internal size to match
      canvas.width  = canvas.offsetWidth;
      canvas.height = canvas.offsetHeight;
    }


var canvas = document.getElementById('pong'); // Create the canvas that will have the pong paddles and ball written onto it
var playerNumber; // Stores (1) for player one and (2) for player two, this is needed in identifying which paddle is which.
console.log(canvas);


socket.on("playerNumber", function(P_Num){  // Gets (1) or (0) from server

  playerNumber = P_Num;
  console.log(" you are: " + playerNumber);
});


socket.on("drawBall", function(data){   // This is where update is performed on the canvas to display new paddle and ball positions

  canvas.getContext('2d').fillStyle = '#000';
  canvas.getContext('2d').fillRect(0, 0, canvas.width, canvas.height)

  canvas.getContext('2d').fillStyle = '#fff';
  canvas.getContext('2d').fillRect(data.x, data.y, 10, 10);

  canvas.getContext('2d').fillStyle = '#fff';
  canvas.getContext('2d').fillRect(0, data.y1, 20, 100);

  canvas.getContext('2d').fillStyle = '#fff';
  canvas.getContext('2d').fillRect(580, data.y2, 20, 100);

});

console.log(canvas);
canvas.addEventListener("mousemove", event => { // Need event listener to listen for user mouse movement to update paddle view.
  let scale = event.offsetY / event.target.getBoundingClientRect().height;
  let newPosition = canvas.height * scale;

  updatePaddle(newPosition, playerNumber);

});

function updatePaddle(newPosition, playerNumber){ //This sends the new paddle position to the server and is called when them
  console.log(playerNumber);                      //mousemove event listener is fired
  socket.emit("mousemove", {"position": newPosition, "number": playerNumber,"theGame": myGame});
}
}
