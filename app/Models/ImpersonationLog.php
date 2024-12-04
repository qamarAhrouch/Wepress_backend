<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImpersonationLog extends Model
{
    use HasFactory;

    // Define the table name (if different from convention)
    protected $table = 'impersonation_logs';

    // Define the fillable fields
    protected $fillable = [
        'admin_id',
        'user_id',
        'started_at',
        'ended_at',
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
