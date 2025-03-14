<?php
class CartItem
{
    public $productId;
    public $quantity;

    public function __construct($productId, $quantity = 1)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }
}
