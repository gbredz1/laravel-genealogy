@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <flux:heading size="xl">{{ $title }}</flux:heading>
    @isset($description)
        <flux:subheading>{{ $description }}</flux:subheading>
    @endisset
</div>
