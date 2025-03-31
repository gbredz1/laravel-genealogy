@php
    $user = auth()->user();
@endphp

<x-layouts.app :title="__('Dashboard')">

    @unless(Auth::user()->person()->exists())
        <!-- todo use volt theme -->
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Profile incomplet!</strong>
            <span class="block sm:inline">Veuillez <a href="{{ route('profile.personal-info') }}" class="underline">compléter votre profil personnel</a> pour accéder à toutes les fonctionnalités.</span>
        </div>
    @endunless

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <livewire:dashboard.familly-counter-widget :userId="$user->id"/>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <livewire:dashboard.counter title="Number of shared trees" count="2"/>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <livewire:dashboard.counter title="Active members" count="1"/>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20"/>
        </div>
    </div>

</x-layouts.app>
