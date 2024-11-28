<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'annonce_id', 'amount', 'tax', 'total', 'status', 'method', 'reference_number'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }
}
