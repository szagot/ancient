<?php

namespace Ancient\Models;

use Ancient\Control\Crud;
use Ancient\Exception\AncientException;
use DateTime;
use Exception;

class Room
{
    const TABLE = 'room';

    // Código hexadecimal de 6 dígitos
    public string  $code;
    public ?int    $fase                = 0;
    public ?int    $secret_character_id = null;
    public ?int    $out_gamer_id        = null;
    public ?int    $qt_rounds           = 0;
    public ?string $created_at;

    /**
     * @throws AncientException
     */
    public function getSecretCharacter(): ?Character
    {
        return Crud::get(Character::class, 'id', $this->secret_character_id);
    }

    /**
     * @throws AncientException
     */
    public function getOutOfTheLoopGamer(): ?Gamer
    {
        return Crud::get(Gamer::class, 'id', $this->out_gamer_id);
    }

    public function getCreatedAt(): ?DateTime
    {
        try {
            return new DateTime($this?->created_at ?? 'now');
        } catch (Exception) {
            return new DateTime('now');
        }
    }

    public static function newRoom()
    {
        $room = new Room();
        $rand = md5(uniqid(rand(), true));
        // Gera um código aleatório de 6 caracteres
        $room->code = strtoupper(substr($rand, rand(0, strlen($rand) - 6), 6));
        $room->created_at = date('Y-m-d H:i:s');
        return $room;
    }
}