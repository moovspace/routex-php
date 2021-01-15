<?php
namespace App\Core\Cart;

class Product
{
	public $Addons = [];

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

	function Addon($a)
	{
		if(!empty($a->Id)) {
			$hash = $a->Id;
			if(array_key_exists($hash, $this->Addons)) {
				$this->Addons[$hash]->Qty = $this->Addons[$hash]->Qty + $a->Qty;
			} else {
				$this->Addons[$hash] = $a;
			}
		}
	}

	function ProductCost()
	{
		if( $this->PriceSale > 0) {
			return ( $this->Qty * $this->PriceSale ) + $this->AddonsCost();
		}
		return ( $this->Qty * $this->Price ) + $this->AddonsCost();
	}

	function PackingCost()
	{
		return ( $this->Qty * $this->Packing ) + $this->AddonsPackingCost();
	}

	function AddonsCost()
	{
		$cost = 0;
		foreach ($this->Addons as $k => $v) {
			$cost += $this->Qty * $v->AddonCost();
		}
		return $cost;
	}

	function AddonsPackingCost()
	{
		$cost = 0;
		foreach ($this->Addons as $k => $v) {
			$cost += $this->Qty * $v->PackingCost();
		}
		return $cost;
	}

	function TotalCost()
	{
		return ( $this->ProductCost() + $this->PackingCost() );
	}
}