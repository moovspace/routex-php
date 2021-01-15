<?php
namespace App\Core\Cart;

class Addon
{
	function __construct(int $id, int $qty = 1, float $price, float $packing = 0, string $name = '', float $price_sale = 0)
	{
		if($qty < 1) {
			$qty = 1;
		}
		$this->Qty = $qty;
		$this->Id = $id;
		$this->Price = $price;
		$this->PriceSale = $price_sale;
		$this->Packing = $packing;
		$this->Name = $name;
	}

	function AddonCost()
	{
		if( $this->PriceSale > 0) {
			return ( $this->Qty * $this->PriceSale );
		}
		return ( $this->Qty * $this->Price );
	}

	function PackingCost()
	{
		return ( $this->Qty * $this->Packing );
	}

	function TotalCost()
	{
		return ( $this->AddonCost() + $this->PackingCost() );
	}
}