<x-layouts.auth :title="__('Home')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('home.welcome')"/>

        <div class="mt-6 flex justify-center">
            <flux:button variant="primary" href="{{ route('dashboard') }}">
                {{__('home.start_exploring')}}
            </flux:button>
        </div>
    </div>
</x-layouts.auth>
