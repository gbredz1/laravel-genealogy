<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the form for creating a personal profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $person = $user->person;

        return view('profile.edit', compact('person'));
    }

    /**
     * Update or create the user's person record.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
        ]);

        $user = Auth::user();

        // Update existing person or create new one
        if ($user->person) {
            $user->person->update($validated);
        } else {
            $person = new Person($validated);
            $user->person()->save($person);
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Your profile information has been updated successfully.');
    }
}
