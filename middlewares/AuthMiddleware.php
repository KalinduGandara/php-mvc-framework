<?php


namespace app\core\middlewares;


use app\core\App;
use app\core\exception\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    public array $actions;

    /**
     * AuthMiddleware constructor.
     * @param array $actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }


    public function execute()
    {
        if (App::isGuest()){
            if (empty($this->actions) || in_array(App::$app->controller->action,$this->actions)){
                throw new ForbiddenException();
            }

        }
    }
}