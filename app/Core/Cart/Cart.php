<?php
namespace App\Core\Cart;

class Cart
{
	public $Products = [];
	protected $DeliveryTotal = 0;

	function __construct(float $delivery_cost = 0, float $delivery_min = 0, $delivery_time_min = 60, $delivery_free_on = 0, $delivery_free_from = 0)
	{
		$this->DeliveryMin = (float) $delivery_min;
		$this->DeliveryCost = (float) $delivery_cost;
		$this->DeliveryFreeFrom = (float) $delivery_free_from;
		$this->DeliveryFreeOn = (int) $delivery_free_on;
		$this->DeliveryTime = (int) $delivery_time_min;
	}

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
		return $cost;
	}

	function PackingCost()
	{
		$cost = 0;
		foreach ($this->Products as $k => $p) {
			$cost += $p->PackingCost();
		}
		return $cost;
	}

	function DeliveryCost()
	{
		$this->DeliveryTotal = $this->DeliveryCost;
		if($this->DeliveryFreeOn) {
			if($this->ProductsCost >= $this->DeliveryFreeFrom) {
				$this->DeliveryTotal = 0;
			}
		}
		return $this->DeliveryTotal;
	}

	function TotalCost()
	{
		return ( $this->ProductsCost() + $this->PackingCost() + $this->DeliveryCost() );
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