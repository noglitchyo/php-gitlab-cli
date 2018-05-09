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
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UpdateCommand
 * @package Gitlabci\Command\MergeRequest
 */
class UpdateCommand extends GitlabCommand
{
    use WipOptionTrait;

    /**
     * @var string
     */
    public static $defaultName = 'merge-request:update';

    /**
     * @var array
     */
    protected $options = [
        'title' => [
            null,
            InputOption::VALUE_REQUIRED,
            'Title of MR'
        ],
        'target_branch' => [
            null,
            InputOption::VALUE_REQUIRED,
            "The target branch"
        ],
        'assignee_id' => [
            null,
            InputOption::VALUE_REQUIRED,
            "The ID of the user to assign the merge request to. Set to 0 or provide an empty value to unassign all assignees."
        ],
        'milestone_id' => [
            null,
            InputOption::VALUE_REQUIRED,
            "The ID of a milestone to assign the merge request to. Set to 0 or provide an empty value to unassign a milestone."
        ],
        'labels' => [
            null,
            InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED,
            "Comma-separated label names for a merge request. Set to an empty string to unassign all labels."
        ],
        'description' => [
            null, InputOption::VALUE_OPTIONAL,
            "Description of MR"
        ],
        'state_event' => [
            null,
            InputOption::VALUE_OPTIONAL, // todo handle state_event option
            "New state (close/reopen)"
        ],
        'remove_source_branch' => [
            'd',
            InputOption::VALUE_OPTIONAL, // todo: handle correctly if option not provided
            "Flag indicating if a merge request should remove the source branch when merging"
        ],
        'squash' => [
            null,
            InputOption::VALUE_OPTIONAL,
            "Squash commits into a single commit when merging"
        ],
        'discussion_locked' => [
            null,
            InputOption::VALUE_OPTIONAL,
            "Flag indicating if the merge request's discussion is locked. 
            If the discussion is locked only project members can add, edit or resolve comments."
        ],
        'allow_maintainer_to_push' => [
            null,
            InputOption::VALUE_OPTIONAL,
            "Whether or not a maintainer of the target project can push to the source branch"
        ],
        'wip' => [
            null,
            InputOption::VALUE_OPTIONAL,
            'WIP Status'
        ],
    ];

    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('Update an existing merge-request');
        $this->setHelp('This command allows you to update a merge-request');
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
            $mrData = $this->gitlabClient->mergeRequests()->show($projectId, $mrId);
        } catch (\Exception $e) {
            die('Failed to retrieve data from Gitlab');
        }
        $options = $this->getProcessedOptions($input->getOptions());

        if (isset($options['wip'])) {
            $options['title'] = $this->handleWipStatus($options['wip'], $mrData['title']);
        }

        try {
            $data = $this->gitlabClient->mergeRequests()->update($projectId, $mrId, $options);
        } catch (\Exception $e) {
            die('Gitlab: ' . $e->getMessage());
        }

        $output->writeln(sprintf('Merge-request #%s successfully updated!', $data['id']));
    }
}



