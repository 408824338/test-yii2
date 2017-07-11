<?php
namespace rbac\controllers;

use ihacklog\sms\models\Sms;
use Yii;
use frontend\models\ContactForm;
use yii\web\Controller;

/**
 * Site controller
 */
class DemoMoniPostController extends Controller {
    /**
     * 描述操作
     * ysk.dev/demo-moni-post/file
     */
    public $enableCsrfValidation = false;

    public function actionFile() {
        try {


            $postData = [
                'Procduct[procduct_category_id]' => '3',
                'Procduct[name]' => "2",
                'Procduct[amount]' => "手套4",
                'Procduct[price]' => "100",
                'Procduct[status]' => "1",
                'Procduct[memo]' => "456",
            ];
            //$_postData = http_build_query($postData);
            $_postData = '_csrf=amZhWHpWVFgcUlg8D2YmOgNVN2wYAGFvKyo4AB0kOGo%2FDT48MzwdYA%3D%3D&Procduct%5Bprocduct_category_id%5D=3&Procduct%5Bname%5D=334&Procduct%5Bamount%5D=4&Procduct%5Bprice%5D=555&Procduct%5Bstatus%5D=1&Procduct%5Bmemo%5D=44444';
            //echo $_postData;exit;
            $ops = [
                'http' => [
                    'method' => 'POST',
                    'header' => "Host:ysk.dev\r\n" .
                        "Content-type:application/x-www-form-urlencoded\r\n" .
                        "Content-length:" . strlen($_postData) . "\r\n" .
                        'Cookie: PHPSESSID=tfcvaa7k4q5p8bagls9o26ns84; _csrf=59c8dc255bfe44d7491b81a2f4f21eabb69e0f7377b3ee6554c3c2eb264f90c7a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22v49du0rbi3V4bV57ALYXgrl2Uk_dIjI8%22%3B%7D; _identity=de2fee6d386abe54c94f12d247882ad20c5af5c51818d6203daf1eea33996b35a%3A2%3A%7Bi%3A0%3Bs%3A9%3A%22_identity%22%3Bi%3A1%3Bs%3A46%3A%22%5B1%2C%220LNlTfPHgBoQ_iwpMT0D2ke-vrvj2_gS%22%2C2592000%5D%22%3B%7D',
                    'content' => $postData,
                ],
            ];

            $context = stream_context_create($ops);

            //  $fp = file_get_contents("http://ysk.dev/admin/procduct/create", false, $context);
            //dp($fp);
            $fp = fopen("http://ysk.dev/admin/procduct/create", 'r', false, $context);
            dp($fp);
            fclose($fp);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function actionFile2() {

        $opts = [
            'http' => [
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                    "Cookie: foo=bar\r\n",
            ],
        ];

        $context = stream_context_create($opts);

        /* Sends an http request to www.example.com
           with additional headers shown above */
        $fp = fopen('http://api.t.vding.wang/v1/service/order/order-cancel?cus_order_no=1705180318112784&oper_name=王丹&access-token=050AD15BF8E9822C1C0272851D519317E25DEB5D89FA500315304F200A8FFA9CA3DBA5F73BB49AD706C21484CA2971E67E164E55FE1849E2825774A6D9C6E4B7D33B66DB22BAAB778D896F060B4970D8EEBFA442E5AEB9904F2CFAE7756659781EA678EF4D06FF6AFBE1EA293F067FA457FD26F21BA45B985AED11633CE14D54', 'r', false, $context);
        fpassthru($fp);
        fclose($fp);
    }


    public function actionCurl() {

        $postData = [
            'Procduct[procduct_category_id]' => '3',
            'Procduct[name]' => "手套4",
            'Procduct[amount]' => "30000",
            'Procduct[price]' => "100",
            'Procduct[status]' => "1",
            'Procduct[memo]' => "456",
            'Procduct[_csrf]' => "WWNraUlneFcvV1INPFcKNTBQPV0rMU1gGC8yMS4VFGUMCDQNAA0xbw==",
        ];
        $url = 'http://ysk.dev/admin/procduct/create';

        $cookie = 'PHPSESSID=tfcvaa7k4q5p8bagls9o26ns84; _csrf=59c8dc255bfe44d7491b81a2f4f21eabb69e0f7377b3ee6554c3c2eb264f90c7a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22v49du0rbi3V4bV57ALYXgrl2Uk_dIjI8%22%3B%7D; _identity=de2fee6d386abe54c94f12d247882ad20c5af5c51818d6203daf1eea33996b35a%3A2%3A%7Bi%3A0%3Bs%3A9%3A%22_identity%22%3Bi%3A1%3Bs%3A46%3A%22%5B1%2C%220LNlTfPHgBoQ_iwpMT0D2ke-vrvj2_gS%22%2C2592000%5D%22%3B%7D';
        //初始化一个curl会话
        $ch = curl_init();

        //设置提交的网址
        curl_setopt($ch, CURLOPT_URL, $url);

        //设置数据提交方式
        curl_setopt($ch, CURLOPT_POST, 1);

        //设置数据提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        //设置cookie
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);

        //设置来源
        // curl_setopt($ch,CURLOPT_REFERER,'http://ysk.dev/admin/procduct/create');

        //提交成功之后,把数据返回为字符串
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        curl_close($ch);

        echo $output;
    }
}
