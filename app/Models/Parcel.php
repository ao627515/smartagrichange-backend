<?php

namespace App\Models;

use App\Models\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parcel extends Model
{
    /** @use HasFactory<\Database\Factories\ParcelFactory> */
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}