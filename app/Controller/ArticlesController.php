<?php

declare(strict_types=1);

namespace App\Controller;

use App\Request\ArticlesRequest;
use App\Services\ArticlesService;
use Hyperf\Di\Annotation\Inject;

class ArticlesController extends AbstractController
{
    /**
     * @Inject()
     * @var ArticlesService
     */
    public $articlesService;

    /**
     * @param ArticlesRequest $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(ArticlesRequest $request)
    {
        return $this->success($this->articlesService->index($request->all()));
    }

    /**
     * @param ArticlesRequest $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store(ArticlesRequest $request)
    {
        return $this->success($this->articlesService->store($request->validated(),
            $this->request->getAttribute('user')['id']));
    }

    /**
     * @param ArticlesRequest $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(ArticlesRequest $request)
    {
        return $this->success($this->articlesService->update($request->validated(),
            $this->request->getAttribute('user')['id']));
    }

    /**
     * @param ArticlesRequest $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(ArticlesRequest $request)
    {
        return $this->success($this->articlesService->delete($request->input('id')));
    }
}
