<?php

namespace Ancient\Control;

use Ancient\Exception\AncientException;
use Sz\Conn\Query;

class Crud
{
    /**
     * Pega um registro específico pelo identificados
     *
     * @param string $class   Classe relacionada a pesquisa. Ela deve possuir uma const TABLE com o nome da tabela.
     * @param string $idField Nome do campo identificador
     * @param mixed  $value   Valor do identificador
     *
     * @return mixed
     * @throws AncientException
     */
    static public function get(string $class, string $idField, mixed $value): mixed
    {
        $table = self::getTable($class);

        return Query::exec(
            "SELECT * FROM {$table} WHERE $idField = :value",
            [
                'value' => $value,
            ],
            $class
        )[0] ?? null;
    }

    /**
     * Pega todos os registros
     *
     * @param string $class Classe relacionada a pesquisa. Ela deve possuir uma const TABLE com o nome da tabela.
     *
     * @return array
     * @throws AncientException
     */
    static public function getAll(string $class): array
    {
        $table = self::getTable($class);

        return Query::exec("SELECT * FROM $table", null, $class) ?? [];
    }

    /**
     * Pesquisa pelo termo
     *
     * @param string $class       Classe relacionada a pesquisa. Ela deve possuir uma const TABLE com o nome da tabela.
     * @param string $searchField Nome do campo a ser pesquisado
     * @param mixed  $value       Valor da pesquisa. Use % como coringa
     *
     * @return array
     * @throws AncientException
     */
    static public function search(string $class, string $searchField, mixed $value): array
    {
        $table = self::getTable($class);

        return Query::exec(
            "SELECT * FROM $table WHERE $searchField LIKE :value",
            [
                'value' => $value,
            ],
            $class
        ) ?? [];
    }

    /**
     * Insere um registro
     *
     * @param string $class    Classe relacionada a pesquisa. Ela deve possuir uma const TABLE com o nome da tabela.
     * @param string $idField  Nome do campo identificador
     * @param mixed  $instance Objeto a ser adicionado
     *
     * @return int|null
     * @throws AncientException
     */
    static public function insert(string $class, string $idField, mixed $instance): ?int
    {
        $table = self::getTable($class);

        unset($instance->$idField);
        $instanceVars = get_object_vars($instance);
        $fieldsValues = ':' . implode(', :', array_keys($instanceVars));
        $fields = implode(', ', array_keys($instanceVars));

        $insert = Query::exec("INSERT INTO $table ($fields) VALUES ($fieldsValues)", $instanceVars, $class) ?? [];
        if (!$insert) {
            throw new AncientException('Não foi possível inserir o registro no momento.');
        }

        return Query::getLog(true)['lastId'] ?? null;
    }

    /**
     * Atualiza um registro
     *
     * @param string $class    Classe relacionada a pesquisa. Ela deve possuir uma const TABLE com o nome da tabela.
     * @param string $idField  Nome do campo identificador
     * @param mixed  $instance Objeto a ser alterado
     *
     * @return void
     * @throws AncientException
     */
    static public function update(string $class, string $idField, mixed $instance): void
    {
        $table = self::getTable($class);

        $instanceVars = get_object_vars($instance);
        $fields = [];
        foreach ($instanceVars as $key => $value) {
            if ($key == $idField) {
                continue;
            }
            $fields[] = "$key = :$key";
        }
        $fieldsValues = implode(', ', $fields);

        $update = Query::exec(
            "UPDATE $table SET $fieldsValues WHERE {$idField} = :{$idField}",
            $instanceVars,
            $class
        ) ?? [];
        if (!$update) {
            throw new AncientException("Não foi possível atualizar o registro de ID {$instance->$idField} no momento.");
        }
    }

    /**
     * Apaga um registro
     *
     * @param string $class   Classe relacionada a pesquisa. Ela deve possuir uma const TABLE com o nome da tabela.
     * @param string $idField Nome do campo identificador
     * @param mixed  $value   Valor do identificador a ser deletado
     *
     * @return void
     * @throws AncientException
     */
    static public function delete(string $class, string $idField, mixed $value): void
    {
        $table = self::getTable($class);

        $delete = Query::exec(
            "DELETE FROM $table WHERE {$idField} = :{$idField}",
            [
                $idField => $value,
            ],
            $class
        ) ?? [];

        if (!$delete) {
            throw new AncientException("Não foi possível deletar o registro de ID {$value} no momento.");
        }
    }

    /**
     * Devolve o valor declarado de TABLE
     *
     * @throws AncientException
     */
    private static function getTable(string $class): ?string
    {
        if (!defined($class . '::TABLE')) {
            throw new AncientException('Tabela não declarada', false);
        }

        return $class::TABLE;
    }
}