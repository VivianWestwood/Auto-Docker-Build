<?php declare(strict_types=1);

/**
 *  Website: https://mudew.com/
 *  Author: Lkeme
 *  License: The MIT License
 *  Email: Useri@live.cn
 *  Updated: 2022 ~ 2023
 *
 *   _____   _   _       _   _   _   _____   _       _____   _____   _____
 *  |  _  \ | | | |     | | | | | | | ____| | |     |  _  \ | ____| |  _  \ &   ／l、
 *  | |_| | | | | |     | | | |_| | | |__   | |     | |_| | | |__   | |_| |   （ﾟ､ ｡ ７
 *  |  _  { | | | |     | | |  _  | |  __|  | |     |  ___/ |  __|  |  _  /  　 \、ﾞ ~ヽ   *
 *  | |_| | | | | |___  | | | | | | | |___  | |___  | |     | |___  | | \ \   　じしf_, )ノ
 *  |_____/ |_| |_____| |_| |_| |_| |_____| |_____| |_|     |_____| |_|  \_\
 */

namespace Bhp\Api\Api\Pgc\Activity\Score;

use Bhp\Request\Request;
use Bhp\Sign\Sign;
use Bhp\User\User;

class ApiTask
{
    /**
     * @var array|string[]
     */
    protected static array $headers = [
        'Referer' => 'https://big.bilibili.com/mobile/bigPoint/task'
    ];

    /**
     * @var array|string[]
     */
    protected static array $payload = [
        'statistics' => '{"appId":1,"platform":3,"version":"6.86.0","abtest":""}',
    ];

    /**
     * 大会员签到
     * @return array
     */
    public static function sign(): array
    {
        //
        $user = User::parseCookie();
        //
        $url = 'https://api.bilibili.com/pgc/activity/score/task/sign';
        $payload = array_merge([
            'disable_rcmd' => '0',
            'csrf' => $user['csrf'],
        ], self::$payload);
        $headers = array_merge([], self::$headers);
        return Request::postJson(true, 'app', $url, Sign::common($payload), $headers);
    }

    /**
     * 领取任务
     * @param string $task_code
     * @return array
     */
    public static function receive(string $task_code): array
    {
        //
        $user = User::parseCookie();
        //
        $url = 'https://api.bilibili.com/pgc/activity/score/task/receive';
        $payload = array_merge([
            'taskCode' => $task_code,
            'csrf' => $user['csrf'],
        ], self::$payload);
        $headers = array_merge([], self::$headers);
        return Request::putJson(true, 'app', $url, Sign::common($payload), $headers);
    }

    /**
     * 完成任务
     * @param string $task_code
     * @return array
     */
    public static function complete(string $task_code): array
    {
        //
        $user = User::parseCookie();
        //
        $url = 'https://api.bilibili.com/pgc/activity/score/task/complete';
        $payload = array_merge([
            'taskCode' => $task_code,
            'csrf' => $user['csrf'],
            'ts' => time(),
        ], self::$payload);
        $headers = array_merge([
            'Content-Type' => 'application/json'
        ], self::$headers);
        return Request::putJson(true, 'app', $url, Sign::common($payload), $headers);
    }


}
