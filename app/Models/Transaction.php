<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These are the fields that can be filled using mass assignment methods like create() or update().
     *
     * @var array
     */
    protected $fillable = [
        'sender_account_number',
        'receiver_account_number',
        'amount',
        'status',
        'created_at',
        'finished_at',
    ];

    /**
     * The attributes that should be casted to native types.
     * This allows automatic conversion of data when retrieved from or saved to the database.
     *
     * @var array
     */
    protected $casts = [
        'amount'      => 'decimal:2',
        'status'      => 'integer',
        'created_at'  => 'datetime',
        'finished_at' => 'datetime',
    ];

    /**
     * Relationship to the Account model where the transaction is sent from (sender).
     * Each transaction belongs to one sender account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(Account::class, 'sender_account_number');
    }

    /**
     * Relationship to the Account model where the transaction is received (receiver).
     * Each transaction belongs to one receiver account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(Account::class, 'receiver_account_number');
    }
}
