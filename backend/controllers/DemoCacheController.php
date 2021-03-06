<?php
/**
 * Created by PhpStorm.
 * User: cmk
 * Date: 2017/2/25
 * Time: 20:42
 */

namespace backend\controllers;


use yii\caching\DbDependency;
use yii\caching\ExpressionDependency;
use yii\filters\PageCache;
use yii\web\Controller;

class DemoCacheController extends Controller {

    public $cache;

    public function behaviors() {
        return [
            [
                /**
                 * httpcahe要缓存更新两个要素
                 * lastModified 控制文件时间
                 * etagSeed 控制文件内容
                 *  上面两个同时改变的话，缓存才清空
                 */
                'class' => 'yii\filters\HttpCache',
                'lastModified' => function () {
                    return filemtime('hw.txt');
                },
                'etagSeed' => function () {
                    $fp = fopen('hw.txt', 'r');
                    $title = fgets($fp);
                    fclose($fp);
                    return $title;
                },
            ],
        ];
    }

    /**
     * http://ysk.dev/admin/demo-cache/profile
     * 检查区间的性能,如耗时多少秒
     * @author cmk
     */
    public function actionProfile() {
        \Yii::beginProfile('profile1');
        echo 'aaaabbbbccc';
        sleep(1);
        \Yii::endProfile('profile1');
        exit;
    }


    /**
     * http://ysk.dev/admin/demo-cache/http-cache
     * 使用behavior定义,使用httpCache缓存，lastModified与etagSeed 同时变化，缓存才清空
     * @author cmk
     */
    public function actionHttpCache() {
        $content = file_get_contents('hw.txt');
        return $this->renderPartial('http-cache', ['content' => $content]);
    }

    /**
     * http://ysk.dev/admin/demo-cache/page-cache
     * 使用behavior进行全局缓存
     * @author cmk
     */
    public function actionPageCache() {
        echo 'abc';
    }

    public function init() {
        parent::init(); // TODO: Change the autogenerated stub
        $this->cache = \Yii::$app->cache;
    }


    public function actionIndex() {
        $id = 456;
        $cache_key = md5('cache' . $id);
        if (!$data = $this->cache->get($cache_key)) {
            $str = 'hello world2332!';
            $res = $this->cache->set($cache_key, $str);
            if ($res) {
                $data = $str;
            }
        }
        echo $data;
    }

    /**
     * http://ysk.dev/admin/demo-cache/cache1
     * 缓存简单的读取与保存,没有设置时间
     * @author cmk
     */
    public function actionCache1() {
        $id = 456;
        $cache_key = md5('cache' . $id);
        if (!$data = $this->cache->get($cache_key)) {
            $str = 'hello world2332!';
            $res = $this->cache->set($cache_key, $str);
            if ($res) {
                $data = $str;
            }
        }
        echo $data;
    }

    /**
     * http://ysk.dev/admin/demo-cache/cache2
     * 缓存简单的读取与保存,增加缓存时间
     * @author cmk
     */
    public function actionCache2() {
        $id = 456;
        $cache_key = md5('cache' . $id);
        if (!$data = $this->cache->get($cache_key)) {
            $str = 'hello world23322222!';
            $res = $this->cache->set($cache_key, $str, 10);
            if ($res) {
                $data = $str;
            }
        }
        echo $data;
    }

    /**http://ysk.dev/admin/demo-cache/file-dep
     * 文件依赖,缓存有期时间内,如果/web/h2.txt 文件的时候有变化,则缓存马上失效
     *  条件:在当前应用下 /web/目录/建立一个文件 如 hw.txt文件,只要这个文件的时间一变,则该缓存就失败
     * @author cmk
     */
    public function actionFileDep() {
        $id = 456;
        $cache_key = md5('cache' . $id);
        $dependency = new FileDependency(['fileName' => 'hw.txt']);
        if (!$data = $this->cache->get($cache_key)) {
            $str = 'hello aaaa!';
            $res = $this->cache->set($cache_key, $str, 3000, $dependency);
            if ($res) {
                $data = $str;
            }
        }
        echo $data;
    }

    /**http://ysk.dev/admin/demo-cache/reg-dep?name=123
     * 表达式依赖: 当参数name改变的时候,缓存马上清空
     * @author cmk
     */
    public function actionRegDep() {
        $id = 456;
        $cache_key = md5('cache' . $id);

        $dependency = new ExpressionDependency(['expression' => ' \Yii::$app->request->get("name")']);
        if (!$data = $this->cache->get($cache_key)) {
            $str = 'hello aaaabbbb!';
            $res = $this->cache->set($cache_key, $str, 3000, $dependency);
            if ($res) {
                $data = $str;
            }
        }
        echo $data;
    }

    /**http://ysk.dev/admin/demo-cache/db-dep
     * DB依赖: 绑定的数据库表里有变化,缓存才会清除
     * @author cmk
     */
    public function actionDbDep() {
        $id = 456;
        $cache_key = md5('cache' . $id);

        $dependency = new DbDependency(['sql' => 'select count(*) from system_log']);
        if (!$data = $this->cache->get($cache_key)) {
            $str = 'hello aaaabbbbccc!';
            $res = $this->cache->set($cache_key, $str, 3000, $dependency);
            if ($res) {
                $data = $str;
            }
        }
        echo $data;
    }

    /**
     * http://ysk.dev/admin/demo-cache/flush
     * 清除缓存
     * @author cmk
     */
    public function actionFlush() {
        $res = $this->cache->flush();
        if ($res) {
            echo '成功清除';
        } else {
            echo '清除失败';
        }
    }

    /**
     * http://ysk.dev/admin/demo-cache/view-cache
     * 清除缓存
     * @author cmk
     */
    public function actionViewCache() {
        return $this->renderPartial('view-cache');
    }

}
