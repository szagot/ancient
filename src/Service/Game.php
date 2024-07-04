<?php

namespace Ancient\Service;

use Ancient\Config\Output;
use Ancient\Control\Crud;
use Ancient\Exception\AncientException;
use Ancient\Models\Gamer;
use Ancient\Models\Room as ModelRoom;
use Sz\Config\Uri;

class Game
{
    public static function run(Uri $uri): void
    {
        try {
            // Código da sala
            $code = $uri->opcao;
            if (empty($code)) {
                Output::error('Informe o código da sua sala');
            }

            /** @var ModelRoom $room */
            $room = Crud::get(ModelRoom::class, 'code', $code);
            if ($room?->code != $code) {
                Output::error('Código da sala inválido', Output::ERROR_NOT_FOUND);
            }

            // ID do Jogador
            $gamerId = $uri->detalhe;
            if (empty($gamerId)) {
                Output::error('Informe o ID do Jogador');
            }

            /** @var Gamer $gamer */
            $gamer = Crud::get(Gamer::class, 'id', $gamerId);
            if (!$gamer || $gamer->room_code != $room->code) {
                Output::error('Jogador não localizado na sala', Output::ERROR_NOT_FOUND);
            }

            switch ($uri->getMethod()) {
                case 'GET':
                    switch ($uri->outros[0] ?? null) {
                        // Permite o início do Jogo?
                        case 'allow':
                            Output::success(
                                [
                                    'code'  => $code,
                                    'allow' => self::allowGame($room),
                                ]
                            );
                        default:
                            Output::success($gamer);
                    }

                case 'POST':
            }

        } catch (AncientException $e) {
            Output::error($e->getMessage());
        }
    }

    /**
     * O Jogo só pode rodar com pelo menos 3 jogadores
     *
     * @param ModelRoom $room
     *
     * @return bool
     */
    private static function allowGame(ModelRoom $room): bool
    {
        return count($room->getGamers()) >= 3;
    }
}