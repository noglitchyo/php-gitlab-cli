<?php
/**
 * This file is part of the php-gitlab-cli package.
 *
 * (c) Maxime Elomari <maxime.elomari@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gitlabci\Command;

use Gitlabci\Output\OutputFormatterResolverInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Gitlab\Client as GitlabClient;

/**
 * Class GitlabCommand
 * @package Gitlabci\Command
 * @author Maxime Elomari <maxime.elomari@gmail.com>
 */
abstract class GitlabCommand extends Command
{
    /**
     * @var \Gitlab\Client
     */
    protected $gitlabClient;

    /**
     * Describe all options for the given command.
     * @var array
     */
    protected $options = [];

    /**
     * @var OutputFormatterResolverInterface
     */
    protected $outputFormatter;

    /**
     * GitlabCommand constructor.
     * @param GitlabClient $gitlabClient
     * @param OutputFormatterResolverInterface $outputFormatter
     * @param null $name
     */
    public function __construct(GitlabClient $gitlabClient, OutputFormatterResolverInterface $outputFormatter, $name = null)
    {
        parent::__construct($name);
        $this->gitlabClient = $gitlabClient;
        $this->outputFormatter = $outputFormatter;
    }

    /**
     *
     */
    protected function configure()
    {
        $this->addOptions($this->options);
    }

    /**
     * Add standard options for Gitlab
     * @param $options
     */
    protected function addOptions($options)
    {
        foreach ($options as $name => $params) {
            $this->addOption($name, ...$params);
        }

        $this->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Desired output format: json, yaml, xml', 'json');
    }

    /**
     * Check if the given option name is part of the Gitlab options or not
     * @param $name
     * @return bool
     */
    protected function isNotOptionDefault($name)
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * Filter options which are not part of the Gitlab API
     * @param array $options
     * @return array
     */
    protected function getProcessedOptions(array $options = [])
    {
        return array_filter($options, function ($value, $name) {
            return (is_array($value) ? !empty($value) : $value !== NULL) && $this->isNotOptionDefault($name);
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Retrieve the selected output formatter for the given command
     * @param $data
     * @param $type
     * @return false|\Gitlabci\Output\OutputFormatterInterface
     * @throws \Exception
     */
    protected function getOutputFormatter($data, $type)
    {
        // Todo: import a resolver, throw exception if output is not supported by any Output available
        if (!$formatter = $this->outputFormatter->resolve($data, $type)){
            throw new \Exception(sprintf('No output formatter supports %s output', $type));
        }

        return $formatter;
    }
}



