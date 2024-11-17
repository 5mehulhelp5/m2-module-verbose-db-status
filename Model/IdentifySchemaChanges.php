<?php declare(strict_types=1);

namespace SamJUK\VerboseDBStatus\Model;

use SamJUK\VerboseDBStatus\Model\OperationFactory;
use SamJUK\VerboseDBStatus\Model\Verbosity;
use Magento\Framework\Setup\Declaration\Schema\Diff\SchemaDiff;
use Magento\Framework\Setup\Declaration\Schema\SchemaConfigInterface;

class IdentifySchemaChanges
{
    private SchemaConfigInterface $schemaConfig;
    private SchemaDiff $schemaDiff;
    private Verbosity $verbosity;
    private OperationFactory $operationFactory;

    public function __construct(
        SchemaConfigInterface $schemaConfig,
        SchemaDiff $schemaDiff,
        Verbosity $verbosity,
        OperationFactory $operationFactory
    ) {
        $this->schemaConfig = $schemaConfig;
        $this->schemaDiff = $schemaDiff;
        $this->verbosity = $verbosity;
        $this->operationFactory = $operationFactory;
    }

    public function getChanges(): array
    {
        $declarativeSchema = $this->schemaConfig->getDeclarationConfig();
        $dbSchema = $this->schemaConfig->getDbConfig();
        $diff = $this->schemaDiff->diff($declarativeSchema, $dbSchema);
        return $diff->debugChanges;
    }

    public function getChangeLog(): string
    {
        $changelog = '';
        foreach ($this->getChanges() as $operation => $targets) {
            $changelog .= $this->operationFactory->create()
                ->setTitle($operation)
                ->setTargets($targets);
        }
        return $changelog;
    }
}
