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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListCommand
 * @package Gitlabci\Command\MergeRequest
 * @author Maxime Elomari <maxime.elomari@gmail.com>
 */
class ListCommand extends GitlabCommand
{
    /**
     * @var string
     */
    public static $defaultName = 'merge-request:list';

    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('List merge requests.');
        $this->setHelp('Get all merge requests the authenticated user has access to. By default it returns only merge requests created by the current user. To get all merge requests, use parameter --scope all.');
        $this->addArgument('project_id', InputArgument::REQUIRED, 'Project ID on Gitlab');
        $this->addArgument('id', InputArgument::REQUIRED, 'Internal ID of merge-request');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectId = $input->getArgument('project_id');
        $mrId = $input->getArgument('id');

        try {
            $data = $this->gitlabClient->mergeRequests()->all($projectId, $mrId);
        } catch (\Exception $e) {
            die('Gitlab: ' . $e->getMessage());
        }

        $data = $this->getOutputFormatter($data, $input->getOption('output'))->format($data);

        $output->writeln($data);
    }

}



