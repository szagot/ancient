<?php

namespace Ancient\Models;

class Gamer
{
    const TABLE = 'gamers';

    public int     $id;
    public ?string $name;
    public ?int    $points   = 0;
    public ?int    $room_code;
    public ?bool   $finished = false;

    public function getRoom(): ?Room
    {
        // TODO
        return null;
    }
}