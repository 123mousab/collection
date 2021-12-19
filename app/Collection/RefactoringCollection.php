<?php

namespace App\Collection;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class RefactoringCollection
{
    ////////////////////////////////////// #1 //////////////////////////////////////////////
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

    ////////////////////////////////////// #2 //////////////////////////////////////////////
    public function csvSurgery101()
    {
        $shifts = [
            'Shipping_Steve_A7',
            'Sales_B9',
            'Support_Tara_K11',
            'J15',
            'Warehouse_B2',
            'Shipping_Dave_A6',
        ];

        $shiftIds = collect($shifts)->map(function ($shift){
//            return last(explode('_', $shift));
            return collect(explode('_', $shift))->last();
        });

        return $shiftIds;
    }

    public function binaryToDecimal()
    {
        $binary = '100110101'; // total equals 309

        // imperative function binary to decimal
//        return $this->imperativebinaryToDecimal($binary);

        $total = collect(str_split($binary))->reverse()->values()->map(function ($column, $exponent){
            return $column * (2 ** $exponent);
        })->sum();

        return $total;
    }

    private function imperativebinaryToDecimal($binary)
    {
        $total = 0;
        $exponent = strlen($binary) - 1;

        for ($i = 0; $i < strlen($binary); $i++) {
            $decimal = $binary[$i] * (2 ** $exponent);
            $total += $decimal;
            $exponent--;
        }
        return $total;
    }

    ////////////////////////////////////// #3 //////////////////////////////////////////////
    public function getEvents()
    {
        return json_decode(Storage::disk('public')->get('events.json'), true);
    }


    public function githubScore()
    {
        $events = $this->getEvents();
        // imperative github score
//        dd($this->imperativeGithubScore($events));
        $scores = collect($events)->pluck('type')->map(function ($eventType){
            return $this->lookup_event_score($eventType);
        })->sum();
    }

    public function lookup_event_score($eventType)
    {
        return collect([
            'PushEvent' => 5,
            'CreateEvent' => 4,
            'IssuesEvent' => 3,
            'CommitCommentEvent' => 2,
        ])->get($eventType, 1);
    }
    public function imperativeGithubScore($events)
    {
        $eventTypes = [];
        foreach ($events as $event){
            $eventTypes[] = $event['type'];
        }

        // Loop over the event types and add up the corresponding scores
        $score = 0;

        foreach ($eventTypes as $eventType)
        {
            switch ($eventType){
                case 'PushEvent':
                    $score +=5;
                    break;
                case 'CreateEvent':
                    $score +=4;
                    break;
                case 'IssuesEvent':
                    $score +=3;
                    break;
                case 'CommitCommentEvent':
                    $score +=2;
                    break;
                default:
                    $score +=1;
                    break;
            }
        }
        return $score;
    }

    ////////////////////////////////////// #4 //////////////////////////////////////////////
    public function buildComment()
    {
        $message = [
            'Opening brace must be the last content on the line',
            'Closing brace must be on a line by itself',
            'Each PHP statement must be on a line by itself'
        ];

        return collect($message)->map(function ($message){
            return "- {$message}";
        })->implode('\n');
    }

    ////////////////////////////////////// #5 //////////////////////////////////////////////
    public function compareRevenue()
    {
        $lastYear = [
            2976.50, // Jan
            2788.84, // Feb
            2353.92, // Mar
            3365.36, // Apr
            2532.99, // May
            1598.42, // Jun
            2751.82, // Jul
            2576.17, // Aug
            2324.87, // Sep
            2299.21, // Oct
            3483.10, // Nov
            2245.08, // Dec
        ];
        $thisYear = [
            3461.77,
            3665.17,
            3210.53,
            3529.07,
            3376.66,
            3825.49,
            2165.24,
            2261.40,
            3988.76,
            3302.42,
            3345.41,
            2904.80,
        ];

        // imperative programming
//        $this->imperativeCompare($thisYear, $lastYear);

        return collect($thisYear)->zip($lastYear)->map(function ($thisAndLast){
            list($thisMonth, $lastMonth) = $thisAndLast;
            return $thisMonth - $lastMonth;
        });
    }

    private function imperativeCompare($thisYear, $lastYear)
    {
        $deltas = [];

        foreach ($thisYear as $month => $monthly) {
            $deltas[] = $monthly - $lastYear[$month];
        }

        return $deltas;
    }

    public function hamming_distance()
    {
        // 1 1 1 1 1 1
        $strandA = 'ACCGCCABCCCDA';
        $strandB = 'ACCDVGABCAADF';

//       return $this->imperativeHammingDistance($strandA, $strandB);

        return collect(str_split($strandA))->zip(str_split($strandB))->map(function ($strandAAndStrandB){
            list($a, $b) = $strandAAndStrandB;
            return $a == $b ? 0 : 1;
        })->sum();
    }

    private function imperativeHammingDistance($strandA, $strandB)
    {
        $distance = 0;
        for ($i=0; $i < strlen($strandA); $i++)
        {
            $distance += $strandA[$i] === $strandB[$i] ? 0 : 1;
        }
        return $distance;
    }

    public function lookupTable()
    {
        $employees = [
            [
                'name' => 'John',
                'department' => 'Sales',
                'email' => 'john@example.com'
            ],
            [
                'name' => 'Jane',
                'department' => 'Marketing',
                'email' => 'jane1@example.com'
            ],
            [
                'name' => 'Dave',
                'department' => 'Marketing',
                'email' => 'dave@example.com'
            ],
        ];


       /* $emailLookup = collect($employees)->reduce(function ($emailLookup, $employee){
            $emailLookup[$employee['email']] = $employee['name'];
            return $emailLookup;
        }, []);

        return $emailLookup;*/

         $lookup = collect($employees)->map(function ($employee){
            return [$employee['email'], $employee['name']];
        })->toAssoc();

         dd($lookup);
    }

    public function transposeForm()
    {
        /*$before = [
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9]
        ];

        return collect($before)->transpose()->all();*/
        $requestData = collect(request('contacts'))->only('names','emails','occupations')->transpose();
        $contacts = $requestData->transpose()->map(function ($contactData){
            return new Contact([
                'name' => $contactData[0],
                'email' => $contactData[1],
                'job' => $contactData[2],
            ]);
        });

        return $contacts;
    }

    public function rankingCompetition()
    {

    }
}
