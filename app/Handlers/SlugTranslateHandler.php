<?php
/***
 * ┌───┐   ┌───┬───┬───┬───┐ ┌───┬───┬───┬───┐ ┌───┬───┬───┬───┐ ┌───┬───┬───┐
 * │Esc│   │ F1│ F2│ F3│ F4│ │ F5│ F6│ F7│ F8│ │ F9│F10│F11│F12│ │P/S│S L│P/B│  ┌┐    ┌┐    ┌┐
 * └───┘   └───┴───┴───┴───┘ └───┴───┴───┴───┘ └───┴───┴───┴───┘ └───┴───┴───┘  └┘    └┘    └┘
 * ┌───┬───┬───┬───┬───┬───┬───┬───┬───┬───┬───┬───┬───┬───────┐ ┌───┬───┬───┐ ┌───┬───┬───┬───┐
 * │~ `│! 1│@ 2│# 3│$ 4│% 5│^ 6│& 7│* 8│( 9│) 0│_ -│+ =│ BacSp │ │Ins│Hom│PUp│ │N L│ / │ * │ - │
 * ├───┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─────┤ ├───┼───┼───┤ ├───┼───┼───┼───┤
 * │ Tab │ Q │ W │ E │ R │ T │ Y │ U │ I │ O │ P │{ [│} ]│ | \ │ │Del│End│PDn│ │ 7 │ 8 │ 9 │   │
 * ├─────┴┬──┴┬──┴┬──┴┬──┴┬──┴┬──┴┬──┴┬──┴┬──┴┬──┴┬──┴┬──┴─────┤ └───┴───┴───┘ ├───┼───┼───┤ + │
 * │ Caps │ A │ S │ D │ F │ G │ H │ J │ K │ L │: ;│" '│ Enter  │               │ 4 │ 5 │ 6 │   │
 * ├──────┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴─┬─┴────────┤     ┌───┐     ├───┼───┼───┼───┤
 * │ Shift  │ Z │ X │ C │ V │ B │ N │ M │< ,│> .│? /│  Shift   │     │ ↑ │     │ 1 │ 2 │ 3 │   │
 * ├─────┬──┴─┬─┴──┬┴───┴───┴───┴───┴───┴──┬┴───┼───┴┬────┬────┤ ┌───┼───┼───┐ ├───┴───┼───┤ E││
 * │ Ctrl│    │Alt │         Space         │ Alt│    │    │Ctrl│ │ ← │ ↓ │ → │ │   0   │ . │←─┘│
 * └─────┴────┴────┴───────────────────────┴────┴────┴────┴────┘ └───┴───┴───┘ └───────┴───┴───┘
 **/

namespace App\Handlers;


use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Str;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler
{
    /**
     * @Inject()
     * @var Pinyin
     */
    public $pinyin;

    /**
     * @Inject()
     * @var ClientFactory
     */
    public $clientFactory;

    public function translate($text)
    {
        $key    = config('services.baidu_translate.key');
        $appId  = config('services.baidu_translate.appid');
        $apiUrl = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
        $salt   = time();

        if ( empty($appId) || empty($key) ) {
            return var_dump($this->pinyinConvert($text));
        }

        $sign = md5($appId . $text . $salt . $key);

        // 构建请求参数
        $query = http_build_query([
            "q"     => $text,
            "from"  => "zh",
            "to"    => "en",
            "appid" => $appId,
            "salt"  => $salt,
            "sign"  => $sign,
        ]);

        // $options 等同于 GuzzleHttp\Client 构造函数的 $config 参数
        $options = [];
        // $client 为协程化的 GuzzleHttp\Client 对象
        $this->clientFactory = ApplicationContext::getContainer()->get(ClientFactory::class);

        $client   = $this->clientFactory->create($options);
        $response = $client->get($apiUrl . $query);
        $result   = json_decode($response->getBody(), true);

        // 获取百度翻译数据
        if ( isset($result['trans_result'][0]['dst']) ) {
            return Str::slug($result['trans_result'][0]['dst']);
        } else {
            // 如果百度翻译没有结果，使用拼音作为后备计划。
            return $this->pinyinConvert($text);
        }
    }

    /**
     * 汉字转拼音
     * @param $text
     * @return string
     */
    public function pinyinConvert($text)
    {
        return Str::slug($this->pinyin->permalink($text));
    }
}
