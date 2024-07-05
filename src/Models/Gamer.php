<?php

namespace Ancient\Models;

use Szagot\Conn\aModel;
use Szagot\Conn\ConnException;
use Szagot\Conn\Crud;

class Gamer extends aModel
{
    const TABLE = 'gamers';

    public int     $id;
    public ?string $name;
    public ?int    $points   = 0;
    public ?string $room_code;
    public ?bool   $finished = false;

    /**
     * @throws ConnException
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