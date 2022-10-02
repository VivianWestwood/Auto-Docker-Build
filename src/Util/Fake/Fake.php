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

namespace Bhp\Util\Fake;

class Fake
{
    /**
     * 生成UUID
     * @return string
     */
    public static function uuid(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * 生成uuid4
     * @return string
     */
    public static function uuid4(): string
    {
        // 标准的UUID格式为：xxxxxxxx-xxxx-xxxx-xxxxxx-xxxxxxxxxx(8-4-4-4-12)
        // var T = "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function(t) {
        //     var e = 16 * Math.random() | 0;
        //     return ("x" === t ? e : 3 & e | 8).toString(16)
        // });
        $chars = md5(uniqid((string)mt_rand(), true));
        $chars = substr_replace($chars, "4", 12, 1);
        $chars = substr_replace($chars, "a", 16, 1);
        return substr($chars, 0, 8) . '-'
            . substr($chars, 8, 4) . '-'
            . substr($chars, 12, 4) . '-'
            . substr($chars, 16, 4) . '-'
            . substr($chars, 20, 12);
    }

    /**
     * 生成hash
     * @return string
     */
    public static function hash(): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()+-';
        $random = $chars[mt_rand(0, 73)] . $chars[mt_rand(0, 73)] . $chars[mt_rand(0, 73)] . $chars[mt_rand(0, 73)] . $chars[mt_rand(0, 73)];//Random 5 times
        $content = uniqid() . $random;  // 类似 5443e09c27bf4aB4uT
        return md5($content); // sha1
    }

    /**
     * 生成BUVID
     * @return string
     */
    public static function buvid(): string
    {
        // XW UUID
        // XX AndroidID
        // XY MAC
        // XZ IMEI
        // XYD5B85DA7212341F51C612344A6B8C6C21234
        $mac = Faker::macAddress();
        $md5 = md5($mac);
        $md5_arr = str_split($md5);
        return strtoupper("XY$md5_arr[2]$md5_arr[12]$md5_arr[22]$md5");
    }

    /**
     * 获取颜文字信息
     * @return string
     */
    public static function emoji(): string
    {
        $emoji_list_all = [
            "(⌒▽⌒)", "（￣▽￣）", "(=・ω・=)", "(｀・ω・´)", "(〜￣△￣)〜", "(･∀･)",
            "(°∀°)ﾉ", "(￣3￣)", "╮(￣▽￣)╭", "_(:3」∠)_", "( ´_ゝ｀)", "←_←", "→_→",
            "(<_<)", "(>_>)", "(;¬_¬)", '("▔□▔)/', "(ﾟДﾟ≡ﾟдﾟ)!?", "Σ(ﾟдﾟ;)", "Σ( ￣□￣||)",
            "(´；ω；`)", "（/TДT)/", "(^・ω・^ )", "(｡･ω･｡)", "(●￣(ｴ)￣●)", "ε=ε=(ノ≧∇≦)ノ",
            "(´･_･`)", "(-_-#)", "（￣へ￣）", "(￣ε(#￣) Σ", "ヽ(`Д´)ﾉ", "（#-_-)┯━┯",
            "(╯°口°)╯(┴—┴", "←◡←", "( ♥д♥)", "Σ>―(〃°ω°〃)♡→", "⁄(⁄ ⁄•⁄ω⁄•⁄ ⁄)⁄",
            "(╬ﾟдﾟ)▄︻┻┳═一", "･*･:≡(　ε:)", "(打卡)", "(签到)"
        ];
        $emoji_list = [
            "(⌒▽⌒)", "（￣▽￣）", "(=・ω・=)", "(｀・ω・´)", "(〜￣△￣)〜",
            "╮(￣▽￣)╭", "_(:3」∠)_", "( ´_ゝ｀)", "(●￣(ｴ)￣●)", "(･∀･)",
            "(´･_･`)", "（￣へ￣）", "(打卡)", "(签到)"
        ];
        shuffle($emoji_list);
        return $emoji_list[array_rand($emoji_list)];
    }

}