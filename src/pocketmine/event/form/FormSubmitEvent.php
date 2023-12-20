<?php

declare(strict_types=1);

namespace pocketmine\event\form;

use pocketmine\form\Form;
use pocketmine\event\Event;
use pocketmine\Player;

class FormSubmitEvent extends Event{
	public static $handlerList = null;

	/** @var Player */
	protected $player;
	/** @var Form */
	protected $form;
	/** @var mixed */
	protected $data;

	public function __construct(Player $player, Form $form, $data){
		$this->player = $player;
		$this->form = $form;
		$this->data = $data;
	}

	public function getPlayer() : Player{
		return $this->player;
	}

	public function getForm() : Form{
		return $this->form;
	}

	public function getData(){
		return $this->data;
	}
}