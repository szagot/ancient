<?php

namespace Ancient\Service;

use Ancient\Config\Output;
use Ancient\Models\Gamer;
use Ancient\Models\Room as ModelRoom;
use Sz\Config\Uri;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;

class Room
{
    public static function run(Uri $uri): void
    {
        try {
            $code = $uri->opcao;
            if (empty($code) && $uri->getMethod() != 'POST') {
                Output::error('Informe o código da sua sala');
            }

            /** @var ModelRoom $room */
            $room = Crud::get(ModelRoom::class, $code);
            if ($room?->code != $code && $uri->getMethod() != 'POST') {
                Output::error('Código da sala inválido', Output::ERROR_NOT_FOUND);
            }

            switch ($uri->getMethod()) {
                case 'GET':
                    switch ($uri->detalhe) {
                        case 'gamers':
                            Output::success($room->getGamers());
                        case 'outOfLoop':
                            Output::success($room->getOutOfTheLoopGamer());
                        case 'secret':
                            Output::success($room->getSecretCharacter());
                        default:
                            Output::success($room);
                    }

                case 'POST':
                    $name = strtolower($uri->getParam('name'));
                    if (empty($name)) {
                        Output::error('Informe o seu nome de jogador');
                    }
                    if (!preg_match('/^[a-z0-9]+$/i', $name)) {
                        Output::error('O nome só pode ter letras e números. Nada de espaços ou caracteres especiais. E nem acentos!');
                    }

                    // Informado código? Verifica se já tem um jogador na sala:
                    if ($code) {
                        if (!$room) {
                            Output::error('Código da sala inválido', Output::ERROR_NOT_FOUND);
                        }

                        /** @var Gamer $gamer */
                        foreach ($room->getGamers() as $gamer) {
                            if ($gamer->name == $name) {
                                Output::error('Esse nome já foi escolhido');
                            }
                        }

                        $id = Crud::insert(Gamer::class, Gamer::newGamer($name, $room->code));
                        Output::success(
                            [
                                'room_code' => $room->code,
                                'gamer_id'  => $id,
                            ],
                            Output::POST_SUCCESS
                        );
                    }

                    // Cria uma sala nova
                    $room = ModelRoom::newRoom();
                    $gamer = Gamer::newGamer($name, $room->code);
                    Crud::insert(ModelRoom::class, $room);
                    $id = Crud::insert(Gamer::class, $gamer);

                    Output::success(
                        [
                            'room_code' => $room->code,
                            'gamer_id'  => $id,
                        ],
                        Output::POST_SUCCESS
                    );

                case 'DELETE':
                    $id = $uri->getParam('id');
                    if (!$id) {
                        Output::error('Para deixar a sala você precisa informar seu ID');
                    }

                    Crud::delete(Gamer::class, 'id', $id);

                    // Se após deletar um jogador, nenhum ficou na sala, apaga a sala
                    $gamers = $room->getGamers();
                    if (!$gamers) {
                        Crud::delete(ModelRoom::class, 'code', $code);
                    }

                    Output::success(null, Output::DELETE_SUCCESS);
            }
        } catch (ConnException $e) {
            Output::error($e->getMessage());
        }
    }
}