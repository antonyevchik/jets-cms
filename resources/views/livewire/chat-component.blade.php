<div>
    <button class="open-button" wire:click="showChatPopup">
        Chat
    </button>
    @if($this->chatPopupVisibility)
        <div class="chat-popup">
            <form class="form-container">
                <div>Room #: {{ $roomId }}</div>
                <label class="font-semibold"></label>
                <div
                    id="messageBox"
                    class="border px-3 py-2 h-64 bg-gray-50 overflow-y-auto"
                    style="width:280px">
                </div>
                <textarea id="message"
                          class="focus:outline-none focus:bg-gray-100 w-full px-3 py-2"
                          placeholder="Type in your message..."
                          wire:model="message"
                          wire:keydown.enter.prevent="sendMessage"></textarea>
                <button type="button"
                        class="btn cancel"
                        wire:click="closeChatPopup">
                    Close
                </button>
            </form>
        </div>
    @endif
    @push('chat-websocket')
        <script>
            $(function () {
                /**
                 *
                 * @param elementId
                 */
                function keepChatboxFocusAtBottom(elementId) {
                    let element = document.getElementById(elementId);
                    element.scrollTop = element.scrollHeight;
                }

                function messageFormat(id, name, message) {
                    let userId = "{{ auth()->user()->id }}";
                    let color = id === userId ? "bg-blue-400" : "bg-green-400";
                    let alignment = id === userId ? "text-right" : "text-left";

                    return `
                        <div class="grid grid-cols-1 items-center gap-0">
                            <span class="${alignment} font-semibold text-sm">${name}</span>
                            <span class="${alignment} ${color} text-sm text-white px-3 py-2 rounded">${message}</span>
                        </div>
                    `;
                }

                // Instantiate a connection
                let chatConnection = clientSocket({ port: 3281 });

                // The messageBox element
                let messageBox = $("#messageBox");

                // The message element
                let message = $("#message");

                /**
                 * When a connection is open
                 */
                chatConnection.onopen = function () {
                    console.log("Chat connection is open!");
                }

                /**
                 * Will receive message from the websocket server
                 */
                chatConnection.onmessage = function (message) {

                }

                /**
                 * Send the prompt to the websocket server
                 */
                window.addEventListener('chat-send-message', event => {
                    console.log(event);
                })
            });
        </script>
    @endpush
</div>
