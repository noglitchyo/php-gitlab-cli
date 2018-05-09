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
 * Interface OutputFormatterInterface
 * @package Gitlabci\Output
 * @author Maxime Elomari <maxime.elomari@gmail.com>
 */
interface OutputFormatterInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function format($data);

    /**
     * @param $data
     * @param null $type
     * @return mixed
     */
    public function supports($data, $type = null);

    /**
     * @return mixed
     */
    public function getResolver();

    /**
     * @param OutputFormatterResolverInterface $resolver
     * @return mixed
     */
    public function setResolver(OutputFormatterResolverInterface $resolver);
}
