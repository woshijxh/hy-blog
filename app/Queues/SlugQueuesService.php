<?php
/**
 * Created by PhpStorm
 * User: chenyi
 * Date: 2020/6/18
 * Time: 3:45 下午
 */

namespace App\Queues;

use App\Job\SlugJob;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Driver\DriverInterface;

class SlugQueuesService
{
    /**
     * @var DriverInterface
     */
    private $driver;

    public function __construct(DriverFactory $driverFactory)
    {
        $this->driver = $driverFactory->get('default');
    }

    /**
     * @param $params
     * @param int $delay
     * @return bool
     */
    public function push($params, int $delay = 0): bool
    {
        return $this->driver->push(new SlugJob($params), $delay);
    }
}
