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

namespace pjz9n\mission\form\reward;

use pjz9n\mission\form\generic\MessageForm;
use pjz9n\mission\language\LanguageHolder;
use pjz9n\mission\mission\Mission;
use pjz9n\mission\reward\Reward;
use pjz9n\pmformsaddon\AbstractModalForm;
use pocketmine\Player;

class RewardRemoveConfirmForm extends AbstractModalForm
{
    /** @var Mission */
    private $mission;

    /** @var Reward */
    private $reward;

    public function __construct(Mission $mission, Reward $reward)
    {
        parent::__construct(
            LanguageHolder::get()->translateString("reward.edit.remove.confirm"),
            LanguageHolder::get()->translateString("reward.edit.remove.confirm.message", [$reward->getDetail()]),
            LanguageHolder::get()->translateString("ui.yes"),
            LanguageHolder::get()->translateString("ui.no")
        );
        $this->mission = $mission;
        $this->reward = $reward;
    }

    public function onSubmit(Player $player, bool $choice): void
    {
        if (!$choice) {
            $player->sendForm(new RewardActionSelectForm($this->mission, $this->reward));
            return;
        }
        $this->mission->removeReward($this->reward);
        $player->sendForm(new MessageForm(LanguageHolder::get()->translateString("reward.edit.remove.success", [
            $this->reward->getDetail(),
        ]), new RewardListForm($this->mission)));
    }
}
