<?php declare(strict_types=1);

namespace SamJUK\VerboseDBStatus\Model;

class Verbosity
{
    public const VERBOSE = 1;
    public const EXTRA_VERBOSE = 2;

    public function isVerbose(): bool
    {
        return $this->getVerbosity() >= self::VERBOSE;
    }

    public function isExtraVerbose(): bool
    {
        return $this->getVerbosity() >= self::EXTRA_VERBOSE;
    }

    private function getVerbosity(): int
    {
        // phpcs:ignore
        return (int)@$_ENV['SHELL_VERBOSITY'];
    }
}
