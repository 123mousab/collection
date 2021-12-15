<?php

namespace App\Collection;

use Illuminate\Support\Facades\Storage;

class GithubScore
{

    private $events;

    public function __construct($events)
    {
        $this->events = $events;
    }

    public static function getEvents()
    {
        return json_decode(Storage::disk('public')->get('events.json'), true);
    }


    public  function score()
    {
        $events = new GithubScore(static::getEvents());
        // imperative github score
//        dd($this->imperativeGithubScore($events));
        $scores = collect($this->events)->pluck('type')->map(function ($eventType){
            return static::lookup_event_score($eventType);
        })->sum();
        dd($scores);
    }

    public static function lookup_event_score($eventType)
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
