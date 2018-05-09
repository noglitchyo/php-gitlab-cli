<?php

namespace Gitlabci\Command\MergeRequest\Utils;

trait WipOptionTrait
{
    public static $wipFlag = 'WIP:';

    public function handleWipStatus($wip, $title)
    {
        if (!$wip) {
            $title = str_replace(self::$wipFlag, '', $title);
        } else {
            if ($this->isWip($title) === false) {
                $title = self::$wipFlag." ".$title;
            }
        }

        return $title;
    }

    public function isWip($title)
    {
        return strpos($title, self::$wipFlag);
    }
}