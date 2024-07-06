<?php

namespace Ancient\Service;

use Ancient\Config\Output;
use Ancient\Models\Gamer;
use Ancient\Models\Question;
use Ancient\Models\Room as ModelRoom;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;
use Szagot\Helper\Server\Uri;

class Game
{
    private static array $questions = [];

    public static function run(): void
    {
        $uri = Uri::newInstance();
        try {
            // Código da sala
            $code = $uri->getUri(1);
            if (empty($code)) {
                Output::error('Informe o código da sua sala');
            }

            /** @var ModelRoom $room */
            $room = Crud::get(ModelRoom::class, $code);
            if ($room?->code != $code) {
                Output::error('Código da sala inválido', Output::ERROR_NOT_FOUND);
            }

            // ID do Jogador
            $gamerId = $uri->getUri(2);
            if (empty($gamerId)) {
                Output::error('Informe o ID do Jogador');
            }

            /** @var Gamer $gamer */
            $gamer = Crud::get(Gamer::class, $gamerId);
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
                    Output::success(self::nextFase($room), Output::POST_SUCCESS);
            }

        } catch (ConnException $e) {
            Output::error($e->getMessage());
        }
    }

    /**
     * O Jogo só pode rodar com pelo menos 3 jogadores
     *
     * @param ModelRoom $room
     *
     * @return bool
     * @throws ConnException
     */
    private static function allowGame(ModelRoom $room): bool
    {
        return count($room->getGamers()) >= 3 && !empty(self::getQuestions($room));
    }

    /**
     * @throws ConnException
     */
    private static function getQuestions(ModelRoom $room, bool $force = false): array
    {
        if (!$force && !empty(self::$questions)) {
            return self::$questions;
        }

        $qtGamers = count($room->getGamers());
        $qtQuestions = $qtGamers * (($qtGamers > 3) ? 2 : 3);
        self::$questions = Crud::getAll(Question::class, 0, $qtQuestions, 'RAND()');

        // Se a quantidade não for mínima, zera as perguntas
        if (count(self::$questions) < $qtQuestions) {
            self::$questions = [];
        }

        return self::$questions;
    }

    /**
     * Controle de fases
     *
     * @throws ConnException
     */
    private static function nextFase(ModelRoom $room): array
    {
        if (!self::allowGame($room)) {
            return [];
        }

        switch ($room->fase) {
            // Inicio
            case 0:
                // Seleciona oo personagem secreto e o jogador fora da rodada
                $room->setSecrets();
                $room->fase++;
                Crud::update(ModelRoom::class, $room);

                // TODO: repensar isso, porque o jogo precisa saber quando TODOS os jogadores avançaram a fase
                // criar tabela de views

                return [
                    'room'      => $room,
                    'outOfLoop' => $room->getOutOfTheLoopGamer(),
                    'secret'    => $room->getSecretCharacter(),
                ];

            case 1:
                // Pega as perguntas a serem feitas
                $room->fase++;
                Crud::update(ModelRoom::class, $room);

                // TODO: repensar isso, porque cada jogador receberá uma pergunta para fazer para o próximo

                return [
                    'room'      => $room,
                    'questions' => self::getQuestions($room, true),
                ];

            default:
                // TODO: remover, é apenas para teste
                $room->fase = 0;
                Crud::update(ModelRoom::class, $room);
                return [
                    'room' => $room,
                ];
        }
    }
}