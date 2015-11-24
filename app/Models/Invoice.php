<?php namespace Celebgramme\Models;

use Illuminate\Database\Eloquent\Model;
use Celebgramme\Helpers\GeneralHelper;

class Invoice extends Model {

	/**
	 * untuk koneksi ke database utama
	 *
	 * @var string
	 */
	protected $connection = 'mysql_axs';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'invoices';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['total','no_invoice','billing_name','billing_date','customer_id'];
	public 		$timestamps = false;
	
	protected function createInvoice($total, $customer_id, $billing_name)
	{
		$invoice = new Invoice;
		$dt = Carbon::now();
		$str = 'IAXM'.$dt->format('ymdHi');
		$invoice_number = GeneralHelper::autoGenerateID($invoice, 'no_invoice', $str, 3, '0');
		
		$invoice->no_invoice = $invoice_number;
		$invoice->total = $total;
		$invoice->billing_name = $billing_name;
		$invoice->billing_date = $dt;
		$invoice->save();
		return [
			'invoice_number' => $invoice_number,
			'invoice_id' => $invoice->id,
		];
	}
}
