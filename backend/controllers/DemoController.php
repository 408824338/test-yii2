<?php

namespace backend\controllers;

use backend\components\MyBehavior;
use backend\components\MyBehavior2;
use Yii;
use backend\models\BankCard;
use backend\models\BankCardSearch;
use yii\base\Component;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BankCardController implements the CRUD actions for BankCard model.
 */
class DemoController extends Controller {

    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['POST'],
//                ],
//            ],
//        ];
//    }

    public function behaviors() {
        return [
           'myBehavior' => \backend\components\MyBehavior::className(),
            myBehavior2::className(),
            // 命名行为，只有行为类名
            //'myBehavior2'=>\backend\components\MyBehavior2::className(),
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                     'delete' => ['POST'],
                  ],
             ],
        ];
    }

    /**
     * Lists all BankCard models.
     * @return mixed
     */
    public function actionIndex() {
        //使用附加行为
       $myBehavior =  $this->getBehavior('myBehavior');
       $isGuest = $myBehavior->isGuest();
       var_dump($isGuest);
        echo 'this is index';
        exit;
    }

    /**
     * Displays a single BankCard model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
        'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BankCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new BankCard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
            'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BankCard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
            'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BankCard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BankCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BankCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = BankCard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
