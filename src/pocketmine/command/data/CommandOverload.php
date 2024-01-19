<?php

declare(strict_types=1);

namespace pocketmine\command\data;

final class CommandOverload {

    public CommandInput $input;
    public CommandOutput $output;

    public function __construct() {
        $this->input = new CommandInput();
        $this->output = new CommandOutput();
    }

    public function getInput() : CommandInput{
        return $this->input;
    }

    public function getOutput() : CommandOutput{
        return $this->output;
    }
}