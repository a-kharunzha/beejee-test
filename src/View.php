<?php declare(strict_types=1);

namespace App;

use DI\Annotation\Inject;
use Twig\Environment;

class View
{
    const FILE_EXT = '.html.twig';
    /**
     * @var string
     */
    private $fileName;

    /**
     * @Inject
     * @var Environment
     */
    protected $twig;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function render(array $data = [])
    {
        $template = $this->twig->load($this->fileName . static::FILE_EXT);
        return $template->render($data);
    }

}
