<?php declare(strict_types=1);

namespace SamJUK\VerboseDBStatus\Plugin;

use SamJUK\VerboseDBStatus\Model\Verbosity;
use SamJUK\VerboseDBStatus\Model\IdentifySchemaChanges;
use Magento\Framework\Setup\Declaration\Schema\UpToDateDeclarativeSchema as BaseUpToDateDeclarativeSchema;

class UpToDateDeclarativeSchema
{
    private IdentifySchemaChanges $identifySchemaChanges;
    private Verbosity $verbosity;

    public function __construct(
        IdentifySchemaChanges $identifySchemaChanges,
        Verbosity $verbosity
    ) {
        $this->identifySchemaChanges = $identifySchemaChanges;
        $this->verbosity = $verbosity;
    }

    public function afterGetNotUpToDateMessage(BaseUpToDateDeclarativeSchema $subject, string $result) : string
    {
        if (!$this->verbosity->isVerbose()) {
            return $result;
        }

        return $result . PHP_EOL . $this->identifySchemaChanges->getChangeLog();
    }
}
