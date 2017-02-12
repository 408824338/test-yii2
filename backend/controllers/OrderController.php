<?php

namespace backend\controllers;

use Yii;
use common\models\Order;
use backend\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Account;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller {

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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
//        $sql = "SELECT	procduct.name,order_detail.product_price,order_detail.product_amount,order.is_fahuo  FROM order_detail";
//        $sql .= " left join `order` on order.id = order_detail.order_id ";
//        $sql .= " LEFT JOIN procduct ON procduct.id = order_detail.produce_id WHERE order_detail.order_id = $id ";
//
//        $result = Yii::$app->db->createCommand($sql)->queryAll();
        $result = Order::getOrderDetailByOrderId($id);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'lists' => $result,
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
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
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 确认发货
     */
    public function actionConfirm() {
        if (Yii::$app->getRequest()->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $order_id = Yii::$app->getRequest()->post('order_id');

                //1.1 查出是否有足够的金额扣款
                $account_row = Order::getAccountInfoByOrderID($order_id);
//                var_dump($account_row);
//                exit;
                if ($account_row['is_fahuo'] == 1) {
                    throw new \Exception('已经发货啦');
                }

                //2.1状态更新 修改为 '确认发货'
                $order_upder = Order::updateAll(['is_fahuo' => 1], 'id=:_order_id', [':_order_id' => $order_id]);

                if ($account_row['balance'] < $account_row['price']) {
                    throw new \Exception('用户没有足够金额');
                }
                //2.2将用户冻结的金额解栋,并扣出金额
                $_balance = $account_row['balance'] - $account_row['price'];
                $account_update = Account::updateAll(['balance' => $_balance,'frozen'=>0], ['user_id' => $account_row['user_id']]);
                if (!$account_update) {
                    throw new \Exception('扣款金额失败!');
                }
                $transaction->commit();
                $this->redirect('index');
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('info', $e->getMessage());
                $this->redirect('view?id=' . $order_id);
            }
        } else {
            $this->redirect('index');
        }
    }

}
