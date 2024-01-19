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

namespace pocketmine\permission;


class PermissionAttachmentInfo{
	/** @var Permissible */
	private $permissible;

	/** @var string */
	private $permission;

	/** @var PermissionAttachment|null */
	private $attachment;

	/** @var bool */
	private $value;

	/**
	 * @param Permissible               $permissible
	 * @param string                    $permission
	 * @param PermissionAttachment|null $attachment
	 * @param bool                      $value
	 *
	 * @throws \InvalidStateException
	 */
	public function __construct(Permissible $permissible, string $permission, PermissionAttachment $attachment = null, bool $value){
		$this->permissible = $permissible;
		$this->permission = $permission;
		$this->attachment = $attachment;
		$this->value = $value;
	}

	/**
	 * @return Permissible
	 */
	public function getPermissible() : Permissible{
		return $this->permissible;
	}

	/**
	 * @return string
	 */
	public function getPermission() : string{
		return $this->permission;
	}

	/**
	 * @return PermissionAttachment|null
	 */
	public function getAttachment(){
		return $this->attachment;
	}

	/**
	 * @return bool
	 */
	public function getValue() : bool{
		return $this->value;
	}
}