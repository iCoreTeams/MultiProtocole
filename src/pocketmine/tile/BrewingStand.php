<?php

declare(strict_types=1);

namespace pocketmine\tile;

use pocketmine\inventory\BrewingInventory;
use pocketmine\inventory\InventoryHolder;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\network\mcpe\protocol\ContainerSetDataPacket;
use pocketmine\Server;

class BrewingStand extends Spawnable implements InventoryHolder, Container, Nameable {
    use NameableTrait {
        addAdditionalSpawnData as addNameSpawnData;
    }
    use ContainerTrait;

	public const MAX_BREW_TIME = 400;
	/** @var BrewingInventory */
	protected $inventory;

	public static array $ingredients = [
		Item::NETHER_WART,
		Item::GLOWSTONE_DUST,
		Item::REDSTONE,
		Item::FERMENTED_SPIDER_EYE,

		Item::MAGMA_CREAM,
		Item::SUGAR,
		Item::GLISTERING_MELON,
		Item::SPIDER_EYE,
		Item::GHAST_TEAR,
		Item::BLAZE_POWDER,
		Item::GOLDEN_CARROT,
		Item::PUFFERFISH,
		Item::RABBIT_FOOT,

		Item::GUNPOWDER,
	];

	/**
	 * BrewingStand constructor.
	 *
	 * @param Level       $level
	 * @param CompoundTag $nbt
	 */
	public function __construct(Level $level, CompoundTag $nbt){
        if(!$nbt->hasTag("CookTime", ShortTag::class)){
            $nbt->setShort("CookTime", 0);
        }
		parent::__construct($level, $nbt);
		$this->inventory = new BrewingInventory($this);
        $this->initItems($nbt);
	}

	/**
	 * @return string
	 */
	public function getDefaultName() : string
    {
        return "Brewing Stand";
    }

	/**
	 * @return BrewingInventory
	 */
	public function getInventory(){
		return $this->inventory;
	}

    public function getSize(): int
    {
        return 5;
    }

	/**
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function checkIngredient(Item $item){
		if(in_array($item->getId(), self::$ingredients)){
            return true;
		}
		return false;
	}

	public function updateSurface(){
		$this->saveNBT();
		$this->onChanged();
	}

	/**
	 * @return bool
	 */
	public function onUpdate(): bool
    {
		if($this->closed === true){
			return false;
		}

		$this->timings->startTiming();

		$ret = false;

		$ingredient = $this->inventory->getIngredient();
		$canBrew = false;

		for($i = 1; $i <= 3; $i++){
			if($this->inventory->getItem($i)->getId() === Item::POTION or
				$this->inventory->getItem($i)->getId() === Item::SPLASH_POTION
			){
				$canBrew = true;
			}
		}

		if($ingredient->getId() !== Item::AIR and $ingredient->getCount() > 0){
			if($canBrew){
				if(!$this->checkIngredient($ingredient)){
					$canBrew = false;
				}
			}

			if($canBrew){
				for($i = 1; $i <= 3; $i++){
					$potion = $this->inventory->getItem($i);
					$recipe = Server::getInstance()->getCraftingManager()->matchBrewingRecipe($ingredient, $potion);
					if($recipe !== null){
						$canBrew = true;
						break;
					}
					$canBrew = false;
				}
			}
		}else{
			$canBrew = false;
		}

		if($canBrew){
            $this->namedtag->setShort("CookTime", $this->namedtag->getShort("CookTime", 0) - 1);
			foreach($this->getInventory()->getViewers() as $player){
				$windowId = $player->getWindowId($this->getInventory());
				if($windowId > 0){
					$pk = new ContainerSetDataPacket();
					$pk->windowId = $windowId;
					$pk->property = 0; //Brew
					$pk->value = $this->namedtag->getShort("CookTime", 0);
					$player->sendDataPacket($pk);
				}
			}

			if($this->namedtag->getShort("CookTime", 0) <= 0){
                $this->namedtag->setShort("CookTime", self::MAX_BREW_TIME);
				for($i = 1; $i <= 3; $i++){
					$potion = $this->inventory->getItem($i);
					$recipe = Server::getInstance()->getCraftingManager()->matchBrewingRecipe($ingredient, $potion);
					if($recipe != null and $potion->getId() !== Item::AIR){
						$this->inventory->setItem($i, $recipe->getResult());
					}
				}

				$ingredient->pop();
				if($ingredient->getCount() <= 0) $ingredient = Item::get(Item::AIR);
				$this->inventory->setIngredient($ingredient);
			}

			$ret = true;
		}else{
            $this->namedtag->setShort("CookTime", self::MAX_BREW_TIME);
			foreach($this->getInventory()->getViewers() as $player){
				$windowId = $player->getWindowId($this->getInventory());
				if($windowId > 0){
					$pk = new ContainerSetDataPacket();
					$pk->windowId = $windowId;
					$pk->property = 0; //Brew
					$pk->value = 0;
					$player->sendDataPacket($pk);
				}
			}
		}
		$this->lastUpdate = microtime(true);

		$this->timings->stopTiming();

		return $ret;
	}

    public function addAdditionalSpawnData(CompoundTag $nbt, bool $isBedrock){
        if($isBedrock) {
            $nbt->setShort("FuelAmount", 20);
            $nbt->setShort("FuelTotal", 20);
        }

        $this->addNameSpawnData($nbt, $isBedrock);
    }
}
