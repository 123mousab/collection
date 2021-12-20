<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionFilterTest extends TestCase
{
    /**
     * @test
     */
    public function test_remove_odd_numbers()
    {
        $evens = $this->filter([1, 2, 3, 4, 5, 6], function ($number) {
            return $number % 2 == 0;
        });

        $this->assertEquals([2, 4, 6], $evens);
    }

    public function test_get_part_time_employees()
    {
        $employees = [
            ['name' => 'John', 'department' => 'Sales', 'employment' => 'Part Time'],
            ['name' => 'Jane', 'department' => 'Marketing', 'employment' => 'Part Time'],
            ['name' => 'Dave', 'department' => 'Marketing', 'employment' => 'Salary'],
            ['name' => 'Dana', 'department' => 'Engineering', 'employment' => 'Full Time'],
            ['name' => 'Beth', 'department' => 'Marketing', 'employment' => 'Part Time'],
            ['name' => 'Kyle', 'department' => 'Engineering', 'employment' => 'Full Time'],
        ];

        $employees = $this->filter($employees, function ($employee) {
            return $employee['employment'] == 'Part Time';
        });

        $this->assertEquals([
                ['name' => 'John', 'department' => 'Sales', 'employment' => 'Part Time'],
                ['name' => 'Jane', 'department' => 'Marketing', 'employment' => 'Part Time'],
                ['name' => 'Beth', 'department' => 'Marketing', 'employment' => 'Part Time']
            ]
            , $employees);
    }

    public function test_products_that_are_out_of_stock()
    {
        $products = [
            ['product' => 'Banana', 'stock_quantity' => 12],
            ['product' => 'Milk', 'stock_quantity' => 0],
            ['product' => 'Cream', 'stock_quantity' => 34],
            ['product' => 'Sugar', 'stock_quantity' => 0],
            ['product' => 'Apple', 'stock_quantity' => 22],
            ['product' => 'Bread', 'stock_quantity' => 11],
            ['product' => 'Coffee', 'stock_quantity' => 0],
        ];

        $products = collect($products)->filter(function ($product) {
            return collect([0])->contains($product['stock_quantity']);
        });
        $this->assertEquals([
                ['product' => 'Milk', 'stock_quantity' => 0],
                ['product' => 'Sugar', 'stock_quantity' => 0],
                ['product' => 'Coffee', 'stock_quantity' => 0],
            ]
            , $products->values()->all());
    }

    private function filter($items, $callback)
    {
        $result = [];

        foreach ($items as $item) {
            if ($callback($item)) {
                $result[] = $item;
            }
        }

        return $result;
    }
}
