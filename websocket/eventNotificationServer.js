let WebSocketServer = require("websocket").server;
let http = require("http");
let htmlEntity = require("html-entities");
let PORT = 3280;

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

    // Pass each connection instance to each client
    let index = clients.push(connection) - 1;

    console.log('Client', index, "connected");

    /**
     * This is where the message send to all the clients connected
     */
    connection.on("message", function (message) {
        let utf8Data = JSON.parse(message.utf8Data);

        if (message.type === 'utf8') {
            // Prepare the json data to be sent to all clients that are connected
            let obj = JSON.stringify({
                eventName: htmlEntity.encode(utf8Data.eventName),
                eventMessage: htmlEntity.encode(utf8Data.eventMessage),
            })

            // Send them to all the clients
            for (let i = 0; i < clients.length; i++) {
                clients[i].sendUTF(obj);
            }
        }

        console.log(message);
    })

    /**
     * When the client closes its connection to the websocket server
     */
    connection.on("close", function (connection) {
        clients.splice(index, 1);

        console.log("Client", index, "was disconnected");
    })
})
