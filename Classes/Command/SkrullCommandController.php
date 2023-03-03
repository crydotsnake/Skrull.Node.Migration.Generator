<?php
namespace Skrull\Node\Migration\Generator\Command;

/*
 * This file is part of the Skrull.Node.Migration.Generator package.
 *
 * (C) 2023 Simon Krull
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE.md file which was distributed with this
 * source code.
 */

use Neos\Flow\Cli\CommandController;
use Neos\Flow\Cli\Exception\StopCommandException;
use Neos\Flow\Package\Exception\UnknownPackageException;
use Neos\Flow\Package\PackageManager;
use Neos\Utility\Exception\FilesException;
use Skrull\Node\Migration\Generator\Service\GeneratorService;
use Neos\Flow\Annotations as Flow;

/**
 * Command controller for the Node Migration generator.
 *
 */
class SkrullCommandController extends CommandController
{
    /**
     * @Flow\Inject
     * @var PackageManager
     */
    protected PackageManager $packageManager;

    /**
     * @Flow\Inject
     * @var GeneratorService
     */
    protected GeneratorService $generatorService;

    /**
     * Creates a node migration for the given package Key.
     *
     * @param string $packageKey The packageKey for the given package
     * @return void
     * @throws UnknownPackageException
     * @throws FilesException
     * @throws StopCommandException
     */
    public function migrationCreateCommand(string $packageKey): void
    {
        if (!$this->packageManager->isPackageAvailable($packageKey)) {
            $this->outputLine('Package "%s" is not available.', [$packageKey]);
            $this->quit(1);
        }

        $createdMigration = $this->generatorService->createNodeMigration($packageKey);
        $this->outputLine($createdMigration);
        $this->outputLine('Your node migration has been created successfully.');
    }
}
