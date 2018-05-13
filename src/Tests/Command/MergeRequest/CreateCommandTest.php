<?php

/**
 * This file is part of the php-gitlab-cli package.
 *
 * (c) Maxime Elomari <maxime.elomari@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gitlabci\Tests\Command\MergeRequest;

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;
use Gitlabci\Command\MergeRequest\CreateCommand;
use Gitlabci\Tests\Command\GitlabCommandTestCase;

class CreateCommandTest extends GitlabCommandTestCase
{
    public static $testedCommandName = 'merge-request:create';

    /**
     * @return Application
     */
    public function getApplicationWithCommand()
    {
        $application = new Application();
        $application->add(new CreateCommand($this->getGitlabClient(), $this->getOutputFormatter()));

        return $application;
    }

    public function testExecuteWithoutArgs()
    {
        $this->expectExceptionMessage('Not enough arguments');

        $application = $this->getApplicationWithCommand();
        $commandTester = new CommandTester($command = $application->get(self::$testedCommandName));
        $commandTester->execute(
            ['command' => $command->getName()],
            ['decorated' => false]
        );
    }

    /*public function testExecuteWithRequiredParameters()
    {
        $application = $this->getApplicationWithCommand();

        $mergeRequest = new \StdClass();
        $mergeRequest->projectId = 'root/test-project';
        $mergeRequest->sourceBranch = 'test';
        $mergeRequest->targetBranch = 'master';
        $mergeRequest->title = 'My merge';

        $commandTester = new CommandTester($command = $application->get(self::$testedCommandName));

        $commandTester->execute(
            [
                'command' => $command->getName(),
                'project_id' => $mergeRequest->projectId,
                'source_branch' => $mergeRequest->sourceBranch,
                'target_branch' => $mergeRequest->targetBranch,
                'title' => $mergeRequest->title
            ],
            ['decorated' => false]
        );
    }*/
}
