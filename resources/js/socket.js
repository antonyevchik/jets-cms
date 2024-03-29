/**
 * Initialize a web socket client
 *
 * @param config
 * @returns {WebSocket}
 */
window.clientSocket = function(config = {}) {
    let route = config.route || "127.0.0.1";
    let port = config.port || "3280";
    window.Websocket = window.WebSocket || window.MozWebSocket;

    return new WebSocket("ws://" + route + ":" + port);
}
