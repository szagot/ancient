<?php

namespace Ancient\Models;

use Szagot\Conn\aModel;

class Config extends aModel
{
    const TABLE = 'config';
    public string  $field;
    public ?string $value;
}