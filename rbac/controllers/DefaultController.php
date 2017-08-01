<?php
/**
 * Class DefaultController
 */

namespace rbac\controllers;

use app\controllers\common\BaseController;

class DefaultController extends  BaseController {
	//我才是默认首页
	public function actionIndex(){
		return $this->render("index");
	}
}