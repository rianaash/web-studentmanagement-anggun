<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['enrollment_id', 'paid_date', 'amount', 'description'];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
