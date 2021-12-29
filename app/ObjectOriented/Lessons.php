<?php

namespace App\ObjectOriented;

class Lessons
{
    protected $name;
    protected $members = [];

    public function __construct($name = null, $members = [])
    {
        $this->name = $name;
        $this->members = $members;
    }

    public static function start(...$params)
    {
        return new static(...$params); // pass to constructor
    }

    public function name()
    {
        return $this->name;
    }

    public function members()
    {
        return $this->members;
    }

    public function addMembers($member)
    {
         $this->members[] = $member;
    }

    public function exec1()
    {
       $obj = new Lessons('mousab', [
          'mousab',
           'majed',
           'salah'
       ]);

        dump($obj->name());
       dump($obj->members());

       $obj2 = Lessons::start('samy', ['samy', 'majed', 'salah']);
        dump($obj2->name());
        dump($obj2->members());
        $obj2->addMembers('mousab');
        dump($obj2->members());
    }
}
