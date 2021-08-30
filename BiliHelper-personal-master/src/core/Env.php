<?php

/**
 *  Website: https://mudew.com/
 *  Author: Lkeme
 *  License: The MIT License
 *  Email: Useri@live.cn
 *  Updated: 2021 ~ 2022
 */

namespace BiliHelper\Core;

use Noodlehaus\Config;

class Env
{
    private string $app_name;
    private string $app_version;
    private string $app_branch;
    private string $app_source;

    private string $repository = APP_DATA_PATH . 'latest_version.json';


    /**
     * Env constructor.
     */
    public function __construct()
    {
        set_time_limit(0);
        header("Content-Type:text/html; charset=utf-8");
        // ini_set('date.timezone', 'Asia/Shanghai');
        date_default_timezone_set('Asia/Shanghai');
        ini_set('display_errors', 'on');
        error_reporting(E_ALL);

        $this->loadJsonData();
    }

    /**
     * @use 检查扩展
     */
    public function inspect_extension()
    {
        $default_extensions = ['curl', 'openssl', 'sockets', 'json', 'zlib', 'mbstring'];
        foreach ($default_extensions as $extension) {
            if (!extension_loaded($extension)) {
                Log::error("检查到项目依赖 $extension 扩展未加载。");
                Log::error("请在 php.ini中启用 $extension 扩展后重试。");
                Log::error("程序常见问题请移步 $this->app_source 文档部分查看。");
                exit();
            }
        }
    }

    /**
     * @use 检查环境
     */
    public function inspect_configure(): Env
    {
        Log::info("欢迎使用 项目: $this->app_name@$this->app_branch 版本: $this->app_version");
        Log::info("使用说明请移步 $this->app_source 查看");

        if (PHP_SAPI != 'cli') {
            die("Please run this script from command line .");
        }
//        if (version_compare(PHP_VERSION, '7.4.0', '<')) {
//            die("Please upgrade PHP version > 7.4.0 .");
//        }
        if (version_compare(PHP_VERSION, '8.0.0', '<')) {
            die("Please upgrade PHP version < 8.0.0 .");
        }
        return $this;
    }

    /**
     * @use 加载本地JSON DATA
     */
    private function loadJsonData()
    {
        $conf = new Config($this->repository);
        $this->app_name = $conf->get('project');
        $this->app_version = $conf->get('version');
        $this->app_branch = $conf->get('branch');
        $this->app_source = $conf->get('source');
    }
}
