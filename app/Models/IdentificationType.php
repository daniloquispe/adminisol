<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @deprecated Use {@see IdentificationDocumentType} model instead of this one
 * @see IdentificationDocumentType
 */
class IdentificationType extends Model
{
    use HasFactory;

	protected $table = 'id_doc_type';
}
