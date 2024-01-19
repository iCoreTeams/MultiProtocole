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

namespace pocketmine\event\entity;

use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;

class EntityDataPropertyChangeEvent extends EntityEvent implements Cancellable{
	public static $handlerList = null;

	/** @var int */
	protected $id;
	/** @var int */
	protected $type;
	/** @var mixed */
	protected $value;
	/** @var bool */
	protected $send;

	public function __construct(Entity $entity, int $id, int $type, $value, bool $send){
		$this->entity = $entity;
		$this->id = $id;
		$this->type = $type;
		$this->value = $value;
		$this->send = $send;
	}

	/**
	 * @return int
	 */
	public function getId() : int{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getValue(){
		return $this->value;
	}

	/**
	 * @param mixed $value
	 */
	public function setValue($value) : void{
		$this->value = $value;
	}

	/**
	 * @return bool
	 */
	public function isSend() : bool{
		return $this->send;
	}

	/**
	 * @param bool $send
	 */
	public function setSend(bool $send) : void{
		$this->send = $send;
	}
}
