<?php

namespace Gitlabci\Command\MergeRequest\Shortcut;

use Gitlabci\Command\GitlabCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveWipStatusCommand extends GitlabCommand
{
    protected function configure()
    {
        $this->setName('merge-request:remove-wip');
        $this->setDescription('Remove WIP status from merge-request');
        $this->setHelp('This command allows you to remove the WIP status from a merge-request');
        $this->addArgument('project_id', InputArgument::REQUIRED, 'Project ID on Gitlab');
        $this->addArgument('source_branch', InputArgument::REQUIRED, 'Source branch to merge from');
        $this->addArgument('target_branch', InputArgument::REQUIRED, 'Target branch to merge on');
        $this->addArgument('title', InputArgument::REQUIRED, 'Merge request title');
        $this->addArgument('wip', InputArgument::OPTIONAL, 'WIP Status', true);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectId = $input->getArgument('project_id');
        $iid = $input->getArgument('merge_request_iid');
        $params = $input->getArgument('params');

        try {
            $data = $this->gitlabClient->mergeRequests()->update($projectId, $iid, $params);
        } catch (\Exception $e) {
            die($e->getMessage());
        }


        $output->writeln(sprintf('Merge-request #%s successfully created!', $data['id']));
    }
}



