let WebSocketServer = require("websocket").server;
let http = require("http");
let htmlEntity = require("html-entities");
let uniqueId = require('uniqid');
let mysql = require('mysql');
const {result} = require("lodash/object");
let PORT = 3281;

// Database connection
let db = mysql.createConnection({
    host: "127.0.0.1",
    user: "root",
    password: "root_passwd1",
    database: "jets_cms"
})

// Connect to the database
db.connect();

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

    // The unique identifier for the connection instance of the client
    let connection_id;

    // The room_id for the users
    let room_id;

    /**
     * This is where the message send to all the clients connected
     */
    connection.on("message", function (message) {
        let utf8Data = JSON.parse(message.utf8Data);

        if (message.type === 'utf8') {
            if (utf8Data.type === "info") {

                // Generate a unique identifier
                connection_id = "connection__" + uniqueId();

                console.log("Connection", utf8Data)
            } else if (utf8Data.type === "chatMessage") {
                retrieveLatestChatMessage();
            }
        }

        console.log(message);
    })

    /**
     * When the client closes its connection to the websocket server
     */
    connection.on("close", function (connection) {

    })

    function retrieveLatestChatMessage() {
        let statement = `
            SELECT messages.room_id, messages.user_id, messages.message, messages.created_at, users.name
            FROM messages
            LEFT JOIN users ON messages.user_id = users.id
            WHERE room_id=${room_id}
            ORDER BY created_at DESC
            LIMIT 1
        `;

        db.query(statement, (error, results) => {
            if (error) console.log(error);

            if (results) {
                // Broadcast the messages to all users in the same room
            }
        })
    }
})
