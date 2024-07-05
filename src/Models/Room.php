<?php

namespace Ancient\Models;

use DateTime;
use Exception;
use Szagot\Helper\Conn\aModel;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;
use Szagot\Helper\Conn\Query;

class Room extends aModel
{
    const TABLE = 'rooms';

    // Código hexadecimal de 6 dígitos
    public string  $code;
    public ?int    $fase                = 0;
    public ?int    $secret_character_id = null;
    public ?int    $out_gamer_id        = null;
    public ?int    $qt_rounds           = 0;
    public ?string $created_at;

    /**
     * @throws ConnException
     */
    public function getSecretCharacter(): ?Character
    {
        return Crud::get(Character::class, 'id', $this->secret_character_id);
    }

    /**
     * @throws ConnException
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

    public function getGamers(): array
    {
        return Query::exec(
            'SELECT g.* FROM gamers g INNER JOIN rooms r ON g.room_code = r.code WHERE r.code = :code',
            [
                'code' => $this->code,
            ],
            Gamer::class
        ) ?? [];
    }


    public function setSecrets(): void
    {
        if (!$this->code) {
            return;
        }

        $secret = Query::exec(
            'SELECT * FROM characters ORDER BY RAND() LIMIT 1',
            null,
            Character::class
        )[0] ?? null;
        if($secret){
            $this->secret_character_id = $secret->id;
        }

        $gamers = $this->getGamers();
        $outOfLoop = $gamers[rand(0, count($gamers) - 1)];
        if($outOfLoop){
            $this->out_gamer_id = $outOfLoop->id;
        }
    }

    public static function newRoom(): Room
    {
        $room = new Room();
        $rand = md5(uniqid(rand(), true));
        // Gera um código aleatório de 6 caracteres
        $room->code = strtoupper(substr($rand, rand(0, strlen($rand) - 6), 6));
        $room->created_at = date('Y-m-d H:i:s');
        return $room;
    }

}