<?php

declare(strict_types = 1);

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

class NoopCalculator extends AbstractCalculator
{

    protected const UNITS = 'posts';

    private $users = [];
    private $postCount = 0;

    /**
     * @inheritDoc
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $this->users[$postTo->getAuthorId()] = true;
        $this->postCount++;
    }

    /**
     * @inheritDoc
     */
    protected function doCalculate(): StatisticsTo
    {
        $userCount = count($this->users);
        $value = $userCount > 0
            ? $this->postCount / $userCount
            : 0;

        return (new StatisticsTo())->setValue(round($value,2));
    }
}
