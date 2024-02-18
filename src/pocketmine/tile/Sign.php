<?php

/*
 *
 *                            __  __ _
 *     /\                    |  \/  (_)
 *    /  \   __ _ _   _  __ _| \  / |_ _ __   ___
 *   / /\ \ / _` | | | |/ _` | |\/| | | '_ \ / _ \
 *  / ____ \ (_| | |_| | (_| | |  | | | | | |  __/
 * /_/    \_\__, |\__,_|\__,_|_|  |_|_|_| |_|\___|
 *             | |
 *             |_|
 *
 * This program is private software. No license required.
 * Publication of this program is forbidden and will be punished.
 *
 * @author GreenWix Project
 * @link https://www.greenwix.fun
 *
 *
*/

declare(strict_types=1);

namespace pocketmine\tile;

use InvalidArgumentException;
use pocketmine\BedrockPlayer;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\network\bedrock\utils\BedrockUtils;
use pocketmine\Player;
use pocketmine\utils\Binary;
use pocketmine\utils\TextFormat;

class Sign extends Spawnable{

    public const TAG_TEXT_BLOB = "Text";
    public const TAG_TEXT_LINE = "Text%d"; //sprintf()able
    public const TAG_TEXT_COLOR = "SignTextColor";
    public const TAG_GLOWING_TEXT = "IgnoreLighting";
    public const TAG_PERSIST_FORMATTING = "PersistFormatting"; //TAG_Byte
    /**
     * This tag is set to indicate that MCPE-117835 has been addressed in whatever version this sign was created.
     * @see https://bugs.mojang.com/browse/MCPE-117835
     */
    public const TAG_LEGACY_BUG_RESOLVE = "TextIgnoreLegacyBugResolved";

    public const TAG_FRONT_TEXT = "FrontText"; //TAG_Compound
    public const TAG_BACK_TEXT = "BackText"; //TAG_Compound
    public const TAG_WAXED = "IsWaxed"; //TAG_Byte
    public const TAG_LOCKED_FOR_EDITING_BY = "LockedForEditingBy"; //TAG_Long

	public function __construct(Level $level, CompoundTag $nbt){
		for($i = 1; $i <= 4; ++$i){
			if(!$nbt->hasTag("Text$i")){
				$nbt->setString("Text$i", "");
			}
		}

		parent::__construct($level, $nbt);
	}

	public function saveNBT(): void{
		parent::saveNBT();
		$this->namedtag->removeTag("Creator");
	}

	public function setText($line1 = "", $line2 = "", $line3 = "", $line4 = ""){
		$this->namedtag->setString("Text1", $line1);
		$this->namedtag->setString("Text2", $line2);
		$this->namedtag->setString("Text3", $line3);
		$this->namedtag->setString("Text4", $line4);
		$this->onChanged();
	}

	/**
	 * @param int    $index 0-3
	 * @param string $line
	 */
	public function setLine(int $index, string $line){
		if($index < 0 or $index > 3){
			throw new InvalidArgumentException("Index must be in the range 0-3!");
		}
		$this->namedtag->setString("Text" . ($index + 1), $line);
        $this->onChanged();
	}

	/**
	 * @param int $index 0-3
	 *
	 * @return string
	 */
	public function getLine(int $index) : string{
		if($index < 0 or $index > 3){
			throw new InvalidArgumentException("Index must be in the range 0-3!");
		}
		return $this->namedtag->getString("Text" . ($index + 1));
	}

	public function getText(){
        $text = [];
        if($this->namedtag->getString("Text4") !== ""){
            return [
                $this->namedtag->getString("Text1"),
                $this->namedtag->getString("Text2"),
                $this->namedtag->getString("Text3"),
                $this->namedtag->getString("Text4")
            ];
        }

        if($this->namedtag->getString("Text3") !== ""){
            return [
                $this->namedtag->getString("Text1"),
                $this->namedtag->getString("Text2"),
                $this->namedtag->getString("Text3")
            ];
        }

        if($this->namedtag->getString("Text2") !== ""){
            return [
                $this->namedtag->getString("Text1"),
                $this->namedtag->getString("Text2")
            ];
        }

        if($this->namedtag->getString("Text1") !== ""){
            return [
                $this->namedtag->getString("Text1"),
            ];
        }

		return $text;
	}

	public function addAdditionalSpawnData(CompoundTag $nbt, bool $isBedrock){
		if($isBedrock){
			$nbt->setString("Text", BedrockUtils::convertSignLinesToText($this->getText()));

            /*
             * new bedrock sign :(
             */
            $nbt->setTag(self::TAG_FRONT_TEXT, CompoundTag::create()
                ->setString(self::TAG_TEXT_BLOB, BedrockUtils::convertSignLinesToText($this->getText()))
                ->setInt(self::TAG_TEXT_COLOR, Binary::signInt(0xff_00_00_00))
                ->setByte(self::TAG_GLOWING_TEXT, 0)
                ->setByte(self::TAG_PERSIST_FORMATTING, 1) //TODO: not sure what this is used for
            );
            //TODO: this is not yet used by the server, but needed to rollback any client-side changes to the back text
            $nbt->setTag(self::TAG_BACK_TEXT, CompoundTag::create()
                ->setString(self::TAG_TEXT_BLOB, "")
                ->setInt(self::TAG_TEXT_COLOR, Binary::signInt(0xff_00_00_00))
                ->setByte(self::TAG_GLOWING_TEXT, 0)
                ->setByte(self::TAG_PERSIST_FORMATTING, 1)
            );
            $nbt->setByte(self::TAG_WAXED, 0);
            $nbt->setLong(self::TAG_LOCKED_FOR_EDITING_BY, $this->editorEntityRuntimeId ?? -1);
		}else{
			for($i = 1; $i <= 4; $i++){
				$textKey = "Text$i";
				$nbt->setString($textKey, $this->namedtag->getString($textKey));
			}
		}
		return $nbt;
	}

	public function updateCompoundTag(CompoundTag $nbt, Player $player) : bool{
		if($nbt->getString("id") !== Tile::SIGN){
			return false;
		}

		$removeFormat = $player->getRemoveFormat();
		if($player instanceof BedrockPlayer){
            if($nbt->hasTag("Text", StringTag::class)) {
                $lines = BedrockUtils::convertSignTextToLines(TextFormat::clean($nbt->getString("Text"), $removeFormat));
            }else{
                $frontTextTag = $nbt->getTag(Sign::TAG_FRONT_TEXT);
                $textBlobTag = $frontTextTag->getTag(Sign::TAG_TEXT_BLOB);
                $lines = BedrockUtils::convertSignTextToLines($textBlobTag->getValue());
            }
		}else{
			$lines = [
				TextFormat::clean($nbt->getString("Text1"), $removeFormat),
				TextFormat::clean($nbt->getString("Text2"), $removeFormat),
				TextFormat::clean($nbt->getString("Text3"), $removeFormat),
				TextFormat::clean($nbt->getString("Text4"), $removeFormat)
			];
		}
		$ev = new SignChangeEvent($this->getBlock(), $player, $lines);

		if($this->namedtag->getString("Creator", "") !== $player->getRawUniqueId()){
			$ev->setCancelled();
		}

		$ev->call();

		if(!$ev->isCancelled()){
			$this->setText(...$ev->getLines());
			return true;
		}else{
			return false;
		}
	}

}
