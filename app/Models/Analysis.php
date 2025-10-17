<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    /** @use HasFactory<\Database\Factories\AnalysisFactory> */
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function analyzable()
    {
        return $this->morphTo('analyzable');
    }
}
