<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These are the fields that can be filled using mass assignment methods like create() or update().
     *
     * @var array
     */
    protected $fillable = [
        'account_number',
        'user_id',
        'amount',
        'frozen_amount',
    ];

    /**
     * The attributes that should be casted to native types.
     * This allows automatic conversion of data when retrieved from or saved to the database.
     *
     * - 'amount' and 'frozen_amount' are casted as decimal with 2 decimal places.
     * - 'status' is casted as an integer.
     * - 'deleted_at' is casted as a datetime for soft deletes.
     *
     * @var array
     */
    protected $casts = [
        'amount'        => 'decimal:2',
        'frozen_amount' => 'decimal:2',
    ];

    /**
     * Define the relationship with the User model.
     * Each account belongs to a single user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBalanceAttribute()
    {
        return $this->amount - $this->frozen_amount;
    }
}
