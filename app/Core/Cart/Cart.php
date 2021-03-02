<?php
namespace App\Core\Cart;

class Cart
{
	public $Products = [];
	protected $DeliveryTotal = 0;
	public $DeliveryMin = 0;
	public $DeliveryCost = 0;
	public $DeliveryFreeFrom = 0;
	public $DeliveryFreeOn = 0;
	public $DeliveryTime = 60;

	function Add($product)
	{
		$hash = $this->Hash($product);
		if(array_key_exists($hash, $this->Products)) {
			$this->Products[$hash]->Qty = $this->Products[$hash]->Qty + $product->Qty;
		} else {
			$this->Products[$hash] = $product;
		}
	}

	function Products()
	{
		return $this->Products;
	}

	function ProductsCost()
	{
		$cost = 0;
		foreach ($this->Products as $k => $p) {
			$cost += $p->ProductCost();
		}
		return number_format((float) $cost, 2, '.', '');
	}

	function PackingCost()
	{
		$cost = 0;
		foreach ($this->Products as $k => $p) {
			$cost += $p->PackingCost();
		}
		return number_format((float) $cost, 2, '.', '');
	}

	function DeliveryCost()
	{
		$this->DeliveryTotal = $this->DeliveryCost;
		if($this->DeliveryFreeOn == 1)
		{
			if($this->ProductsCost() >= $this->DeliveryFreeFrom)
			{
				$this->DeliveryTotal = 0;
			}
		}
		return number_format((float) $this->DeliveryTotal, 2, '.', '');
	}

	function TotalCost()
	{
		return number_format(( $this->ProductsCost() + $this->PackingCost() + $this->DeliveryCost() ), 2, '.', '');
	}

	function Hash($pr)
	{
		return $pr->Id . md5(serialize($pr->Addons));
	}

	function Plus($hash)
	{
		if(array_key_exists($hash, $this->Products)) {
			$this->Products[$hash]->Qty++;
		}
	}

	function Minus($hash)
	{
		if(array_key_exists($hash, $this->Products)) {
			if($this->Products[$hash]->Qty > 1) {
				$this->Products[$hash]->Qty--;
			}
		}
	}

	function Remove($hash)
	{
		if(array_key_exists($hash, $this->Products)) {
			unset($this->Products[$hash]);
		}
	}

	function PlusProductAddon($hash, $addon_id)
	{
		if(array_key_exists($hash, $this->Products)) {
			$this->Products[$hash]->Addons[$addon_id]->Qty++;
		}
	}

	function MinusProductAddon($hash, $addon_id)
	{
		if(array_key_exists($hash, $this->Products)) {
			if($this->Products[$hash]->Addons[$addon_id]->Qty > 1) {
				$this->Products[$hash]->Addons[$addon_id]->Qty--;
			}
		}
	}

	function RemoveProductAddon($hash, $addon_id)
	{
		if(array_key_exists($hash, $this->Products)) {
			unset($this->Products[$hash]->Addons[$addon_id]);
		}
	}
}