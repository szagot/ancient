<?php

namespace Ancient\Models;

use DateTime;
use Exception;

class Room
{
    const TABLE = 'room';

    public string  $code;
    public ?int    $fase      = 0;
    public ?int    $secret_character_id;
    public ?int    $out_gamer_id;
    public ?int    $qt_rounds = 0;
    public ?string $created_at;

    public function getSecretCharacter(): ?Character
    {
        // TODO
        return null;
    }

    public function getOutOfTheLoopGamer(): ?Gamer
    {
        // TODO
        return null;
    }

    public function getCreatedAt(): ?DateTime
    {
        try {
            return new DateTime($this?->created_at ?? 'now');
        } catch (Exception) {
            return new DateTime('now');
        }
    }
}