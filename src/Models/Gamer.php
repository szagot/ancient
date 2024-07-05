<?php

namespace Ancient\Models;

use Szagot\Helper\Attributes\PrimaryKey;
use Szagot\Helper\Attributes\Table;
use Szagot\Helper\Conn\Model\aModel;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;

#[Table(name: 'gamers')]
class Gamer extends aModel
{
    #[PrimaryKey]
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
        return Crud::get(Room::class, $this->room_code);
    }

    public static function newGamer(string $name, string $roomCode): Gamer
    {
        $gamer = new Gamer();
        $gamer->name = $name;
        $gamer->room_code = $roomCode;
        return $gamer;
    }
}