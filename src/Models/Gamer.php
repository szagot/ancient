<?php

namespace Ancient\Models;

use Szagot\Helper\Attributes\IgnoreField;
use Szagot\Helper\Attributes\PrimaryKey;
use Szagot\Helper\Attributes\Table;
use Szagot\Helper\Conn\Model\aModel;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;

#[Table(name: 'gamers')]
class Gamer extends aModel
{
    #[PrimaryKey]
    protected int     $id;
    protected ?string $name     = '';
    protected ?int    $points   = 0;
    protected ?string $room_code;
    protected ?bool   $finished = false;

    #[IgnoreField]
    private ?Room $room = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Gamer
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Gamer
    {
        $this->name = $name;
        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): Gamer
    {
        $this->points = $points;
        return $this;
    }

    public function getRoomCode(): ?string
    {
        return $this->room_code;
    }

    public function setRoomCode(?string $roomCode): Gamer
    {
        $this->room_code = $roomCode;
        return $this;
    }

    public function getFinished(): ?bool
    {
        return $this->finished;
    }

    public function setFinished(?bool $finished): Gamer
    {
        $this->finished = $finished;
        return $this;
    }

    /**
     * @throws ConnException
     */
    public function getRoom(): ?Room
    {
        if (!$this->room && $this->room_code) {
            $this->room = Crud::get(Room::class, $this->room_code);
        }

        return $this->room;
    }

    public static function newGamer(string $name, string $roomCode): Gamer
    {
        $gamer = new Gamer();
        $gamer->setName($name);
        $gamer->setRoomCode($roomCode);
        return $gamer;
    }
}