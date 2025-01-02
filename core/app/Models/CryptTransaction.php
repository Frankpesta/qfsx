<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'coin_id', 'vendor_id', 'amount', 'status'];

    // Relationships
    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
