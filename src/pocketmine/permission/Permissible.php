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

use pocketmine\plugin\Plugin;

interface Permissible extends ServerOperator{

	/**
	 * Checks if this instance has a permission overridden
	 *
	 * @param string|Permission $name
	 *
	 * @return bool
	 */
	public function isPermissionSet($name) : bool;

	/**
	 * Returns the permission value if overridden, or the default value if not
	 *
	 * @param string|Permission $name
	 *
	 * @return bool
	 */
	public function hasPermission(string|Permission $name) : bool;

	/**
	 * @param Plugin $plugin
	 * @param string $name
	 * @param bool   $value
	 *
	 * @return PermissionAttachment
	 */
	public function addAttachment(Plugin $plugin, string $name = null, bool $value = null) : PermissionAttachment;

	/**
	 * @param PermissionAttachment $attachment
	 *
	 * @return void
	 */
	public function removeAttachment(PermissionAttachment $attachment);


	/**
	 * @return void
	 */
	public function recalculatePermissions();

	/**
	 * @return PermissionAttachmentInfo[]
	 */
	public function getEffectivePermissions() : array;

}