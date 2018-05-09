<?php
/**
 * This file is part of the php-gitlab-cli package.
 *
 * (c) Maxime Elomari <maxime.elomari@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gitlabci\Output;

use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlOutputFormatter
 * @package Gitlabci\Output
 * @author Maxime Elomari <maxime.elomari@gmail.com>
 */
class YamlOutputFormatter implements OutputFormatterInterface
{
    /**
     * @var
     */
    protected $resolver;

    /**
     * @param $data
     * @return string
     */
    public function format($data)
    {
        return Yaml::dump($data); /// check
    }

    /**
     * @param $data
     * @param null $type
     * @return bool
     */
    public function supports($data, $type = null)
    {
        return in_array($type, ['yml', 'yaml']);
    }

    /**
     * @param OutputFormatterResolverInterface $resolver
     */
    public function setResolver(OutputFormatterResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @return mixed
     */
    public function getResolver()
    {
        return $this->resolver;
    }
}
