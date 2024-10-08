<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-wrap">
                <div class="p-6 text-gray-900 dark:text-gray-100 w-1/5 border-r-2">
                    {{-- <p onclick="Livewire.dispatchTo('chat-component','userSelected', { user_id: 2 })" class="cursor-pointer">Test Click</p> --}}
                    <h3 class="text-xs font-semibold uppercase text-gray-500 mb-1 ml-1 md:text-base">Chats</h3>
                    <div class="divide-y divide-gray-200">
                        @foreach ($users as $user)
                            <!-- User -->
                            <button onclick="Livewire.dispatchTo('chat-component','userSelected', { user_id: {{ $user->id }} })" class="w-full text-left py-2 focus:outline-none focus-visible:bg-indigo-50">
                                <div class="flex items-center">
                                    @if(isset($user->profile))
                                        <img class="rounded-full items-start flex-shrink-0 mr-3" src="https://res.cloudinary.com/dc6deairt/image/upload/v1638102932/user-32-01_pfck4u.jpg" alt="Marie Zulfikar" />
                                    @else
                                        <img src="https://ui-avatars.com/api/?background=random&name={{$user->name}}" alt="{{$user->name}}" class="rounded-full items-start flex-shrink-0 mr-3" width="40" height="40" >
                                    @endif

                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900">{{ $user->name }}</h4>
                                        {{-- <div class="text-[13px]">The video chat ended · 2hrs</div> --}}
                                    </div>
                                </div>
                            </button>
                            <!-- User -->
                            {{-- <p onclick="Livewire.dispatchTo('chat-component','userSelected', { user_id: {{ $user->id }} })" class="cursor-pointer">{{ $user->name }}</p> --}}
                        @endforeach
                    </div>
                </div>
                <div class="w-4/5 h-[45.5rem] my-2">
                    @livewire('chat-component')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

