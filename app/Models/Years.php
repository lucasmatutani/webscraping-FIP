<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Years extends Model
{
    use HasFactory;
    protected $fillable = ['year', 'fuel_type', 'model_id'];

    public function model()
    {
        return $this->belongsTo(Model::class);
    }
}
