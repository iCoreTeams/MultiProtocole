<?php

declare(strict_types=1);

namespace pocketmine\bossbar;

use pocketmine\entity\Entity;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\network\mcpe\protocol\BossEventPacket;
use pocketmine\network\mcpe\protocol\RemoveEntityPacket;
use pocketmine\network\mcpe\protocol\SetEntityDataPacket;
use pocketmine\network\mcpe\protocol\UpdateAttributesPacket;
use pocketmine\Player;
use function max;
use function min;

class BossBarInstance{

	/** @var Player[] */
	protected array $bossBarViewers = [];
	/** @var int|bool */
	protected int|bool|null $eid = null;

    /**
     * @param Player $p
     * @param string $title
     * @param int $percentage
     * @return void
     */
    public function addBossBar(Player $p, string $title, int $percentage = 100) : void{
		if($this->eid === null){
			$this->eid = Entity::$entityCount++;
		}
		if(!isset($this->bossBarViewers[$p->getId()])){
			$pk = new AddEntityPacket();
			$pk->entityRuntimeId = $this->eid;
			$pk->type = BossBarValues::NETWORK_ID;
			$pk->x = $p->x;
			$pk->y = $p->y - 28;
			$pk->z = $p->z;
			$pk->yaw = $pk->pitch = $pk->speedX = $pk->speedY = $pk->speedZ = 0.0;
			$pk->metadata = [
				Entity::DATA_LEAD_HOLDER_EID => [Entity::DATA_TYPE_LONG, -1],
				Entity::DATA_FLAGS => [Entity::DATA_TYPE_LONG,
					(1 << Entity::DATA_FLAG_SILENT) |
					(1 << Entity::DATA_FLAG_INVISIBLE) |
					(1 << Entity::DATA_FLAG_NO_AI)
				],
				Entity::DATA_SCALE => [Entity::DATA_TYPE_FLOAT, 0.0],
				Entity::DATA_NAMETAG => [Entity::DATA_TYPE_STRING, $title],
				Entity::DATA_BOUNDING_BOX_WIDTH => [Entity::DATA_TYPE_FLOAT, 0.0],
				Entity::DATA_BOUNDING_BOX_HEIGHT => [Entity::DATA_TYPE_FLOAT, 0.0]
			];
			$pk->attributes = [
				new BossBarValues(1, 600, max(1, min($percentage, 100)) * 6, "minecraft:health")
			];
			$p->sendDataPacket($pk);

			$bpk = new BossEventPacket();
			$bpk->bossEid = $this->eid;
			$bpk->eventType = BossEventPacket::TYPE_SHOW;
			$bpk->title = $title;
			$bpk->healthPercent = $percentage / 100;
			$bpk->unknownShort = $bpk->color = $bpk->overlay = 0; //That will never work but it should be there.
			$p->sendDataPacket($bpk);

			$this->bossBarViewers[$p->getId()] = $p;
		}else{
			$npk = new SetEntityDataPacket();
			$npk->metadata = [
				Entity::DATA_NAMETAG => [Entity::DATA_TYPE_STRING, $title]
			];
			$npk->entityRuntimeId = $this->eid;
			$p->sendDataPacket($npk);

			$bpk = new BossEventPacket();
			$bpk->bossEid = $this->eid;
			$bpk->eventType = BossEventPacket::TYPE_TITLE;
			$bpk->title = $title;
			$p->sendDataPacket($bpk);

			$upk = new UpdateAttributesPacket();
			$upk->entries[] = new BossBarValues(1, 600, max(1, min($percentage, 100)) * 6, "minecraft:health");
			$upk->entityRuntimeId = $this->eid;
			$p->sendDataPacket($upk);

			$bpk2 = new BossEventPacket();
			$bpk2->bossEid = $this->eid;
			$bpk2->eventType = BossEventPacket::TYPE_HEALTH_PERCENT;
			$bpk2->healthPercent = $percentage / 100;
			$p->sendDataPacket($bpk2);
		}
	}

    /**
     * @param Player $p
     * @return void
     */
    public function removeBossBar(Player $p) : void{
		if(isset($this->bossBarViewers[$p->getId()]) and $this->eid !== null){
			$bpk = new BossEventPacket();
			$bpk->bossEid = $this->eid;
			$bpk->eventType = BossEventPacket::TYPE_HIDE;
			$p->sendDataPacket($bpk);

			$pk = new RemoveEntityPacket();
			$pk->entityUniqueId = $this->eid;
			$p->sendDataPacket($pk);
		}
		unset($this->bossBarViewers[$p->getId()]);
	}
}