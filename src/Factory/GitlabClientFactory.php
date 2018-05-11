<?php
/**
 * This file is part of the php-gitlab-cli package.
 *
 * (c) Maxime Elomari <maxime.elomari@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gitlabci\Factory;

/**
 * Class GitlabClientFactory
 * @package Gitlabci\Factory
 * @author Maxime Elomari <maxime.elomari@gmail.com>
 */
class GitlabClientFactory
{
    /**
     * @param $url
     * @param $token
     * @return \Gitlab\Client
     */
    public static function createGitlabClient($url, $token)
    {
        return \Gitlab\Client::create($url)->authenticate($token);
    }
}
