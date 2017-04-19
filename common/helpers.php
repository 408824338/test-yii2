<?php
/**
 * Yii2 Shortcuts
 * @author Eugene Terentev <eugene@terentev.net>
 * -----
 * This file is just an example and a place where you can add your own shortcuts,
 * it doesn't pretend to be a full list of available possibilities
 * -----
 */

/**
 * @return int|string
 */
function getMyId()
{
    return Yii::$app->user->getId();
}

/**
 * @param string $view
 * @param array $params
 * @return string
 */
function render($view, $params = [])
{
    return Yii::$app->controller->render($view, $params);
}

/**
 * @param $url
 * @param int $statusCode
 * @return \yii\web\Response
 */
function redirect($url, $statusCode = 302)
{
    return Yii::$app->controller->redirect($url, $statusCode);
}

/**
 * @param $form \yii\widgets\ActiveForm
 * @param $model
 * @param $attribute
 * @param array $inputOptions
 * @param array $fieldOptions
 * @return string
 */
function activeTextinput($form, $model, $attribute, $inputOptions = [], $fieldOptions = [])
{
    return $form->field($model, $attribute, $fieldOptions)->textInput($inputOptions);
}

/**
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function env($key, $default = false) {

    $value = getenv($key);

    if ($value === false) {
        return $default;
    }

    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;

        case 'false':
        case '(false)':
            return false;
    }

    return $value;
}

//打印输出
function pt($data, $is_die = true) {
    echo "<pre>";
    print_r($data);
    if ($is_die) {
        exit;
    }
}

//打印输出
function dp($data, $is_die = true) {
    echo "<pre>";
    var_dump($data);
    if ($is_die) {
        exit;
    }
}

/**
 *  字符串截取，单字节截取模式
 *
 * @param     string		$str  需要截取的字符串
 * @param     int			$length  截取的长度
 * @param     int			$start  开始截取的位置
 * @param     boole			$omission  是否要在后面加上省略号， false:不加  true:加
 * @return    string
 */
function cn_substr_utf8($str, $length, $start = 0, $omission = false) {
    //判断变量是否为空
    if (strlen($str) < $start + 1) {
        return '';
    }
    preg_match_all("/./su", $str, $ar);
    $str = '';
    $tstr = '';
    //为了兼容mysql4.1以下版本,与数据库varchar一致,这里使用按字节截取
    for ($i = 0; isset($ar[0][$i]); $i++) {
        //这里是把起始位置之前的字段过滤掉
        if (strlen($tstr) < $start) {
            $tstr .= $ar[0][$i];
        } else {
            //strlen($ar[0][$i] 如果是中文就3个字符，如果是别的就1个字符
            if (strlen($str) <= $length && $length - strlen($str) >= strlen($ar[0][$i])) {
                $str .= $ar[0][$i];
            } else {
                break;
            }
        }
    }
    if (strlen($str) > $length && $omission) {
        $str .= '...';
    }
    return $str;
}

/**
 *  用于生成随机的数字和字母组合
 * @Param $len 生成长度
 * @Param $is_strtoupper   是否转换成大写
 * @Param $chars   			     自定义随机字符串
 * @Return string
 */
function randStr($len, $is_strtoupper = false, $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    $string = '';
    for (; $len >= 1; $len--) {
        $position = rand() % strlen($chars);
        $string .= substr($chars, $position, 1);
    }

    if ($is_strtoupper) {
        strtoupper($string);
    }
    return $string;
}


/**
 * 随机数字数字
 * @param type $num
 * @return string
 * @author  cmk
 */
function getRangNUm($num) {
    $arr = array();
    while (count($arr) < $num - 1) {
        $arr[] = rand(1, $num);
        $arr = array_unique($arr);

    }
    return  implode("",$arr);;
}

//把数组(可多维)中值null转为 ''
function convert_null_to_empty(&$arrdata){
    if (empty($arrdata)) {
        return '';
    }
    $configope =function(&$item,$key){
        if (is_array($item)) {
            convert_null_to_empty($item);
        }
        if(is_null($item)){
            $item ='';
        }
        return $item;
    };
    array_walk($arrdata, $configope);
    return $arrdata;
}


/**
 * 有效期
 * @param unknown $end_time   订单结束时间
 * @return number
 */
function timedifforder($end_time){
    $beg_time = time();
    $timediff = $end_time- $beg_time;
    if($timediff <= 0){
        return 0;
    }
    $days = intval($timediff/86400)+1;
    return $days;
}

//验证手机号码
function is_mobile($mobile) {
    $pattern = '/^1(?:3[0-9]|4[0-9]|5[0-9]|8[0-9]|7[0678])\d{8}$/';
    $is_mobile = (bool) preg_match($pattern, $mobile);
    return $is_mobile;
}

/**
 * 导出excel封装方法
 * @param $title      表格名称
 * @param $headNames  表格头部列名称
 * @param $data       表格数据（二维数组）
 * @param $mode       1:浏览器输出模式    2：文件保存但不输出模式
 * @param $path       文件名称  包含：文件保存的路径，必须是绝对路径     例如：    d:\myword\index.html   格式
 */
function exportExcel($title,$headNames,$data,$mode=1,$path=''){
    $maxColumn = array('A','B','C','D','E','F','G','H','I','J','K','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    $objPHPExcel = new \PHPExcel();
    $objSheet=$objPHPExcel->getActiveSheet();//获取当前活动sheet
    $objSheet->setTitle($title);//给当前活动sheet起个名称
    $headStyle = array();
    $columnSizes =  array();

    for($i = 0;$i< count($headNames);$i++){
        $objSheet->setCellValue($maxColumn[$i].'1',$headNames[$i]);
        $headStyle[$i] = $maxColumn[$i].'1';
        $columnSizes[$i] = $maxColumn[$i];
    }
    $styleArray1 = array(
        'font' => array('bold' => true,'size'=>12, 'color'=>array('argb' => '00000000'),),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
    );
    foreach($headStyle as $val){
        $column = substr($val,0,1);
        $objSheet->getColumnDimension($column)->setWidth(20);
        $objSheet->getStyle($val)->applyFromArray($styleArray1);
    }
    $j=2;

    foreach($data as $dVal){
        $i = 0;
        foreach($dVal as $val){
            for($i;$i<$columnSizes;){
                $objSheet->setCellValue($columnSizes[$i].$j,' '."".$val);
                $objSheet->getStyle($columnSizes[$i].$j)->getAlignment()->setWrapText(true);
                break;
            }
            $i++;
        }

        $j++;
    }
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');//生成excel文件

    if ($mode == 1) {
        browser_export('Excel5',$title.'.xls');//输出到浏览器
        $objWriter->save('php://output');
    } elseif ($mode == 2) {
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path));
        }
        $objWriter->save($path);
    }
}

function browser_export($type,$filename){
    if($type=="Excel5"){
        header('Content-Type: application/vnd.ms-excel');//告诉浏览器将要输出excel03文件
    }else{
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//告诉浏览器数据excel07文件
    }
    header('Content-Disposition: attachment;filename="'.$filename.'"');//告诉浏览器将输出文件的名称
    header('Cache-Control: max-age=0');//禁止缓存
}


function get_person_html5_shop_url($company_id, $user_id) {
    $url = env('PERSON_HTML5_SHOP_URL');
    if (empty($url)) {
        $url = 'http://m.vding.wang';
    }
    return sprintf(trim($url, '/'). '/%d/%d', $company_id, $user_id);
}


/**
 * @Description 身份证号验证
 * @Param $id_card string 身份证号码字符串
 * @Return bool TRUE 通过  FALSE 不通过
 */
function validate_id_card($id_card) {
    if(strlen($id_card) == 18) {
        return idcard_checksum18($id_card);
    } elseif((strlen($id_card) == 15)) {
        $id_card = idcard_15to18($id_card);
        return idcard_checksum18($id_card);
    }else{
        return FALSE;
    }
}

// 将15位身份证升级到18位
function idcard_15to18($idcard){
    if (strlen($idcard) != 15){
        return false;
    }else{
        // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
        if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false){
            $idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9);
        }else{
            $idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9);
        }
    }
    $idcard = $idcard . _idcard_verify_number($idcard);
    return $idcard;
}

// 18位身份证校验码有效性检查
function idcard_checksum18($idcard){
    if (strlen($idcard) != 18){ return false; }
    $idcard_base = substr($idcard, 0, 17);
    if (_idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))){
        return false;
    }else{
        return true;
    }
}

/**
 * 计算身份证校验码，根据国家标准GB 11643-1999
 * 主要用于内部调用
 * @param $idcard_base
 * @return bool | string
 */
function _idcard_verify_number($idcard_base) {
    if(strlen($idcard_base) != 17) {
        return FALSE;
    }
    //加权因子
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    //校验码对应值
    $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
    $checksum = 0;
    for ($i = 0; $i < strlen($idcard_base); $i++) {
        $checksum += substr($idcard_base, $i, 1) * $factor[$i];
    }
    $mod = $checksum % 11;
    $verify_number = $verify_number_list[$mod];
    return $verify_number;
}