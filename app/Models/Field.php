<?php

namespace App\Models;

use App\Models\Parcel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Field extends Model
{
    /** @use HasFactory<\Database\Factories\FieldFactory> */
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function parcels()
    {
        return $this->hasMany(Parcel::class);
    }
}