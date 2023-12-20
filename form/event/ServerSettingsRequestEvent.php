<?php

declare(strict_types=1);

namespace pocketmine\form\event;

use pocketmine\form\Form;
use pocketmine\event\Event;
use pocketmine\Player;

class ServerSettingsRequestEvent extends Event{
	public static $handlerList = null;

	/** @var Player */
	protected $player;
	/** @var Form */
	protected $form;

	public function __construct(Player $player){
		$this->player = $player;
	}

	public function getPlayer() : Player{
		return $this->player;
	}

	public function setForm(?Form $form) : void{
		$this->form = $form;
	}

	public function getForm() : ?Form{
		return $this->form;
	}
}