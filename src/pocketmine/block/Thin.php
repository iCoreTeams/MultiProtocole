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

use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;

abstract class Thin extends Transparent{

	public function isSolid(){
		return false;
	}

    protected function recalculateBoundingBox(){
        $width = 0.5 - 0.125 / 2;

        return new AxisAlignedBB(
            $this->x + ($this->canConnect($this->getSide(Vector3::SIDE_WEST)) ? 0 : $width),
            $this->y,
            $this->z + ($this->canConnect($this->getSide(Vector3::SIDE_NORTH)) ? 0 : $width),
            $this->x + 1 - ($this->canConnect($this->getSide(Vector3::SIDE_EAST)) ? 0 : $width),
            $this->y + 1,
            $this->z + 1 - ($this->canConnect($this->getSide(Vector3::SIDE_SOUTH)) ? 0 : $width)
        );
    }

    protected function recalculateCollisionBoxes() : array{
        $inset = 0.5 - 0.125 / 2;

        /** @var AxisAlignedBB[] $bbs */
        $bbs = [];

        $connectWest = $this->canConnect($this->getSide(Vector3::SIDE_WEST));
        $connectEast = $this->canConnect($this->getSide(Vector3::SIDE_EAST));

        if($connectWest or $connectEast){
            //X axis (west/east)
            $bbs[] = new AxisAlignedBB(
                $this->x + ($connectWest ? 0 : $inset),
                $this->y,
                $this->z + $inset,
                $this->x + 1 - ($connectEast ? 0 : $inset),
                $this->y + 1,
                $this->z + 1 - $inset
            );
        }

        $connectNorth = $this->canConnect($this->getSide(Vector3::SIDE_NORTH));
        $connectSouth = $this->canConnect($this->getSide(Vector3::SIDE_SOUTH));

        if($connectNorth or $connectSouth){
            //Z axis (north/south)
            $bbs[] = new AxisAlignedBB(
                $this->x + $inset,
                $this->y,
                $this->z + ($connectNorth ? 0 : $inset),
                $this->x + 1 - $inset,
                $this->y + 1,
                $this->z + 1 - ($connectSouth ? 0 : $inset)
            );
        }

        if(count($bbs) === 0){
            //centre post AABB (only needed if not connected on any axis - other BBs overlapping will do this if any connections are made)
            return [
                new AxisAlignedBB(
                    $this->x + $inset,
                    $this->y,
                    $this->z + $inset,
                    $this->x + 1 - $inset,
                    $this->y + 1,
                    $this->z + 1 - $inset
                )
            ];
        }

        return $bbs;
    }

    public function canConnect(Block $block){
        if($block instanceof Thin){
            return true;
        }

        //FIXME: currently there's no proper way to tell if a block is a full-block, so we check the bounding box size
        $bb = $block->getBoundingBox();
        return $bb !== null and $bb->getAverageEdgeLength() >= 1;
    }

}