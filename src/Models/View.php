<?php

namespace Ancient\Models;

use Szagot\Helper\Attributes\IgnoreField;
use Szagot\Helper\Attributes\PrimaryKey;
use Szagot\Helper\Attributes\Table;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;
use Szagot\Helper\Conn\Model\aModel;

#[Table(name: 'view')]
class View extends aModel
{
    #[PrimaryKey(autoIncrement: false)]
    private ?string $room_code = '';
    private ?int    $gamer_id  = 0;
    private ?int    $qt        = 0;

    #[IgnoreField]
    private ?Room  $room  = null;
    #[IgnoreField]
    private ?Gamer $gamer = null;

    public function getRoomCode(): ?string
    {
        return $this->room_code;
    }

    public function setRoomCode(?string $room_code): View
    {
        $this->room_code = $room_code;
        return $this;
    }

    public function getGamerId(): ?int
    {
        return $this->gamer_id;
    }

    public function setGamerId(?int $gamer_id): View
    {
        $this->gamer_id = $gamer_id;
        return $this;
    }

    public function getQt(): int
    {
        return $this->qt ?? 0;
    }

    public function setQt(?int $qt = 0): View
    {
        $this->qt = $qt ?? 0;
        return $this;
    }

    public function increaseQt(): View
    {
        $this->qt++;
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

    /**
     * @throws ConnException
     */
    public function getGamer(): ?Gamer
    {
        if (!$this->gamer && $this->gamer_id) {
            $this->gamer = Crud::get(Gamer::class, $this->gamer_id);
        }

        return $this->gamer;
    }
}