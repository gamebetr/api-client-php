<?php

declare(strict_types=1);

namespace Gamebetr\ApiClient\Types;

use Gamebetr\ApiClient\Abstracts\IntermediateJsonApiType;

class WinLossReport extends IntermediateJsonApiType
{
    /**
     * {@inheritdoc}
     */
    public $type = 'winLossReport';

    /**
     * {@inheritdoc}
     */
    protected $methods = [];
}
