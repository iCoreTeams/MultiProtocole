<?php

declare(strict_types=1);

namespace pocketmine\plugin;

use pocketmine\event\Event;
use pocketmine\event\Listener;

class MethodEventExecutor implements EventExecutor{

	public function __construct(
        private string $method
    ){}

	public function execute(Listener $listener, Event $event): void{
		$listener->{$this->getMethod()}($event);
	}

	public function getMethod(): string{
		return $this->method;
	}
}