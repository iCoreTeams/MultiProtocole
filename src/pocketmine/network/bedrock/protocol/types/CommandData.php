<?php

declare(strict_types=1);

namespace pocketmine\network\bedrock\protocol\types;

class CommandData{

	public $commandName;
	public $commandDescription;
	public $flags;
	public $permission;
	public $aliases;
	public array $overloads = [];

}
