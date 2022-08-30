<div>
    <button class="open-button" wire:click="showChatPopup">
        Chat
    </button>
    @if($this->chatPopupVisibility)
        <div class="chat-popup">
            <form class="form-container">
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
</div>
