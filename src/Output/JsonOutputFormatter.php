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

/**
 * Class JsonOutputFormatter
 * @package Gitlabci\Output
 * @author Maxime Elomari <maxime.elomari@gmail.com>
 */
class JsonOutputFormatter implements OutputFormatterInterface
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
        return json_encode($data);
    }

    /**
     * @param $data
     * @param null $type
     * @return bool
     */
    public function supports($data, $type = null)
    {
        return $type == 'json';
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
