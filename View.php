<?php


namespace app\core;


class View
{
    public string $title = '';

    public function renderView($view,$params =[])
    {
        $viewContent = $this->renderOnlyView($view,$params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);

    }

    protected function layoutContent()
    {
        $layout = App::$app->controller->layout ?? 'main';
        ob_start();
        include_once App::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view,$params)
    {
        ob_start();
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        include_once App::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}