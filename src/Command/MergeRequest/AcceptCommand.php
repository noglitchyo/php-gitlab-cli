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
 * Class AcceptCommand
 * @package Gitlabci\Command\MergeRequest
 */
class AcceptCommand extends GitlabCommand
{
    /**
     * @var string
     */
    public static $defaultName = 'merge-request:accept';

    /**
     * @var array
     */
    protected $options = [
        'merge_commit_message' => [
            'm',
            InputArgument::OPTIONAL,
            'Custom merge commit message'
        ],
        'merge_when_pipeline_succeeds' => [
            'p',
            InputArgument::OPTIONAL,
            'The MR is merged when the pipeline succeeds'
        ],
        'should_remove_source_branch' => [
            'd',
            InputArgument::OPTIONAL,
            'Removes the source branch',
        ],
        'sha' => [
            's',
            InputArgument::OPTIONAL,
            'SHA must match the HEAD of the source branch, otherwise the merge will fail',
        ]
    ];

    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('Accept a merge-request');
        $this->setHelp('This command allows you to accept a merge-request');
        $this->addArgument('project_id', InputArgument::REQUIRED, 'Project ID');
        $this->addArgument('merge_request_iid', InputArgument::REQUIRED, 'Internal ID of merge-request');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectId = $input->getArgument('project_id');
        $iid = $input->getArgument('merge_request_iid');

        $options = $this->getProcessedOptions($input->getOptions());

        try {
            $data = $this->gitlabClient->mergeRequests()->merge($projectId, $iid);
        } catch (\Exception $e) {
            die($e->getMessage());
        }


        $output->writeln(sprintf('Merge-request #%s successfully accepted!', $data['iid']));
    }
}



