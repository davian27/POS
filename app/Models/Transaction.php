<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];

    public function admin(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items(){
        return $this->belongsToMany(Item::class, 'transactions_items', 'transaction_id','item_id')->withPivot('quantity');
    }
}
