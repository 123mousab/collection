<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionReduceTest extends TestCase
{
    private function reduce($items, $callback, $initial)
    {
        $accumulator = $initial;

        foreach ($items as $item) {
            $accumulator = $callback($accumulator, $item);
        }

        return $accumulator;
    }

    public function test_add_numbers()
    {
        $sum = $this->reduce([1, 2, 3, 4, 5, 6], function ($sum, $number) {
            return $sum + $number;
        }, 0);

        $this->assertEquals(21, $sum);
    }

    public function test_join_emails()
    {
        $emails = [
            'john@example.com',
            'jane@example.com',
            'dana@example.com',
        ];

        $joined = $this->reduce($emails, function ($joined, $email) {
            return $joined . $email . ',';
        }, '');

        $this->assertEquals("john@example.com,jane@example.com,dana@example.com,", $joined);
    }

    public function test_join_grocery_list_lines()
    {
        $groceries = [
            'Bananas',
            'Milk',
            'Cream',
            'Sugar',
            'Apples',
            'Bread',
            'Coffee',
        ];

        $groceryList = $this->reduce($groceries, function ($groceryList, $groceryItem) {
            return $groceryList . $groceryItem . "\n";
        }, '');

        $this->assertEquals("Bananas\nMilk\nCream\nSugar\nApples\nBread\nCoffee\n", $groceryList);
    }

    public function test_calculate_the_product_of_a_list_of_numbers()
    {
        $numbers = [1, 2, 3, 4, 5, 6];

        $product = $this->reduce($numbers, function ($sum, $number){
            return $sum * $number;
        }, 1);

        $this->assertEquals(720, $product);
    }

    public function test_create_an_associative_array_of_names_and_emails()
    {
        $users = [
            ['name' => 'John', 'email' => 'john@example.com'],
            ['name' => 'Jane', 'email' => 'jane@example.com'],
            ['name' => 'Dana', 'email' => 'dana@example.com'],
        ];

        $emailLookup = $this->reduce($users, function ($emailLookup, $user){
            $emailLookup[$user['name']] = $user['email'];
            return $emailLookup;
        }, []);

        $this->assertEquals([
            'John' => 'john@example.com',
            'Jane' => 'jane@example.com',
            'Dana' => 'dana@example.com',
        ], $emailLookup);
    }
}
