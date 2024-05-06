<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function getFormattedCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY [às] H:mm');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
