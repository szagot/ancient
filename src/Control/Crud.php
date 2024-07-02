<?php

namespace Ancient\Control;

use Sz\Conn\Query;

class Crud
{
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

    static public function getAll(string $class): array
    {
        if (!$table = $class::TABLE ?? null) {
            return [];
        }
        return Query::exec("SELECT * FROM $table", null, $class) ?? [];
    }

    static public function search(string $class, string $searchField, mixed $value): array
    {
        if (!$table = $class::TABLE ?? null) {
            return [];
        }

        return Query::exec(
            "SELECT * FROM $table WHERE $searchField = :value",
            [
                'value' => $value,
            ],
            $class
        ) ?? [];
    }

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
}