<?php

namespace Ancient\Models;

use DateTime;
use Exception;
use Szagot\Helper\Attributes\IgnoreField;
use Szagot\Helper\Attributes\PrimaryKey;
use Szagot\Helper\Attributes\Table;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;
use Szagot\Helper\Conn\Model\aModel;
use Szagot\Helper\Conn\Query;

#[Table(name: 'rooms')]
class Room extends aModel
{
    #[PrimaryKey(autoIncrement: false)]
    protected string  $code                = '';
    protected ?int    $fase                = 0;
    protected ?int    $secret_character_id = null;
    protected ?int    $out_gamer_id        = null;
    protected ?int    $qt_rounds           = 0;
    protected ?string $created_at;

    #[IgnoreField]
    protected ?Gamer     $outOfLoopGamer  = null;
    #[IgnoreField]
    protected ?Character $secretCharacter = null;
    #[IgnoreField]
    protected ?array     $gamers          = [];

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): Room
    {
        $this->code = $code;
        return $this;
    }

    public function getFase(): ?int
    {
        return $this->fase;
    }

    public function setFase(?int $fase): Room
    {
        $this->fase = $fase;
        return $this;
    }

    public function increaseFase(): Room
    {
        if (!$this->fase) {
            $this->fase = 0;
        }

        $this->fase++;
        return $this;
    }

    public function getSecretCharacterId(): ?int
    {
        return $this->secret_character_id;
    }

    public function setSecretCharacterId(?int $secret_character_id): Room
    {
        $this->secret_character_id = $secret_character_id;
        return $this;
    }

    public function getOutGamerId(): ?int
    {
        return $this->out_gamer_id;
    }

    public function setOutGamerId(?int $out_gamer_id): Room
    {
        $this->out_gamer_id = $out_gamer_id;
        return $this;
    }

    public function getQtRounds(): ?int
    {
        return $this->qt_rounds;
    }

    public function setQtRounds(?int $qt_rounds): Room
    {
        $this->qt_rounds = $qt_rounds;
        return $this;
    }

    /**
     * @throws ConnException
     */
    public function getSecretCharacter(): ?Character
    {
        if (!$this->secretCharacter && $this->secret_character_id) {
            $this->secretCharacter = Crud::get(Character::class, $this->secret_character_id);
        }

        return $this->secretCharacter;
    }

    /**
     * @throws ConnException
     */
    public function getOutOfTheLoopGamer(): ?Gamer
    {
        if (!$this->outOfLoopGamer && $this->out_gamer_id) {
            $this->outOfLoopGamer = Crud::get(Gamer::class, $this->out_gamer_id);
        }

        return $this->outOfLoopGamer;
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
        if (empty($this->gamers) && $this->code) {
            $this->gamers = Query::exec(
                'SELECT g.* FROM gamers g INNER JOIN rooms r ON g.room_code = r.code WHERE r.code = :code',
                [
                    'code' => $this->code,
                ],
                Gamer::class
            ) ?? [];
        }

        return $this->gamers;
    }

    public function setSecrets(): Room
    {
        if (!$this->code) {
            return $this;
        }

        $secret = Query::exec(
            'SELECT * FROM characters ORDER BY RAND() LIMIT 1',
            null,
            Character::class
        )[0] ?? null;
        if ($secret) {
            $this->secret_character_id = $secret->getId();
            $this->secretCharacter = $secret;
        }

        $gamers = $this->getGamers();
        $outOfLoop = $gamers[rand(0, count($gamers) - 1)];
        if ($outOfLoop) {
            $this->out_gamer_id = $outOfLoop->getId();
            $this->outOfLoopGamer = $outOfLoop;
        }

        return $this;
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