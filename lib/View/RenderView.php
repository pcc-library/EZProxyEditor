<?php
/**
 * Created by IntelliJ IDEA.
 * User: gustavo.lanzas
 * Date: 2019-02-25
 * Time: 21:36
 */
namespace PCC_EPE\View;

use PCC_EPE\Controllers\MessageController;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class RenderView
 * @package PCC_EPE\View
 */
class RenderView
{
    protected $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param $template
     * @param $data
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function getTemplate($template, $data): string
    {
        $messages = new MessageController();
        $data['messages'] = $messages->getMessages();

        return $this->twig->render($template . ".twig", $data);
    }
}
