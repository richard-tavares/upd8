<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'birth_date',
        'gender',
        'city_id',
        'address',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
