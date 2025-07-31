<x-layouts.pdf.layout title="Users PDF">
    <h1 class="text-3xl">Users PDF</h1>
    @forelse ($users as $user)
        <div class="flex gap-x-4 px-5">
            <h2 class="text-xl">Name: {{ $user->name }}</h2>
            <p class="text-xl bg-blue-600">Email: {{ $user->email }}</p>
        </div>
    @empty
        <p>No users found</p>
    @endforelse
</x-layouts.pdf.layout>
