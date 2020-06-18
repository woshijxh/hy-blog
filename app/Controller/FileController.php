<?php
/**
 * Created by PhpStorm
 * User: chenyi
 * Date: 2020/6/18
 * Time: 6:56 下午
 */

namespace App\Controller;


use App\Exception\ServiceException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Filesystem\Filesystem;
use Hyperf\Utils\Str;

class FileController extends AbstractController
{
    /**
     * @Inject()
     * @var Filesystem
     */
    private $fileSystem;

    public function upload(RequestInterface $request)
    {
        $file = $request->file('file');

        $allowedArr = [
            'jpg',
            'png',
            'mp3',
            'mp4',
            'jpeg',
        ];

        $fileType = [
            'image',
            'avatar',
            'audio',
            'video',
            'other',
        ];

        $ext = $file->getExtension();

        if ( !in_array($ext, $allowedArr) ) {
            throw new ServiceException('文件上传格式不准许！');
        }

        // 文件夹路径
        $folderPath = $fileType[$request->input('type')] ?? 'other' . '/' . date('Ymd') . '/';
        // 路径
        $filePath = config('storage_path') . $folderPath;

        if ( !$this->fileSystem->isDirectory($filePath) ) {
            $this->fileSystem->makeDirectory($filePath, 0755, true);
        }


        $fileName = Str::random(16) . '.' . $ext;
        $filePath = $filePath . $fileName;

        var_dump($filePath);

        if ( !$this->fileSystem->move($file->getRealPath(), $filePath) ) {
            throw new ServiceException('上传失败');
        }

        return $this->success(config('host') . $folderPath . $fileName);
    }
}
