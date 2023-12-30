<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model for an identification document type.
 *
 * @package AdminISOL\HostingPlan
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 * @see HostingPlan, HostingAccount
 */
class IdentificationDocumentType extends Model
{
    use HasFactory;

	protected $table = 'id_doc_type';
}
