<?php

namespace Ancient\Service;

use Ancient\Config\Output;
use Ancient\Control\ViewControl;
use Ancient\Models\Gamer;
use Ancient\Models\Question;
use Ancient\Models\Room as ModelRoom;
use Szagot\Helper\Conn\ConnException;
use Szagot\Helper\Conn\Crud;
use Szagot\Helper\Conn\Query;
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
            if ($room?->getCode() != $code) {
                Output::error('Código da sala inválido', Output::ERROR_NOT_FOUND);
            }

            // ID do Jogador
            $gamerId = $uri->getUri(2);
            if (empty($gamerId)) {
                Output::error('Informe o ID do Jogador');
            }

            /** @var Gamer $gamer */
            $gamer = Crud::get(Gamer::class, $gamerId);
            if (!$gamer || $gamer->getRoomCode() != $room->getCode()) {
                Output::error('Jogador não localizado na sala', Output::ERROR_NOT_FOUND);
            }

            switch ($uri->getMethod()) {
                case 'GET':
                    switch ($uri->getUri(3)) {
                        // Permite o início do Jogo?
                        case 'allow':
                            Output::success(
                                [
                                    'code'  => $code,
                                    'allow' => self::allowGame($room),
                                ]
                            );
                        default:
                            Output::success($gamer->toArray());
                    }

                case 'POST':
                    // TODO: teste
                    $view = ViewControl::insert($code, $gamerId);
                    $view->getRoom();
                    $view->getGamer();
                    Output::success($view->toArray(true));
                    Output::success(self::nextFase($room), Output::POST_SUCCESS);
            }

        } catch (ConnException $e) {
            error_log('-------------');
            error_log(print_r(Query::getLastLog(), true));
            error_log('-------------');
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

        switch ($room->getFase()) {
            // Inicio
            case 0:
                // Seleciona oo personagem secreto e o jogador fora da rodada
                Crud::update(ModelRoom::class, $room->setSecrets()->increaseFase());

                // TODO: repensar isso, porque o jogo precisa saber quando TODOS os jogadores avançaram a fase
                // criar tabela de views

                $room->getOutOfTheLoopGamer();
                $room->getSecretCharacter();
                return [
                    'room' => $room->toArray(true),
                ];

            case 1:
                // Pega as perguntas a serem feitas
                Crud::update(ModelRoom::class, $room->increaseFase());

                // TODO: repensar isso, porque cada jogador receberá uma pergunta para fazer para o próximo

                $questions = self::getQuestions($room, true);
                /** @var Question $question */
                foreach ($questions as $index => $question) {
                    $questions[$index] = $question->toArray();
                }

                return [
                    'room'      => $room,
                    'questions' => $questions,
                ];

            default:
                // TODO: remover, é apenas para teste
                Crud::update(ModelRoom::class, $room->setFase(0));
                $room->getOutOfTheLoopGamer();
                $room->getSecretCharacter();
                return [
                    'room' => $room->toArray(true),
                ];
        }
    }
}