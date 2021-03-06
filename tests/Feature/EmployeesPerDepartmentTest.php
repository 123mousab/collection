<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeesPerDepartmentTest extends TestCase
{
    public function test()
    {
        $employees = collect([
            ['name' => 'John',  'department' => 'Sales',        'email' => 'john3@example.com'],
            ['name' => 'Jane',  'department' => 'Marketing',    'email' => 'jane8@example.com'],
            ['name' => 'Dave',  'department' => 'Marketing',    'email' => 'dave1@example.com'],
            ['name' => 'Dana',  'department' => 'Engineering',  'email' => 'dana8@example.com'],
            ['name' => 'Beth',  'department' => 'Marketing',    'email' => 'beth4@example.com'],
            ['name' => 'Kyle',  'department' => 'Engineering',  'email' => 'kyle8@example.com'],
            ['name' => 'Steve', 'department' => 'Sales',        'email' => 'steve7@example.com'],
            ['name' => 'Liz',   'department' => 'Engineering',  'email' => 'liz6@example.com'],
            ['name' => 'Joe',   'department' => 'Marketing',    'email' => 'joe5@example.com'],
        ]);

       /* $departmentCounts['Sales'] = $employees->filter(function ($employee){
            return $employee['department'] == 'Sales';
        })->count();

        $departmentCounts['Marketing'] = $employees->filter(function ($employee){
            return $employee['department'] == 'Marketing';
        })->count();

        $departmentCounts['Engineering'] = $employees->filter(function ($employee){
            return $employee['department'] == 'Engineering';
        })->count();*/

        $departmentCounts = $employees->groupBy('department')->map(function ($department) {
            return $department->count();
        })->all();

        $this->assertEquals([
            'Sales' => 2,
            'Marketing' => 4,
            'Engineering' => 3,
        ], $departmentCounts);
    }
}
