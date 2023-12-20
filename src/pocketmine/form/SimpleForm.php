<?php

declare(strict_types=1);

namespace pocketmine\form;

use pocketmine\BedrockPlayer;
use pocketmine\entity\Attribute;
use pocketmine\network\bedrock\protocol\UpdateAttributesPacket as BedrockUpdateAttributesPacket;
use pocketmine\Player;
use function repeat;

class SimpleForm extends Form{

	public const IMAGE_TYPE_PATH = 0;
	public const IMAGE_TYPE_URL = 1;

	/** @var string */
	private string $content = "";

	private array $labelMap = [];

	/**
	 * @param string   $title = ""
	 */
	public function __construct(string $title){
		parent::__construct($title);
		$this->data["type"] = "form";
		$this->data["content"] = $this->content;
	}

	public function processData(&$data) : void{
		$data = $this->labelMap[$data] ?? null;
	}

	/**
	 * @return string
	 */
	public function getContent() : string{
		return $this->data["content"];
	}

	/**
	 * @param string $content
	 */
	public function setContent(string $content) : void{
		$this->data["content"] = $content;
	}

	/**
	 * @param string $text
	 * @param int $imageType
	 * @param string $imagePath
	 * @param string $label
	 */
	public function addButton(string $text, int $imageType = -1, string $imagePath = "", ?string $label = null) : void{
		$content = ["text" => $text];
		if($imageType !== -1) {
			$content["image"]["type"] = $imageType === 0 ? "path" : "url";
			$content["image"]["data"] = $imagePath;
		}
		$this->data["buttons"][] = $content;
		$this->labelMap[] = $label ?? count($this->labelMap);
	}

	public function sendToPlayer(Player $player) : void{
		parent::sendToPlayer($player);

		if($player instanceof BedrockPlayer){
			// хак для пикч
			//PacketCallback::onPacketSend($player, static function() use ($player) : void{
				$startTick = $player->getServer()->getTick();
				repeat(static function(int $currentTick) use ($startTick, $player) : bool{
					if(!$player->isConnected() or $currentTick - $startTick > 20){
						return false;
					}

					$pk = new BedrockUpdateAttributesPacket();
					$pk->actorRuntimeId = $player->getId();
					$pk->entries = [$player->getAttributeMap()->getAttribute(Attribute::EXPERIENCE_LEVEL)];
					$player->sendDataPacket($pk, false, true);

					return true;
				}, 2);
			}
		}
	}
