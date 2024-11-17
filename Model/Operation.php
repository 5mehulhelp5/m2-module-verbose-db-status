<?php declare(strict_types=1);

namespace SamJUK\VerboseDBStatus\Model;

use SamJUK\VerboseDBStatus\Model\OperationTargetFactory;

class Operation
{
    public const INDENT = 2;

    private ?string $title;
    private ?array $targets;
    private OperationTargetFactory $operationTargetFactory;

    public function __construct(
        OperationTargetFactory $operationTargetFactory
    ) {
        $this->operationTargetFactory = $operationTargetFactory;
    }

    public function setTitle($title): Operation
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTargets($targets): Operation
    {
        $this->targets = array_map(function ($target) {
            return $this->operationTargetFactory->create()
                ->setOldData($target->getOld())
                ->setNewData($target->getNew());
        }, $targets);
        return $this;
    }

    public function getTargets(): ?array
    {
        return $this->targets;
    }

    public function __toString(): string
    {
        return str_repeat(' ', self::INDENT)
            . $this->getTitle()
            . array_reduce($this->getTargets(), function ($carry, $target) {
                return $carry . PHP_EOL . $target;
            }, '')
            . PHP_EOL;
    }
}
