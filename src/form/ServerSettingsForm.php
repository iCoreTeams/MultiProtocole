<?php

declare(strict_types=1);

namespace pocketmine\form;

use pocketmine\network\bedrock\protocol\ServerSettingsResponsePacket;
use pocketmine\Player;

class ServerSettingsForm extends CustomForm{

	/**
	 * @param string   $title = ""
	 * @param int      $iconType = -1
	 * @param string   $iconPath = ""
	 */
	public function __construct(string $title = "", int $iconType = -1, string $iconPath = ""){
		if($iconType !== -1){
			$this->data["icon"]["type"] = $iconType === 0 ? "path" : "url";
			$this->data["icon"]["data"] = $iconPath;
		}
		parent::__construct($title);
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
		$pk = new ServerSettingsResponsePacket();
		$pk->formId = $id;
		$pk->formData = json_encode($this->data);
		if($pk->formData === false){
			throw new \InvalidArgumentException("Failed to encode form JSON: " . json_last_error_msg());
		}
		if($player->directDataPacket($pk)){
			$player->forms[$id] = $this;
		}
	}
}