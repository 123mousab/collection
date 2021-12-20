<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionMapTest extends TestCase
{
    private function map($items, $callback)
    {
        $result = [];

        foreach ($items as $item){
            $result[] = $callback($item);
        }
        return $result;
    }

    public function test_double_each_number()
    {
        $doubled = $this->map([1, 2, 3, 4, 5], function ($number) {
            return $number * 2;
        });

        $this->assertEquals([2, 4, 6, 8, 10], $doubled);
    }

    public function test_get_user_emails()
    {
        $users = [
            ['name' => 'John', 'email' => 'john@example.com'],
            ['name' => 'Jane', 'email' => 'jane@example.com'],
            ['name' => 'Dana', 'email' => 'dana@example.com'],
        ];

        $emails = $this->map($users, function ($user) {
            return $user['email'];
        });

        $this->assertEquals([
            'john@example.com',
            'jane@example.com',
            'dana@example.com'
        ], $emails);
    }

    public function test_convert_dates_to_day_of_week()
    {
        $dates = [
            new \DateTime('2015-04-15'),
            new \DateTime('2015-07-20'),
            new \DateTime('2015-09-05'),
        ];

        $days = $this->map($dates, function ($date) {
            return $date->format('l');
        });

        $this->assertEquals([
            'Wednesday',
            'Monday',
            'Saturday',
        ], $days);
    }

    // part 2
    public function test_get_employee_names()
    {
        $employees = [
            ['name' => 'John', 'department' => 'Sales'],
            ['name' => 'Jane', 'department' => 'Marketing'],
            ['name' => 'Dave', 'department' => 'Marketing'],
            ['name' => 'Dana', 'department' => 'Engineering'],
            ['name' => 'Beth', 'department' => 'Marketing'],
            ['name' => 'Kyle', 'department' => 'Engineering'],
        ];

        $employeeNames = $this->map($employees, function ($employee){
            return $employee['name'];
        });

        $this->assertEquals([
            'John',
            'Jane',
            'Dave',
            'Dana',
            'Beth',
            'Kyle',
        ], $employeeNames);
    }

    public function test_get_the_year_from_each_date()
    {
        $dates = [
            new \DateTime('2015-01-05'),
            new \DateTime('1967-11-23'),
            new \DateTime('1988-10-14'),
            new \DateTime('1995-05-04'),
            new \DateTime('2007-08-09'),
        ];

        $years = $this->map($dates, function ($date){
            return $date->format('Y');
        });

        $this->assertEquals([
            '2015',
            '1967',
            '1988',
            '1995',
            '2007',
        ], $years);
    }

    public function test_convert_each_price_in_cents_into_a_displayable_format()
    {
        $pricesInCents = [
            79,
            599,
            699,
            289,
            89,
            249,
            785,
        ];

        $displayPrices = $this->map($pricesInCents, function ($priceInCent){
            return '$'.$priceInCent/100;
        });

        $this->assertEquals([
            '$0.79',
            '$5.99',
            '$6.99',
            '$2.89',
            '$0.89',
            '$2.49',
            '$7.85',
        ], $displayPrices);
    }
}
