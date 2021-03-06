<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShoppingCartTotalTest extends TestCase
{
    public function test()
    {
        $shoppingCart = collect([
            ['product' => 'Banana',  'unit_price' => 79,   'quantity' => 3],
            ['product' => 'Milk',    'unit_price' => 499,  'quantity' => 1],
            ['product' => 'Cream',   'unit_price' => 599,  'quantity' => 2],
            ['product' => 'Sugar',   'unit_price' => 249,  'quantity' => 1],
            ['product' => 'Apple',   'unit_price' => 76,   'quantity' => 6],
            ['product' => 'Bread',   'unit_price' => 229,  'quantity' => 2],
        ]);

        $totalPrice = $shoppingCart->reduce(function ($totalPrice, $product){
            return $totalPrice + ($product['unit_price'] * $product['quantity']);
        },0);

        $this->assertEquals(3097, $totalPrice);
    }
}
