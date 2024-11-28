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

    // Automatically generate `ref_web`
    protected static function booted()
    {
        static::creating(function ($annonce) {
            // Get the last `ref_web` value
            $lastAnnonce = Annonce::latest('id')->first();

            // Set the default starting value
            $lastRefNumber = 0;
            if ($lastAnnonce && $lastAnnonce->ref_web) {
                $matches = [];
                // Extract the numeric part from the last `ref_web`
                preg_match('/Ref-(\d+\.\d+)/', $lastAnnonce->ref_web, $matches);
                if (isset($matches[1])) {
                    $lastRefNumber = (float) $matches[1];
                }
            }

            // Increment the numeric part and format it
            $newRefNumber = number_format($lastRefNumber + 0.0001, 4, '.', '');

            // Assign the new value to `ref_web`
            $annonce->ref_web = 'Ref-' . $newRefNumber;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}
