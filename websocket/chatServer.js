let WebSocketServer = require("websocket").server;
let http = require("http");
let htmlEntity = require("html-entities");
let PORT = 3281;

//List of currently connected clients (users)
let clients = [];

// Create http server
let server = http.createServer();

server.listen(PORT, function () {
    console.log("Server is listening on PORT:" + PORT);
})

// Create the websocket server here
wsServer = new WebSocketServer({
    httpServer: server
})

/**
 *  The websocket server
 */
wsServer.on("request", function (request) {
    let connection = request.accept(null, request.origin);

    /**
     * This is where the message send to all the clients connected
     */
    connection.on("message", function (message) {
        let utf8Data = JSON.parse(message.utf8Data);

        if (message.type === 'utf8') {

        }

        console.log(message);
    })

    /**
     * When the client closes its connection to the websocket server
     */
    connection.on("close", function (connection) {

    })
})
