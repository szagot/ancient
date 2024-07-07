<?php

namespace Ancient\Service;

use Ancient\Config\Output;
use Ancient\Models\Gamer;
use Ancient\Models\Room as ModelRoom;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;
use Szagot\Helper\Server\Uri;

class Room
{
    public static function run(): void
    {
        $uri = Uri::newInstance();
        try {
            $code = $uri->getUri(1);
            if (empty($code) && $uri->getMethod() != 'POST') {
                Output::error('Informe o código da sua sala');
            }

            /** @var ModelRoom $room */
            $room = Crud::get(ModelRoom::class, $code);
            if ($room?->getCode() != $code && $uri->getMethod() != 'POST') {
                Output::error('Código da sala inválido', Output::ERROR_NOT_FOUND);
            }

            switch ($uri->getMethod()) {
                case 'GET':
                    $room->getGamers();
                    $room->getOutOfTheLoopGamer();
                    $room->getSecretCharacter();
                    Output::success($room->toArray(true));

                case 'POST':
                    $name = strtolower($uri->getParameter('name'));
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
                            if ($gamer->getName() == $name) {
                                Output::error('Esse nome já foi escolhido');
                            }
                        }

                        $id = Crud::insert(Gamer::class, Gamer::newGamer($name, $room->getCode()));
                        Output::success(
                            [
                                'room_code' => $room->getCode(),
                                'gamer_id'  => $id,
                            ],
                            Output::POST_SUCCESS
                        );
                    }

                    // Cria uma sala nova
                    $room = ModelRoom::newRoom();
                    $gamer = Gamer::newGamer($name, $room->getCode());
                    Crud::insert(ModelRoom::class, $room);
                    $id = Crud::insert(Gamer::class, $gamer);

                    Output::success(
                        [
                            'room_code' => $room->getCode(),
                            'gamer_id'  => $id,
                        ],
                        Output::POST_SUCCESS
                    );

                case 'DELETE':
                    $id = $uri->getParameter('id');
                    if (!$id) {
                        Output::error('Para deixar a sala você precisa informar seu ID');
                    }

                    Crud::delete(Gamer::class, $id);

                    // Se após deletar um jogador, nenhum ficou na sala, apaga a sala
                    $gamers = $room->getGamers();
                    if (!$gamers) {
                        Crud::delete(ModelRoom::class, $code);
                    }

                    Output::success(null, Output::DELETE_SUCCESS);
            }
        } catch (ConnException $e) {
            Output::error($e->getMessage());
        }
    }
}