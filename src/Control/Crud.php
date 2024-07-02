<?php

namespace Ancient\Control;

use Sz\Conn\Query;

class Crud
{
    static public function get(string $class, string $idField, mixed $value): mixed
    {
        $table = $class::TABLE;
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
        $table = $class::TABLE;
        return Query::exec("SELECT * FROM $table", null, $class) ?? [];
    }

}