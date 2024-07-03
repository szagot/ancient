<?php

namespace Ancient\Control;

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
     */
    static public function get(string $class, string $idField, mixed $value): mixed
    {
        if (!$table = $class::TABLE ?? null) {
            return null;
        }

        return Query::exec(
            "SELECT * FROM $table WHERE $idField = :value",
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
     */
    static public function getAll(string $class): array
    {
        if (!$table = $class::TABLE ?? null) {
            return [];
        }
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
     */
    static public function search(string $class, string $searchField, mixed $value): array
    {
        if (!$table = $class::TABLE ?? null) {
            return [];
        }

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
     */
    static public function insert(string $class, string $idField, mixed $instance): ?int
    {
        if (!$table = $class::TABLE ?? null) {
            return null;
        }

        unset($instance->$idField);
        $instanceVars = get_object_vars($instance);
        $fieldsValues = ':' . implode(', :', array_keys($instanceVars));
        $fields = implode(', ', array_keys($instanceVars));

        $insert = Query::exec("INSERT INTO $table ($fields) VALUES ($fieldsValues)", $instanceVars, $class) ?? [];
        if (!$insert) {
            error_log(print_r(Query::getLog(), true));
            return null;
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
     * @return bool
     */
    static public function update(string $class, string $idField, mixed $instance): bool
    {
        if (!$table = $class::TABLE ?? null) {
            return false;
        }

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
            error_log(print_r(Query::getLog(), true));
            return false;
        }

        return true;
    }

    /**
     * Apaga um registro
     *
     * @param string $class   Classe relacionada a pesquisa. Ela deve possuir uma const TABLE com o nome da tabela.
     * @param string $idField Nome do campo identificador
     * @param mixed  $value   Valor do identificador a ser deletado
     *
     * @return bool
     */
    static public function delete(string $class, string $idField, mixed $value): bool
    {
        if (!$table = $class::TABLE ?? null) {
            return false;
        }

        $delete = Query::exec(
            "DELETE FROM $table WHERE {$idField} = :{$idField}",
            [
                $idField => $value,
            ],
            $class
        ) ?? [];

        if (!$delete) {
            error_log(print_r(Query::getLog(), true));
            return false;
        }

        return true;
    }
}