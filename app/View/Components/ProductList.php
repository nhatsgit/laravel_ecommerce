<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductList extends Component
{
    public $products;
    public $uiSize;

    public function __construct($products, $uiSize = 4)
    {
        $this->products = $products;
        $this->uiSize = $uiSize;
    }

    public function render()
    {
        return view('components.product-list');
    }
}
