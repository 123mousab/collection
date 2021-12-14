<?php

namespace App\Collection;

use Illuminate\Support\Facades\Storage;

class RefactoringCollection
{
    public function getProducts()
    {
        return json_decode(Storage::disk('public')->get('products.json'), true)['products'];
    }

    public function pricingLampsAndWallet()
    {
        // imperative programming => total = 543.18
//        $this->imperativePricingLampsAndWallet();

        $lampsAndWallets = collect($this->getProducts())->filter(function ($product){
            return collect(['Lamp', 'Wallet'])->contains($product['product_type']);
        })->flatMap(function ($product){
            return $product['variants'];
        })->sum('price');

        return $lampsAndWallets;
    }

    private function imperativePricingLampsAndWallet()
    {
        $totalCost = 0;

        foreach ($this->getProducts() as $product){
            if ($product['product_type'] == 'Lamp' || $product['product_type'] == 'Wallet')
            {
                foreach ($product['variants'] as $variant){
                    $totalCost = $totalCost + $variant['price'];
                }
            }
        }

        return $totalCost;
    }
}
