<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class ChatComponent extends Component
{
    public $chatPopupVisibility;

    public $message;

    public $roomId;

    /**
     * The mount function.
     *
     * @return void
     */
    public function mount()
    {
        if (in_array(auth()->user()->id, [1,2])) {
            $this->roomId = 1;
        } else {
            $this->roomId = 2;
        }

        $this->chatPopupVisibility = Cookie::get('chatPopupShow') == 'true';
    }

    /**
     * Shows the chat popup box.
     *
     * @return void
     */
    public function showChatPopup()
    {
        Cookie::queue('chatPopupShow', 'true', 60);
        $this->chatPopupVisibility = true;

        // load chat history by reloading the page
        $this->dispatchBrowserEvent('reload-page');
    }

    /**
     * Hide the chat popup box.
     *
     * @return void
     */
    public function closeChatPopup()
    {
        Cookie::queue('chatPopupShow', 'false', 60);
        $this->chatPopupVisibility = false;
    }

    /**
     * Sends the chat message
     *
     * @return void
     */
    public function sendMessage()
    {
        $userId = auth()->user()->id;

        Message::create([
            'room_id'   => $this->roomId,
            'user_id'   => $userId,
            'message'   => $this->message,
        ]);

        $this->message = "";

        $this->dispatchBrowserEvent('chat-send-message', [
            'room_id'   => $this->roomId,
            'user_id'   => $userId,
            'message'   => $this->message,
        ]);
    }

    public function render()
    {
        return view('livewire.chat-component');
    }
}
