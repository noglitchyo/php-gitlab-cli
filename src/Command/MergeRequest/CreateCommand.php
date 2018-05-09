<?php
/**
 * This file is part of the php-gitlab-cli package.
 *
 * (c) Maxime Elomari <maxime.elomari@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gitlabci\Command\MergeRequest;

use Gitlabci\Command\GitlabCommand;
use Gitlabci\Command\MergeRequest\Utils\WipOptionTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class CreateCommand
 * @package Gitlabci\Command\MergeRequest
 * @author Maxime Elomari <maxime.elomari@gmail.com>
 */
class CreateCommand extends GitlabCommand
{
    use WipOptionTrait;

    /**
     * @var string
     */
    public static $defaultName = 'merge-request:create';

    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('Create a new merge-request');
        $this->setHelp('This command allows you to create a merge-request');
        $this->addArgument('project_id', InputArgument::REQUIRED, 'Project ID on Gitlab');
        $this->addArgument('source_branch', InputArgument::REQUIRED, 'Source branch to merge from');
        $this->addArgument('target_branch', InputArgument::REQUIRED, 'Target branch to merge on');
        $this->addArgument('title', InputArgument::REQUIRED, 'Merge request title');
        $this->addArgument('wip', InputArgument::OPTIONAL, 'WIP Status', true);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectId = $input->getArgument('project_id');
        $source = $input->getArgument('source_branch');
        $target = $input->getArgument('target_branch');
        $title = $input->getArgument('title');
        $wipFlag = $input->getArgument('wip');

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Continue with this action?', false);

        if ($wipFlag) {
            $data['title'] = $this->handleWipStatus($wipFlag, $title);
        }

        try {
            $data = $this->gitlabClient->mergeRequests()->create($projectId, $source, $target, $title);
        } catch (\Exception $e) {
            die($e->getMessage());
        }


        $output->writeln(sprintf('Merge-request #%s successfully created!', $data['id']));
    }
}



