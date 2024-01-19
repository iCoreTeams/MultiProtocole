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

namespace pocketmine\network\bedrock\protocol\types;

class CommandEnumConstraint{
	/** @var CommandEnum */
	private $enum;
	/** @var int */
	private $valueOffset;
	/** @var int[] */
	private $constraints; //TODO: find constants

	/**
	 * @param CommandEnum $enum
	 * @param int         $valueOffset
	 * @param int[]       $constraints
	 */
	public function __construct(CommandEnum $enum, int $valueOffset, array $constraints){
		(static function(int ...$_){})(...$constraints);
		if(!isset($enum->enumValues[$valueOffset])){
			throw new \InvalidArgumentException("Invalid enum value offset $valueOffset");
		}
		$this->enum = $enum;
		$this->valueOffset = $valueOffset;
		$this->constraints = $constraints;
	}

	public function getEnum() : CommandEnum{
		return $this->enum;
	}

	public function getValueOffset() : int{
		return $this->valueOffset;
	}

	public function getAffectedValue() : string{
		return $this->enum->enumValues[$this->valueOffset];
	}

	/**
	 * @return int[]
	 */
	public function getConstraints() : array{
		return $this->constraints;
	}
}