<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\event\block\SignChangeEvent;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use pocketmine\tile\Sign;
use pocketmine\tile\Tile;
use function floor;

class SignPost extends Transparent{

    protected ?int $editorEntityRuntimeId = null;

	protected $id = self::SIGN_POST;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness(){
		return 1;
	}

	public function isSolid(){
		return false;
	}

	public function getName(){
		return "Sign Post";
	}

	protected function recalculateBoundingBox(){
		return null;
	}

    public function setEditorEntityRuntimeId(?int $editorEntityRuntimeId) : self{
        $this->editorEntityRuntimeId = $editorEntityRuntimeId;
        return $this;
    }

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
        if($player !== null){
            $this->editorEntityRuntimeId = $player->getId();
        }
		if($face !== 0){
			$nbt = CompoundTag::create()
				->setString("id", Tile::SIGN)
				->setInt("x", $block->x)
				->setInt("y", $block->y)
				->setInt("z", $block->z)
				->setString("Text1", "")
				->setString("Text2", "")
				->setString("Text3", "")
				->setString("Text4", "");

			if($player !== null){
				$nbt->setString("Creator", $player->getRawUniqueId());
			}

			if($item->hasCustomBlockData()){
				foreach($item->getCustomBlockData() as $key => $v){
					$nbt->{$key} = $v;
				}
			}

			if($face === 1){
				$this->meta = floor((($player->yaw + 180) * 16 / 360) + 0.5) & 0x0f;
				$this->getLevel()->setBlock($block, $this, true);
			}else{
				$this->meta = $face;
				$this->getLevel()->setBlock($block, new WallSign($this->meta), true);
			}

			Tile::createTile(Tile::SIGN, $this->getLevel(), $nbt);

			return true;
		}

		return false;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if($this->getSide(Vector3::SIDE_DOWN)->getId() === self::AIR){
				$this->getLevel()->useBreakOn($this);

				return Level::BLOCK_UPDATE_NORMAL;
			}
		}

		return false;
	}

	public function getDrops(Item $item){
		return [
			[Item::SIGN, 0, 1],
		];
	}

	public function getToolType(){
		return Tool::TYPE_AXE;
	}

    /**
     * Called by the player controller (network session) to update the sign text, firing events as appropriate.
     *
     * @return bool if the sign update was successful.
     * @throws \UnexpectedValueException if the text payload is too large
     */
    public function updateText(Player $author, array $text) : bool{
        $size = 0;
        foreach($text as $line){
            $size += strlen($line);
        }
        if($size > 1000){
            throw new \UnexpectedValueException($author->getName() . " tried to write $size bytes of text onto a sign (bigger than max 1000)");
        }
        $ev = new SignChangeEvent($this, $author, $text);
        if($this->editorEntityRuntimeId === null || $this->editorEntityRuntimeId !== $author->getId()){
            $ev->setCancelled();
        }
        $ev->call();
        if(!$ev->isCancelled()){
            if(($tile = $this->getLevel()->getTile($this)) instanceof Sign){
                $tile->setText($text[0], $text[1], $text[2], $text[3]);
            }
            $this->setEditorEntityRuntimeId(null);
            $this->getLevel()->setBlock($this, $this);
            return true;
        }

        return false;
    }
}