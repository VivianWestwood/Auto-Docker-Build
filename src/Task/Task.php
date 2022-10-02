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

namespace Bhp\Task;

use Amp\Loop;
use Bhp\Log\Log;
use Bhp\Plugin\Plugin;
use Bhp\Schedule\Schedule;
use Bhp\TimeLock\TimeLock;
use Bhp\Util\DesignPattern\SingleTon;
use Bhp\Util\Exceptions\NoLoginException;
use Throwable;
use function Amp\asyncCall;

class Task extends SingleTon
{
    /**
     * @return void
     */
    public function init(): void
    {

    }

    /**
     * @param string $hook
     * @param mixed $data
     * @return void
     */
    public static function addTask(string $hook, mixed ...$data): void
    {
        asyncCall(function () use ($hook, $data) {
            while (true) {
                try {
                    Plugin::getInstance()->trigger($hook, ...$data);
                } catch (NoLoginException $e) {
                    Schedule::restore();
                    $error_msg = "MSG: {$e->getMessage()} CODE: {$e->getCode()} FILE: {$e->getFile()} LINE: {$e->getLine()}";
                    Log::error($error_msg);
                    failExit('触发未登录错误，请重新登录哦~');
                } catch (Throwable  $e) {
                    // TODO 多次错误删除tasks_***.json文件
                    $error_msg = "MSG: {$e->getMessage()} CODE: {$e->getCode()} FILE: {$e->getFile()} LINE: {$e->getLine()}";
                    Log::error($error_msg);
                    // Notice::push('error', $error_msg);
                }
                yield TimeLock::Delayed();
            }
        });
    }

    /**
     * @return void
     */
    public static function execTasks(): void
    {
        Loop::run();
    }
}

