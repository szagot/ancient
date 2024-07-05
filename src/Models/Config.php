<?php

namespace Ancient\Models;

use Szagot\Helper\Conn\aModel;

class Config extends aModel
{
    const TABLE = 'config';
    public string  $field;
    public ?string $value;
}