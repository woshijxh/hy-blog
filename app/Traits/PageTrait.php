<?php
/**
 * Created by PhpStorm
 * User: chenyi
 * Date: 2020/6/17
 * Time: 5:59 下午
 */

namespace App\Traits;


use Hyperf\Contract\LengthAwarePaginatorInterface;

trait PageTrait
{
    public function paginateData(LengthAwarePaginatorInterface $paginateData)
    {
        return [
            'list'        => $paginateData->items(),
            'currentPage' => $paginateData->currentPage(),
            'lastPage'    => $paginateData->lastPage(),
            'total'       => $paginateData->total(),
            'pageSize'    => $paginateData->perPage(),
        ];
    }
}
