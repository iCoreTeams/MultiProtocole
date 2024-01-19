<?php

declare(strict_types=1);

namespace pocketmine\command\data;

final class CommandParameterEnum extends CommandParameter {

    public function __construct(
        string $name,
        bool $optional,
        public array $enum_values
    ){ parent::__construct($name, CommandParameterType::TYPE_STRING_ENUM, $optional); }

    public function toArray() : array{
        return [
            "name" => $this->name,
            "type" => $this->type,
            "isOptional" => $this->optional,
            "enum_values" => $this->enum_values
        ];
    }
}