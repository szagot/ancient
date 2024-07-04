<?php

namespace Ancient\Models;

use Ancient\Control\Crud;
use Ancient\Exception\AncientException;

class Gamer
{
    const TABLE = 'gamers';

    public int     $id;
    public ?string $name;
    public ?int    $points   = 0;
    public ?string $room_code;
    public ?bool   $finished = false;

    /**
     * @throws AncientException
     */
    public function getRoom(): ?Room
    {
        return Crud::get(Room::class, 'code', $this->room_code);
    }

    public static function newGamer(string $name, string $roomCode): Gamer
    {
        $gamer = new Gamer();
        $gamer->name = $name;
        $gamer->room_code = $roomCode;
        return $gamer;
    }
}