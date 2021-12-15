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
        dd($scores);
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

}
