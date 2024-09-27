<!-- component -->
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex h-screen overflow-hidden">

        <!-- Main Chat Area -->
        <div class="flex-1">
            <!-- Chat Header -->
            <header class="bg-white p-4 text-gray-700">
                <h1 class="text-2xl font-semibold">{{ $user->name }}</h1>
            </header>

            <!-- Chat Messages -->
            <div class="h-[42.5rem] overflow-y-auto px-4" id="chat-container">
                @foreach($messages as $message)
                    @if($message['sender'] != auth()->user()->id)
                    <!-- Incoming Message -->
                    <div class="flex mb-4 cursor-pointer">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center mr-2">
                        <img src="https://placehold.co/200x/ffa8e4/ffffff.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="User Avatar" class="w-8 h-8 rounded-full">
                        </div>
                        <div class="flex max-w-96 bg-white rounded-lg p-3 gap-3">
                        <p class="text-gray-700">{{ $message['message'] }}</p>
                        </div>
                    </div>
                    @else
                    <!-- Outgoing Message -->
                    <div class="flex justify-end mb-4 cursor-pointer">
                        <div class="flex max-w-96 bg-indigo-500 text-white rounded-lg p-3 gap-3">
                        <p>{{ $message['message'] }}</p>
                        </div>
                        <div class="w-9 h-9 rounded-full flex items-center justify-center ml-2">
                        <img src="https://placehold.co/200x/b7a8ff/ffffff.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="My Avatar" class="w-8 h-8 rounded-full">
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <!-- Chat Input -->
            <form wire:submit="sendMessage()">
                {{--<footer class="bg-white border-t border-gray-300 p-4 absolute bottom-0 w-100">
                    <div class="flex items-center">
                        <textarea wire:model="message" placeholder="Type a message..." class="w-full p-2 rounded-md border border-gray-400 focus:outline-none focus:border-blue-500"></textarea>
                        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-md ml-2">Send</button>
                    </div>
                </footer>--}}
                <div class="flex items-center py-2 px-3 bg-gray-50 rounded-lg dark:bg-gray-700">
                    <button type="button" class="inline-flex justify-center p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                    </button>
                    <button type="button" class="p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z" clip-rule="evenodd"></path></svg>
                    </button>
                    <textarea wire:model="message" id="chat" rows="1" class="block mx-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your message..."></textarea>
                        <button type="submit" class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                        <svg class="w-6 h-6 rotate-90" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function scrollToBottom() {
        var chatContainer = document.getElementById('chat-container');
        if (chatContainer) {
            console.log("Chat container found");
            console.log("Scroll Height: ", chatContainer.scrollHeight);
            console.log("Client Height: ", chatContainer.clientHeight);

            // Ensure scrolling happens when new content is added
            window.requestAnimationFrame(function () {
                setTimeout(function () {
                    if (chatContainer.scrollHeight > chatContainer.clientHeight) {
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                        console.log("Scrolling to bottom");
                    } else {
                        console.log("Not enough content to scroll");
                    }
                }, 200); // Allow slight delay for rendering content
            });
        } else {
            console.log("Chat container not found");
        }
    }

    // Scroll on initial page load
    window.addEventListener('livewire:load', function () {
        alert("tets");
        let container = document.getElementById('chat-container');
        container.scrollTop = container.scrollHeight;
    });

    // Scroll when Livewire updates (e.g., when a new message is sent/received)
    window.addEventListener('livewire:update', function () {
        console.log("Livewire on update");
        scrollToBottom();  // Ensure it scrolls when new content arrives
    });

    // Scroll when the page is reloaded
    window.addEventListener('scrollDown', function () {
        let container = document.getElementById('chat-container');
        container.scrollTop = container.scrollHeight;
    });
</script>


