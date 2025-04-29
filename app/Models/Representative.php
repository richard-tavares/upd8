<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'birth_date',
        'gender',
        'city_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
