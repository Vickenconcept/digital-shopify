<?php

namespace App\View\Components;

use App\Models\DigitalProduct;
use Illuminate\View\Component;

class ProductCard extends Component
{
    public function __construct(
        public DigitalProduct $product,
        public bool $showAddToCart = true,
    ) {}

    public function render()
    {
        return view('components.product-card');
    }
}