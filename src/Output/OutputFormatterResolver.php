<?php

namespace Gitlabci\Output;

/**
 * Class OutputFormatterResolver
 * @package Gitlabci\Output
 * @author Maxime Elomari <maxime.elomari@gmail.com>
 */
class OutputFormatterResolver implements OutputFormatterResolverInterface
{
    /**
     * @var OutputFormatterInterface[] An array of OutputFormatterInterface objects
     */
    private $formatters = array();

    /**
     * @param OutputFormatterInterface[] $formatters An array of loaders
     */
    public function __construct(array $formatters = array())
    {
        foreach ($formatters as $formatter) {
            $this->addOutputFormatter($formatter);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($resource, $type = null)
    {
        foreach ($this->formatters as $formatter) {
            if ($formatter->supports($resource, $type)) {
                return $formatter;
            }
        }

        return false;
    }

    /**
     * @param OutputFormatterInterface $formatter
     */
    public function addOutputFormatter(OutputFormatterInterface $formatter)
    {
        $this->formatters[] = $formatter;
        $formatter->setResolver($this);
    }

    /**
     * Returns the registered loaders.
     *
     * @return OutputFormatterInterface[] An array of OutputFormatterInterface instances
     */
    public function getFormatters()
    {
        return $this->formatters;
    }
}
