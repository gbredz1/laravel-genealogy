<?php

use App\Models\Gender;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public string $first_name = '';
    public string $last_name = '';
    public string $gender = '';
    public ?string $birth_date = null;

    /**
     * Mount the component.
     */

    #[On('profile-deleted')]
    public function mount(): void
    {
        $user = Auth::user();
        $person = $user->person()->firstOrNew(
            ['user_id' => $user->id],
            [
                'first_name' => '',
                'last_name' => '',
                'gender' => Gender::NotSpecified,
                'birth_date' => null,
            ]
        );

        $this->fill([
            'first_name' => $person->first_name,
            'last_name' => $person->last_name,
            'gender' => $person->gender?->value ?? Gender::NotSpecified,
            'birth_date' => $person->birth_date,
        ]);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::enum(Gender::class)],
            'birth_date' => ['nullable', 'date']
        ]);

        $person = Auth::user()->person()->updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        if ($person->wasChanged()) {
            $this->dispatch('profile-updated');
        }

    }

    public function delete(): void
    {
        $person = Auth::user()->person();

        if ($person->exists()) {
            $person->delete();
            $this->dispatch('profile-deleted');
        }
    }
} ?>

<section class="w-full">
    @include('partials.profile-heading')

    <div class="mt-5 w-full max-w-lg">
        <form wire:submit="save()" class="my-6 w-full space-y-6">

            <flux:input wire:model="first_name" :label="__('profile.fields.firstname')" type="text" autofocus
                        autocomplete="given-name"/>
            <flux:input wire:model="last_name" :label="__('profile.fields.lastname')" type="text"
                        autocomplete="family-name"/>
            <flux:radio.group variant="segmented" :label="__('profile.fields.gender')"
                              wire:model="gender"
                              autocomplete="gender">
                <flux:radio value="{{ Gender::Male }}">{{ __('profile.gender.male') }}</flux:radio>
                <flux:radio value="{{ Gender::Female }}">{{ __('profile.gender.female') }}</flux:radio>
                <flux:radio value="{{ Gender::Other }}">{{ __('profile.gender.other') }}</flux:radio>
                <flux:radio value="{{ Gender::NotSpecified }}">{{ __('profile.gender.not_specified') }}</flux:radio>
            </flux:radio.group>

            <div class="mb-4">
                <label for="birth_date" class="block text-sm font-medium mb-1">{{ __('profile.birthdate') }}</label>
                <div class="relative">
                    <input type="date"
                           wire:model="birth_date"
                           id="birth_date"
                           autocomplete="birth_date"
                           class="block w-full px-4 py-2 rounded-md bg-zinc-100 dark:bg-zinc-700"
                           style="min-height: 2.5rem;">
                </div>
            </div>

            {{-- parent 1 --}}
            {{-- parent 2 --}}

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>

                @if(Auth::user()->person()->exists())
                    <flux:button variant="danger" type="button" wire:click="delete()">
                        {{ __('actions.delete') }}
                    </flux:button>
                @endif
            </div>
        </form>

    </div>
</section>