<?php

namespace App\Livewire;

use App\Events\MessageSendEvent;
use App\Models\Message;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatComponent extends Component
{
    public $user;
    public $sender_id;
    public $receiver_id;
    public $message = '';
    public $messages = [];

    public function render()
    {
        $this->dispatch('scrollDown');
        return view('livewire.chat-component');
    }

    public function mount(){
        $this->sender_id = auth()->user()->id;

        /*$messages = Message::where(function($query) {
            $query->where('sender_id', $this->sender_id)
                ->where('receiver_id', $this->receiver_id);
        })->orWhere(function ($query){
            $query->where('sender_id', $this->receiver_id)
                ->where('receiver_id', $this->sender_id);
        })->with('sender:id,name','receiver:id,name')
        ->get();
        foreach($messages as $message){
            $this->appendChatMessage($message);
        }
        //$this->messages = $messages;
        $this->user = User::whereId($this->receiver_id)->first();*/
    }

    #[On('userSelected')]
    public function userSelected($user_id)
    {
        $this->receiver_id = $user_id;
        $this->sender_id = auth()->user()->id;
        $this->loadChatMessages();

        $this->user = User::find($user_id);
    }

    public function loadChatMessages()
    {
        $this->messages = [];
        $messages = Message::where(function($query) {
            $query->where('sender_id', $this->sender_id)
                ->where('receiver_id', $this->receiver_id);
        })->orWhere(function ($query){
            $query->where('sender_id', $this->receiver_id)
                ->where('receiver_id', $this->sender_id);
        })->with('sender:id,name','receiver:id,name')
        ->get();
        foreach($messages as $message){
            $this->appendChatMessage($message);
        }
        //$this->messages = $messages;
        $this->user = User::whereId($this->receiver_id)->first();
    }

    public function sendMessage(){
        //dd($this->message);
        $chatMessage = new Message();
        $chatMessage->sender_id = $this->sender_id;
        $chatMessage->receiver_id = $this->receiver_id;
        $chatMessage->message = $this->message;
        $chatMessage->save();

        $this->appendChatMessage($chatMessage);
        //$this->dispatch('scrollDownMessage');
        $this->dispatch('scrollDown');
        broadcast(new MessageSendEvent($chatMessage))->toOthers();

        $this->message = '';
    }

    #[On('echo-private:chat-channel.{sender_id},MessageSendEvent')]
    public function listenForMessage($event){
        // $this->dispatch('scrollDownMessageListen');
        $this->dispatch('scrollDown');
        $chatMessage = Message::whereId($event['message']['id'])->with('sender:id,name','receiver:id,name')->first();
        $this->appendChatMessage($chatMessage);
    }

    public function appendChatMessage($message){
        $this->messages[] = [
            'id' => $message->id,
            'message' => $message->message,
            'sender' => $message->sender->id,
            'receiver' => $message->receiver->id
        ];
    }
}
