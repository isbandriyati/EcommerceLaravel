<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public $categories;
    public $carts;

    public function __construct($categories, $carts = [])
    {
        $this->categories = $categories;
        $this->carts = $carts;
    }

    public function render()
    {
        return view('Components.navbar');
    }
}
