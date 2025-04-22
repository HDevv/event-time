<?php


namespace App\Service;

class EventService
{
    private $events = [];

    public function __construct()
    {
        $this->events = [
            ['id' => 1, 'name' => 'Concert', 'startAt' => new \DateTime('2022-03-01 08:00:00'), 'endAt' => new \DateTime('2022-03-01 13:30:00')],
            ['id' => 2, 'name' => 'Cinema', 'startAt' => new \DateTime('2025-04-18 08:00:00'), 'endAt' => new \DateTime('2025-04-18 21:00:00')],
            ['id' => 3, 'name' => 'Plage', 'startAt' => new \DateTime('2025-05-20 08:00:00'), 'endAt' => new \DateTime('2025-05-20 13:30:00')],
        ]; 
    }

    public function all()
    {
        return $this->events;
    }

    public function find($id) {
        foreach ($this->events as $event) {
            if ($event['id'] == $id) {
                return $event;
            }
        }

        return null;
    }
}