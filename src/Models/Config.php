<?php

namespace Ancient\Models;

use Szagot\Helper\Attributes\PrimaryKey;
use Szagot\Helper\Attributes\Table;
use Szagot\Helper\Conn\Model\aModel;

#[Table(name: 'config')]
class Config extends aModel
{
    #[PrimaryKey(autoIncrement: false)]
    public string  $field;
    public ?string $value;
}