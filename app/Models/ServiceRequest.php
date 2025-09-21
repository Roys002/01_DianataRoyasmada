<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;


    protected $fillable = ['user_id', 'title', 'description', 'attachment', 'status', 'admin_note'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
