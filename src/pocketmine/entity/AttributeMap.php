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

namespace pocketmine\entity;

use function array_filter;

class AttributeMap implements \ArrayAccess{
	/** @var Attribute[] */
	private $attributes = [];

	public function addAttribute(Attribute $attribute){
		$this->attributes[$attribute->getId()] = $attribute;
	}

	/**
	 * @param int $id
	 *
	 * @return Attribute|null
	 */
	public function getAttribute(int $id){
		return $this->attributes[$id] ?? null;
	}

	/**
	 * @return Attribute[]
	 */
	public function getAll() : array{
		return $this->attributes;
	}

	/**
	 * @return Attribute[]
	 */
	public function needSend() : array{
		return array_filter($this->attributes, function(Attribute $attribute){
			return $attribute->isSyncable() and $attribute->isDesynchronized();
		});
	}

	public function offsetExists(mixed $offset) : bool{
		return isset($this->attributes[$offset]);
	}

	public function offsetGet(mixed $offset) : mixed{
		return $this->attributes[$offset]->getValue();
	}

	public function offsetSet(mixed $offset, mixed $value) : void{
		$this->attributes[$offset]->setValue($value);
	}

	public function offsetUnset(mixed $offset) : void{
		throw new \RuntimeException("Could not unset an attribute from an attribute map");
	}
}
