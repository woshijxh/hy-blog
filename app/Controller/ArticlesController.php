<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\ArticlesService;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Di\Annotation\Inject;

class ArticlesController extends AbstractController
{
    /**
     * @Inject()
     * @var ArticlesService
     */
    public $articlesService;

    /**
     * @Inject()
     * @var RequestInterface
     */
    public $request;

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index()
    {
        return $this->success($this->articlesService->index($this->request->all()));
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store()
    {
        return $this->success($this->articlesService->store($this->request->all(), $this->request->getAttribute('user')['id']));
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update()
    {
        return $this->success($this->articlesService->update($this->request->all(), $this->request->getAttribute('user')['id']));
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete()
    {
        return $this->success($this->articlesService->delete($this->request->input('id')));
    }
}
