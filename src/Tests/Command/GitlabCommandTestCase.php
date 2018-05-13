<?php

/**
 * This file is part of the php-gitlab-cli package.
 *
 * (c) Maxime Elomari <maxime.elomari@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gitlabci\Tests\Command;

use PHPUnit\Framework\TestCase;
use Gitlab\Client;
use Gitlabci\Output\OutputFormatterResolverInterface;

/**
 * Class GitlabCommandTestCase
 * @package Gitlabci\Tests\Command
 */
class GitlabCommandTestCase extends TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getGitlabClient()
    {
        return $this->getMockBuilder(Client::class)->getMock();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getOutputFormatter()
    {
        return $this->getMockBuilder(OutputFormatterResolverInterface::class)->getMock();
    }
}