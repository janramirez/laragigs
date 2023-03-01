<x-layout>

    @include('partials._hero')
    @include('partials._search')

    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

        @unless(count($listings) == 0)

            @foreach ($listings as $listing)
                <x-listing-card :listing="$listing" />
            @endforeach
        @else
            <x-card class="p-6">No listings available</x-card>

        @endunless

    </div>
    <div class="mt-6 p-4">
        {{ $listings->links() }}
    </div>

    @include('partials._footer')
</x-layout>
