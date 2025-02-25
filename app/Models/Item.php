<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = ['id'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_category', 'item_id', 'category_id');
    }
    

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transactions_items', 'transaction_id', 'item_id')->withPivot('quantity');
    }
}
