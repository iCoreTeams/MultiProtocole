<?php

declare(strict_types=1);

namespace pocketmine\form;

use pocketmine\form\event\FormSubmitEvent;
use pocketmine\network\bedrock\protocol\ModalFormRequestPacket;
use pocketmine\Player;

abstract class Form{

	/** @var array */
	protected $data = [];

	/**
	 * @param string   $title = ""
	 */
	public function __construct(string $title = ""){
		$this->data["title"] = $title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle(string $title) : void{
		$this->data["title"] = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle() : string{
		return $this->data["title"];
	}

	/**
	 * @param Player $player
	 */
	public function sendToPlayer(Player $player) : void{
		if(!$player->isBedrock()){
			return;
		}
		if(!isset($player->formIdCounter)){
			$player->formIdCounter = 0;
			$player->forms = [];
		}
		$id = $player->formIdCounter++;
		$pk = new ModalFormRequestPacket();
		$pk->formId = $id;
		$pk->formData = json_encode($this->data);
		if($pk->formData === false){
			throw new \InvalidArgumentException("Failed to encode form JSON: " . json_last_error_msg());
		}
		if($player->dataPacket($pk)){
			$player->forms[$id] = $this;
		}
	}

	public function handleResponse(Player $player, $data) : void{
		$this->processData($data);
		\server()->getPluginManager()->callEvent(new FormSubmitEvent($player, $this, $data));
	}

	public function processData(&$data) : void{
	}
}
