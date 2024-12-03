<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    protected $fillable = [
        'user_id',
        'pack_type',
        'total_annonces',
        'remaining_annonces',
        'price_per_annonce',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

}
