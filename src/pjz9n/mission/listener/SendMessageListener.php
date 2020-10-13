<?php

/**
 * Copyright (c) 2020 PJZ9n.
 *
 * This file is part of Mission.
 *
 * Mission is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Mission is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Mission. If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace pjz9n\mission\listener;

use pjz9n\mission\event\MissionCompleteEvent;
use pocketmine\event\Listener;
use pocketmine\utils\Config;

class SendMessageListener implements Listener
{
    /** @var Config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function sendMissionCompleteMessage(MissionCompleteEvent $event): void
    {
        if (!$this->config->get("send-missioncomplete-message")) {
            return;
        }
        $event->getPlayer()->sendMessage($this->getReplacedMessage($event->getMission()->getName()));
    }

    private function getReplacedMessage(string $missionName): string
    {
        return str_replace([
            "{mission.name}",
        ], $missionName, $this->config->get("missioncomplete-message"));
    }
}
