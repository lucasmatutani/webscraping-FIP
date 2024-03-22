<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Years extends Model
{
    use HasFactory;
    protected $fillable = ['year', 'value', 'model_id'];

    public function model()
    {
        return $this->belongsTo(Model::class);
    }
}
