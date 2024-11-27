<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Annonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'type',
        'ice',
        'status',
        'ref_web',
        'date_parution',
        'canal_de_publication',
        'ville',
        'publication_web',
        'file_attachment',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}
