<?php

declare(strict_types=1);

namespace pocketmine\command\data;

class CommandParameter {

    public function __construct(
        public string $name,
        public string $type,
        public bool $optional
    ) {}

    public function toArray() : array{
        return [
            "name" => $this->name,
            "type" => $this->type,
            "isOptional" => $this->optional
        ];
    }

    public function getName() : string{
        return $this->name;
    }

    public function getType() : string{
        return $this->type;
    }
}