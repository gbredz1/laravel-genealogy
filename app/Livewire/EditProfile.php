<?php

use App\Models\Person;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    public ?Person $person = null;
    public $first_name = '';
    public $last_name = '';
    public $gender = '';
    public $birth_date = null;
    
    public function mount(): void
    {
        $user = Auth::user();
        $this->person = $user->person;
        
        if ($this->person) {
            $this->first_name = $this->person->first_name;
            $this->last_name = $this->person->last_name;
            $this->gender = $this->person->gender;
            $this->birth_date = $this->person->birth_date;
        }
    }
    
    public function save(): void
    {
        $validated = $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
        ]);
        
        $user = Auth::user();
        
        if ($user->person) {
            $user->person->update($validated);
        } else {
            $person = new Person($validated);
            $user->person()->save($person);
            $this->person = $person;
        }
        
        session()->flash('status', 'profile-updated');
    }
};