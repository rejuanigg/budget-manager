<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    /**
     * Many-to-many relationship with Transaction.
     * Returns the transactions associated with this tag.
     * The pivot table uses timestamps for auditing.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class)->withTimestamps();
    }

    protected $fillable = [
        'name'
    ];
}
