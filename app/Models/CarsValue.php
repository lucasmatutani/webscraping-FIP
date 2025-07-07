<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarsValue extends Model
{
    use HasFactory;
    protected $fillable = ['value', 'fipe_code', 'reference_month', 'year', 'model_id'];

    public function model()
    {
        return $this->belongsTo(Models::class);
    }
}
