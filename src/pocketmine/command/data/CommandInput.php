<?php

declare(strict_types=1);

namespace pocketmine\command\data;

final class CommandInput {

    public array $parameters = [];

    public function addParameter(CommandParameter $parameter) : void{
        $this->parameters[] = $parameter;
    }
}