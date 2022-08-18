<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tweets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @forelse ($tweets as $tweet)
                    <div class="p-6 bg-white border-b border-gray-200">
                        {{ $tweet->user->name }}: {{ $tweet->tweet }}
                    </div>
                @empty
                    No Tweets!
                @endforelse
                <div class="p-6">{{ $tweets->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>