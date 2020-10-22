<?php

namespace Core;

class View
{

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [], string $template = 'base.php')
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/App/Views/$view";  // relative to Core directory
        $fileTemplate = dirname(__DIR__) . "/App/Views/$template";

        if (is_readable($file) && is_readable($fileTemplate)) {
            ob_start();
            require_once $file;
            // Transfère le buffer dans $contenu
            $content = ob_get_clean();
            require_once $fileTemplate;
        } else {
            throw new \Exception("$file not found");
        }
    }

    public static function sendHttpResponse($content, $code = 200)
    {
        http_response_code($code);
        header('Content-type: text/html');

        echo($content);
    }
}
