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

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\Player;

class Rail extends Flowable{

    public const STRAIGHT_EAST_WEST = 0;
    public const STRAIGHT_NORTH_SOUTH = 1;
    public const SLOPED_ASCENDING_NORTH = 2;
    public const SLOPED_ASCENDING_SOUTH = 3;
    public const SLOPED_ASCENDING_EAST = 4;
    public const SLOPED_ASCENDING_WEST = 5;
    public const CURVED_SOUTH_WEST = 6;
    public const CURVED_NORTH_WEST = 7;
    public const CURVED_NORTH_EAST = 8;
    public const CURVED_SOUTH_EAST = 9;

	protected $id = self::RAIL;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName(){
		return "Rail";
	}

    protected function update(){
        return true;
    }

    /**
     * @param Rail $block
     *
     * @return bool
     */
    public function canConnect(Rail $block){
        if($this->distanceSquared($block) > 2){
            return false;
        }
        /** @var Vector3 [] $blocks */
        if(count($blocks = self::check($this)) == 2){
            return false;
        }
        return $blocks;
    }

    /**
     * @param Block $block
     *
     * @return bool|Block
     */
    public function isBlock(Block $block){
        if($block instanceof Air){
            return false;
        }
        return $block;
    }

    /**
     * @param Rail $rail
     * @param bool $force
     *
     * @return bool
     */
    public function connect(Rail $rail, $force = false){

        if(!$force){
            $connected = $this->canConnect($rail);
            if(!is_array($connected)){
                return false;
            }
            /** @var Vector3 [] $connected */
            $connected[] = $rail;
            switch(count($connected)){
                case  1:
                    $v3 = $connected[0]->subtract($this->x, $this->y, $this->z);
                    $this->meta = (($v3->y != 1) ? ($v3->x == 0 ? 0 : 1) : ($v3->z == 0 ? ($v3->x / -2) + 2.5 : ($v3->z / 2) + 4.5));
                    break;
                case 2:
                    $subtract = [];
                    foreach($connected as $key => $value){
                        $subtract[$key] = $value->subtract($this->x, $this->y, $this->z);
                    }
                    if(abs($subtract[0]->x) == abs($subtract[1]->z) and abs($subtract[1]->x) == abs($subtract[0]->z)){

                        $v3 = $connected[0]->subtract($this->x, $this->y, $this->z);
                        $vector = $connected[1]->subtract($this->x, $this->y, $this->z);
                        $v3 = $v3->add($vector->x, $vector->y, $vector->z);
                        $this->meta = $v3->x == 1 ? ($v3->z == 1 ? 6 : 9) : ($v3->z == 1 ? 7 : 8);
                    }elseif($subtract[0]->y == 1 or $subtract[1]->y == 1){
                        $v3 = $subtract[0]->y == 1 ? $subtract[0] : $subtract[1];
                        $this->meta = $v3->x == 0 ? ($v3->z == -1 ? 4 : 5) : ($v3->x == 1 ? 2 : 3);
                    }else{
                        $this->meta = $subtract[0]->x == 0 ? 0 : 1;
                    }
                    break;
                default:
                    break;
            }
        }
        $this->level->setBlock($this, Block::get($this->id, $this->meta), true, true);
        return true;
    }

    public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null):bool{
        $downBlock = $this->getSide(Vector3::SIDE_DOWN);

        if($downBlock instanceof Rail or !$this->isBlock($downBlock)){//判断是否可以放置
            return false;
        }

        $arrayXZ = [[1, 0], [0, 1], [-1, 0], [0, -1]];
        $arrayY = [0, 1, -1];

        /** @var Vector3 [] $connected */
        $connected = [];
        foreach($arrayXZ as $xz){
            $x = $xz[0];
            $z = $xz[1];
            foreach($arrayY as $y){
                $v3 = (new Vector3($x, $y, $z))->add($this->x, $this->y, $this->z);
                $block = $this->level->getBlock($v3);
                if($block instanceof Rail){
                    if($block->connect($this)){
                        $connected[] = $v3;
                        break;
                    }
                }
            }
            if(count($connected) == 2){
                break;
            }
        }
        switch(count($connected)){
            case  1:
                $v3 = $connected[0]->subtract($this->x, $this->y, $this->z);
                $this->meta = (($v3->y != 1) ? ($v3->x == 0 ? 0 : 1) : ($v3->z == 0 ? ($v3->x / -2) + 2.5 : ($v3->z / 2) + 4.5));
                break;
            case 2:
                $subtract = [];
                foreach($connected as $key => $value){
                    $subtract[$key] = $value->subtract($this->x, $this->y, $this->z);
                }
                if(abs($subtract[0]->x) == abs($subtract[1]->z) and abs($subtract[1]->x) == abs($subtract[0]->z)){

                    $v3 = $connected[0]->subtract($this->x, $this->y, $this->z);
                    $vector = $connected[1]->subtract($this->x, $this->y, $this->z);
                    $v3 = $v3->add($vector->x, $vector->y, $vector->z);
                    $this->meta = $v3->x == 1 ? ($v3->z == 1 ? 6 : 9) : ($v3->z == 1 ? 7 : 8);
                }elseif($subtract[0]->y == 1 or $subtract[1]->y == 1){
                    $v3 = $subtract[0]->y == 1 ? $subtract[0] : $subtract[1];
                    $this->meta = $v3->x == 0 ? ($v3->z == -1 ? 4 : 5) : ($v3->x == 1 ? 2 : 3);
                }else{
                    $this->meta = $subtract[0]->x == 0 ? 0 : 1;
                }
                break;
            default:
                break;
        }
        $this->level->setBlock($this, Block::get($this->id, $this->meta), true, true);
        return true;
    }

    /**
     * @param Rail $rail
     *
     * @return array
     */
    public static function check(Rail $rail){
        $array = [
            [[0, 1], [0, -1]],
            [[1, 0], [-1, 0]],
            [[1, 0], [-1, 0]],
            [[1, 0], [-1, 0]],
            [[0, 1], [0, -1]],
            [[0, 1], [0, -1]],
            [[1, 0], [0, 1]],
            [[0, 1], [-1, 0]],
            [[-1, 0], [0, -1]],
            [[0, -1], [1, 0]]
        ];
        $arrayY = [0, 1, -1];
        $blocks = $array[$rail->getDamage()];
        $connected = [];
        foreach($arrayY as $y){
            $v3 = new Vector3($rail->x + $blocks[0][0], $rail->y + $y, $rail->z + $blocks[0][1]);
            $id = $rail->getLevel()->getBlockIdAt($v3->x, $v3->y, $v3->z);
            $meta = $rail->getLevel()->getBlockDataAt($v3->x, $v3->y, $v3->z);
            if(in_array($id, [self::RAIL, self::ACTIVATOR_RAIL, self::DETECTOR_RAIL, self::POWERED_RAIL]) and in_array([$rail->x - $v3->x, $rail->z - $v3->z], $array[$meta])){
                $connected[] = $v3;
                break;
            }
        }
        foreach($arrayY as $y){
            $v3 = new Vector3($rail->x + $blocks[1][0], $rail->y + $y, $rail->z + $blocks[1][1]);
            $id = $rail->getLevel()->getBlockIdAt($v3->x, $v3->y, $v3->z);
            $meta = $rail->getLevel()->getBlockDataAt($v3->x, $v3->y, $v3->z);
            if(in_array($id, [self::RAIL, self::ACTIVATOR_RAIL, self::DETECTOR_RAIL, self::POWERED_RAIL]) and in_array([$rail->x - $v3->x, $rail->z - $v3->z], $array[$meta])){
                $connected[] = $v3;
                break;
            }
        }
        return $connected;
    }

    public function onUpdate($type){
        if($type === Level::BLOCK_UPDATE_NORMAL){
            if($this->getSide(Vector3::SIDE_DOWN)->isTransparent()){
                $this->getLevel()->useBreakOn($this);

                return Level::BLOCK_UPDATE_NORMAL;
            }
        }

        return false;
    }

    /**
     * @return float
     */
    public function getHardness():float{
        return 0.7;
    }

    /**
     * @return float
     */
    public function getResistance():float{
        return 3.5;
    }

    /**
     * @return bool
     */
    public function canPassThrough():bool{
        return true;
    }
}
