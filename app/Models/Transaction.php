<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags():BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

        public function scopeExpenses (Builder $query): void
    {
        $query->where('type', 'expense');
    }

    public function scopeIncomes (Builder $query): void
    {
        $query->where('type', 'income');
    }

    public function type():Attribute
    {
        return Attribute::make(
            get: fn(string $value) => match($value) {
                'income'=> 'Ingreso',
                'expense'=>'Gasto',
                default=>'Sin tipo'
            }
        );
    }

    public function detail():Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
            set: fn(string $value) =>strtolower(trim($value))
        );
    }

    protected $fillable = [
        'user_id',
        'transaction_date',
        'type',
        'detail',
        'amount',
        'category_id'
    ];
};
