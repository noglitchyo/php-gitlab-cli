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
 * Interface OutputFormatterResolverInterface
 * @package Gitlabci\Output
 * @author Maxime Elomari <maxime.elomari@gmail.com>
 */
interface OutputFormatterResolverInterface
{
    /**
     * Returns a formatter able to format the data for output.
     *
     * @param mixed       $resource A resource
     * @param string|null $type     The resource type or null if unknown
     *
     * @return OutputFormatterInterfacet|false The output formatter or false if none is able to format the resource
     */
    public function resolve($resource, $type = null);
}
