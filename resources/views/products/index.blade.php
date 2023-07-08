<x-guest-layout>
    <h1>Products index page</h1>
    @auth
        @if (auth()->user()->is_admin)
            <a href="{{ route('products.create') }}">Create</a>
        @endif
        <br>
        <br>
    @endauth
    @forelse ($products as  $product)
        <h2>Product's name: {{ $product->name }}</h2>
        <p>Product's type: {{ $product->type }}</p>
        <p>Product's price: {{ $product->price }}</p>
        @auth
            <button>Buy Product</button>
            <br>
            <a href="{{ route('products.edit', $product->id) }}" rel="noopener noreferrer">Edit</a>
        @endauth
        <br>
        <br>
    @empty
        <p>No Products</p>
    @endforelse
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Back') }}
    </x-nav-link>
</x-guest-layout>
