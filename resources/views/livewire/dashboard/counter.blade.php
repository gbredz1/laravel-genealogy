<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $title = 'My counter title';
    public int $count = 42;
    public string $color = "text-accent";
}; ?>


<div class="flex items-center justify-center h-full">
    <div class="text-center">
        <h3 class="text-xl font-bold">{{ __($title) }}</h3>
        <p class="text-4xl font-bold mt-2 {{ $color }}">{{ $count }}</p>
    </div>
</div>
