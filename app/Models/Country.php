<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

	protected $connection = 'ubigeo';

	protected $table = 'country';

	protected $keyType = 'string';

	protected $fillable = ['is_active', 'code_2', 'code_3', 'name'];
}
