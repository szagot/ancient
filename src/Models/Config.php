<?php

namespace Ancient\Models;

use Szagot\Helper\Attributes\PrimaryKey;
use Szagot\Helper\Attributes\Table;
use Szagot\Helper\Conn\Model\aModel;

#[Table(name: 'config')]
class Config extends aModel
{
    #[PrimaryKey(autoIncrement: false)]
    private string  $field;
    private ?string $value;

    public function getField(): string
    {
        return $this->field;
    }

    public function setField(string $field): Config
    {
        $this->field = $field;
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): Config
    {
        $this->value = $value;
        return $this;
    }
}