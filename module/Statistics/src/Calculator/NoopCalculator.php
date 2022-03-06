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
        $value = $this->postCount > 0
            ? count($this->users) / $this->postCount
            : 0;

        return (new StatisticsTo())->setValue(round($value,2));
    }
}
