<?php

namespace Ancient\Control;

use Ancient\Models\View;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;
use Szagot\Helper\Conn\Query;

class ViewControl
{
    /**
     * Pega todos os visualizadores da sala
     *
     * @throws ConnException
     */
    public static function getAllViewers(string $roomCode): ?array
    {
        return Crud::search(View::class, 'room_code', $roomCode) ?? [];
    }

    /**
     * Pega uma visualização
     *
     * @throws ConnException
     */
    public static function get(string $roomCode, int $gamerId): ?View
    {
        return Crud::searchCustom(View::class, 'room_code = :room AND gamer_id = :id', [
            'room' => $roomCode,
            'id'   => $gamerId,
        ])[0] ?? null;
    }

    /**
     * Aumenta em 1 a visualização
     *
     * @throws ConnException
     */
    public static function increaseView(View $view): ?View
    {
        $view->increaseQt();

        if (!Query::exec(
            'UPDATE views SET qt = :qt WHERE room_code = :room AND gamer_id = :id',
            [
                'room' => $view->getRoomCode(),
                'id'   => $view->getGamerId(),
                'qt'   => $view->getQt(),
            ]
        )) {
            throw new ConnException('Não foi possível aumentar a quantidade de views.');
        }

        return $view;
    }

    /**
     * Cria uma nova visualização
     *
     * @param string    $roomCode
     * @param int       $gamerId
     * @param bool|null $blockIncrease Se TRUE, caso o viewer já exista, ele não incrementa
     *
     * @return View|null
     * @throws ConnException
     */
    public static function insert(string $roomCode, int $gamerId, ?bool $blockIncrease = false): ?View
    {
        // Verifica se já existe
        $view = self::get($roomCode, $gamerId);
        if ($view) {
            // Se existe, incrementa e devolve. Se o incremento estiver bloqueado, apenas devolve.
            return $blockIncrease ? $view : self::increaseView($view);
        }

        $view = new View();
        $view
            ->setRoomCode($roomCode)
            ->setGamerId($gamerId)
            ->setQt(1);

        Crud::insert(View::class, $view);

        return $view;
    }

    /**
     * @throws ConnException
     */
    public static function clearViewersRoom(string $roomCode): void
    {
        Crud::delete(View::class, $roomCode);
    }
}