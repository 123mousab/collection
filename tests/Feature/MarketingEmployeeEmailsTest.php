<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MarketingEmployeeEmailsTest extends TestCase
{
    public function test()
    {
        $employees = collect([
            ['name' => 'John', 'department' => 'Sales', 'email' => 'john3@example.com'],
            ['name' => 'Jane', 'department' => 'Marketing', 'email' => 'jane8@example.com'],
            ['name' => 'Dave', 'department' => 'Marketing', 'email' => 'dave1@example.com'],
            ['name' => 'Dana', 'department' => 'Engineering', 'email' => 'dana8@example.com'],
            ['name' => 'Beth', 'department' => 'Marketing', 'email' => 'beth4@example.com'],
            ['name' => 'Kyle', 'department' => 'Engineering', 'email' => 'kyle8@example.com'],
        ]);

        $emails = $employees->filter(function ($employee){
            return $employee['department'] == 'Marketing';
        })->map(function ($employee){
            return $employee['email'];
        })->values();

        $this->assertEquals([
            'jane8@example.com',
            'dave1@example.com',
            'beth4@example.com',
        ], $emails->all());
    }
}
