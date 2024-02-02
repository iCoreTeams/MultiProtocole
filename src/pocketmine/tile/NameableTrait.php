<?php

declare(strict_types=1);

namespace pocketmine\tile;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;

/**
 * This trait implements most methods in the {@link Nameable} interface. It should only be used by Tiles.
 */
trait NameableTrait{
    /**
     * @return string
     */
    public function getName() : string{
        return $this->namedtag->getString(Nameable::TAG_CUSTOM_NAME, "Chest");
    }

    /**
     * @return bool
     */
    public function hasName() : bool{
        return $this->namedtag->hasTag(Nameable::TAG_CUSTOM_NAME, StringTag::class);
    }

    /**
     * @param string $str
     */
    public function setName(string $str): void{
        if($str === ""){
            $this->namedtag->removeTag(Nameable::TAG_CUSTOM_NAME);
            return;
        }

        $this->namedtag->setString(Nameable::TAG_CUSTOM_NAME, $str);
    }

    /**
     * @param CompoundTag $nbt
     * @param bool $isBedrock
     * @return void
     */
    public function addAdditionalSpawnData(CompoundTag $nbt, bool $isBedrock): void{
        if($this->hasName()){
            $nbt->setString(Nameable::TAG_CUSTOM_NAME, $this->namedtag->getString(Nameable::TAG_CUSTOM_NAME));
        }
    }

}
