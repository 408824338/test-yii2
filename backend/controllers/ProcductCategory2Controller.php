<?php

namespace backend\controllers;

use Yii;
use common\models\ProcductCategory;
use common\models\ProcductCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * ProcductCategoryController implements the CRUD actions for ProcductCategory model.
 */
class ProcductCategory2Controller extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProcductCategory models.
     * @return mixed
     */
    public function actionIndex() {

        //1.定义
        $model = ProcductCategory::find();
        $all = $model->asArray()->all();
        $rows = ProcductCategory::get(0, $all); //产品分类 - 递归输出 

        return $this->render('index', [
                    'rows' => $rows,
        ]);
    }

    /**
     * Displays a single ProcductCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProcductCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ProcductCategory();
        $list = $model->getOptions();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
                        'list' => $list
            ]);
        }
    }

    /**
     * Updates an existing ProcductCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $list = $model->getOptions();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'list' => $list,
            ]);
        }
    }

    /**
     * Deletes an existing ProcductCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProcductCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProcductCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ProcductCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 批量删除
     * @return type
     */
    public function actionDeleteAll() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isGet) {
            $gets = Yii::$app->request->get();
            $delete_id = $gets['delete_id'];
//          echo $delete_id;exit;
//            $_update = ProcductCategory::updateAll(['is_delete' => 1], 'id in (:_delete_id)', [':_delete_id' => $delete_id]);
            $_update = ProcductCategory::updateAll(['is_delete' => 1], 'id in (' . $delete_id . ')');
            if ($_update) {
                return ['status' => 1, 'meg' => '删除成功'];
            } else {
                return ['status' => 0, 'meg' => '删除失败'];
            }
        }
    }

}
