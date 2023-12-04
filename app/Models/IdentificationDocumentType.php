<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentificationDocumentType extends Model
{
    use HasFactory;

	protected $table = 'identification_document_type';

	protected $keyType = 'string';
}
