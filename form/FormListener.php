<?php

declare(strict_types=1);

namespace pocketmine\form;

use pocketmine\form\event\ServerSettingsRequestEvent;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\bedrock\protocol\ModalFormResponsePacket;
use pocketmine\network\bedrock\protocol\ServerSettingsRequestPacket;

class FormListener implements Listener
{

    public function onDataPacketReceive(DataPacketReceiveEvent $e): void
    {
        $p = $e->getPlayer();
        $pk = $e->getPacket();
        if ($pk instanceof ModalFormResponsePacket) {
            $pk->decode();
            if (isset($p->forms) and isset($p->forms[$pk->formId])) {
                $p->forms[$pk->formId]->handleResponse($p, self::stupid_json_decode($pk->formData ?? "NULL", true));
                unset($p->forms[$pk->formId]);
            }
        } elseif ($pk instanceof ServerSettingsRequestPacket) {
            \server()->getPluginManager()->callEvent($ev = new ServerSettingsRequestEvent($p));
            if (($form = $ev->getForm()) instanceof ServerSettingsForm) {
                $form->sendToPlayer($p);
            }
        }
    }

    /**
     * Hack to work around a stupid bug in Minecraft W10 which causes empty strings to be sent unquoted in form responses.
     *
     * @param string $json
     * @param bool $assoc
     *
     * @return mixed
     */
    private static function stupid_json_decode(string $json, bool $assoc = false)
    {
        if (preg_match('/^\[(.+)\]$/s', $json, $matches) > 0) {
            $parts = preg_split('/(?:"(?:\\"|[^"])*"|)\K(,)/', $matches[1]); //Splits on commas not inside quotes, ignoring escaped quotes
            foreach ($parts as $k => $part) {
                $part = trim($part);
                if ($part === "") {
                    $part = "\"\"";
                }
                $parts[$k] = $part;
            }

            $fixed = "[" . implode(",", $parts) . "]";
            if (($ret = json_decode($fixed, $assoc)) === null) {
                throw new \InvalidArgumentException("Failed to fix JSON: " . json_last_error_msg() . "(original: $json, modified: $fixed)");
            }

            return $ret;
        }

        return json_decode($json, $assoc);
    }
}