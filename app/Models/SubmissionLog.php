<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionLog extends Model
{
    protected $fillable = ['submission_id','admin_id','status','note'];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
