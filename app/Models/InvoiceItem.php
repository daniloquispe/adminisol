<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model for an invoice item.
 *
 * @property string $description
 * @property int $id Invoice item ID
 * @property int $invoice_id Invoice ID
 * @property float $list_unit_price
 * @property int $qty Quantity Unit price from price list (no discounts applied)
 * @property float $unit_price Unit price (using currency indicated in invoice)
 * @property-read float $subtotal
 */
class InvoiceItem extends Model
{
    use HasFactory;

	protected $table = 'invoice_item';

	public function subtotal(): Attribute
	{
		return Attribute::make(fn() => $this->qty * $this->unit_price);
	}
}
