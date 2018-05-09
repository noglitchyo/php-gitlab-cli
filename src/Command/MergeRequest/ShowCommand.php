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
 * Class ShowCommand
 * @package Gitlabci\Command\MergeRequest
 * @author Maxime Elomari <maxime.elomari@gmail.com>
 */
class ShowCommand extends GitlabCommand
{
    /**
     * @var string
     */
    public static $defaultName = 'merge-request:show';

    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('Get single MR.');
        $this->setHelp('Shows information about a single merge request.');
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
            $data = $this->gitlabClient->mergeRequests()->show($projectId, $mrId);
        } catch (\Exception $e) {
            die('Gitlab: ' . $e->getMessage());
        }

        //die(var_dump($data));

        // Commands should be able to give a output following provided parameters

        $data = $this->getOutputFormatter($data, $input->getOption('output'))->format($data);

        $output->writeln($data);
    }

}



