<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficeSpace extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'thumbnail',
        'address',
        'is_open',
        'is_fully_booked',
        'price',
        'duration',
        'about',
        'city_id',
        'slug',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function benefits()
    {
        return $this->hasMany(OfficeSpaceBenefit::class);
    }

    public function photos()
    {
        return $this->hasMany(OfficeSpacePhoto::class);
    }
}
