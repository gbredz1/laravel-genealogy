<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'parent1_id',
        'parent2_id',
        'user_id',
    ];

    protected $casts = [
        'gender' => Gender::class,
    ];

    /**
     * Relationship with parent 1
     */
    public function parent1(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'parent1_id');
    }

    /**
     * Relationship with parent 2
     */
    public function parent2(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'parent2_id');
    }

    /**
     * Children as parent 1
     */
    public function childrenAsParent1(): HasMany
    {
        return $this->hasMany(Person::class, 'parent1_id');
    }

    /**
     * Children as parent 2
     */
    public function childrenAsParent2(): HasMany
    {
        return $this->hasMany(Person::class, 'parent2_id');
    }

    /**
     * Get all children of this person
     */
    public function children()
    {
        return $this->childrenAsParent1->merge($this->childrenAsParent2);
    }

    /**
     * Get siblings (people sharing at least one parent)
     */
    public function siblings()
    {
        $siblings = collect();

        if ($this->parent1_id) {
            $siblings = $siblings->merge(
                Person::where('parent1_id', $this->parent1_id)
                    ->where('id', '!=', $this->id)
                    ->get()
            );
        }

        if ($this->parent2_id) {
            $siblings = $siblings->merge(
                Person::where('parent2_id', $this->parent2_id)
                    ->where('id', '!=', $this->id)
                    ->get()
            );
        }

        return $siblings->unique('id');
    }
}
