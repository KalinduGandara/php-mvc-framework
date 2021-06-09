<?php


namespace kalindugandara\phpmvc;


use kalindugandara\phpmvc\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}