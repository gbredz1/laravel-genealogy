<?php

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Volt\Component;

new class extends Component {
    public int $userId;

    public ?int $familyMemberCount = null;

    public function mount(int $userId): void
    {
        $this->userId = $userId;
        $this->loadFamilyCount();
    }

    public function loadFamilyCount(): void
    {
        try {
            $user = User::select('id');
            $this->familyMemberCount = 42;
        } catch (ModelNotFoundException $e) {
            $this->familyMemberCount = 0;
        }
    }
}
?>

<livewire:dashboard.counter title="Family Member Count" :count="$familyMemberCount" color="text-blue-500"/>