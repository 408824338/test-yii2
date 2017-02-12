<?php

namespace frontend\controllers;

use common\models\Procduct;
use common\models\ProcductSearch;
use common\models\Cart;
use common\models\Order;
use common\models\OrderDetail;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\Account;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ShopController extends Controller {

    public $user_id;

    public function actions() {
        parent::actions();
        $this->user_id = Yii::$app->user->id;
    }

    /**
     * @return string
     */
    public function actionIndex() {
        $searchModel = new ProcductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($detail_id) {
        $model = Procduct::find()->andWhere(['id' => $detail_id])->one();
        if (!$model) {
            throw new NotFoundHttpException;
        }
        return $this->render('view', ['model' => $model]);
    }

    /**
     * @param $id
     * @return $this
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionAttachmentDownload($id) {
        $model = ArticleAttachment::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException;
        }

        return Yii::$app->response->sendStreamAsFile(
                        Yii::$app->fileStorage->getFilesystem()->readStream($model->path), $model->name
        );
    }

    /**
     * 加入购物车
     * @param type $id
     * @return type
     * http://ysk.dev/shop/add-card?id=5
     */
    public function actionAddCard() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/admin']);
        }
        if (Yii::$app->request->isGet) {
            $user_id = Yii::$app->user->id;
            $product_id = Yii::$app->request->get("product_id");
            $model = Procduct::find()->where('id = :_id', [':_id' => $product_id])->one();
            $_price = $model->price;
            $num = 1;
            $_procduct_name = $model->name;
            $data['Cart'] = ['procduct_id' => $product_id, 'amount' => $num, 'price' => $_price, 'user_id' => $user_id, 'procduct_name' => $_procduct_name];
        }
        if (!$model = Cart::find()->where('procduct_id = :_procduct_id and user_id = :_user_id', [':_procduct_id' => $data['Cart']['procduct_id'], ':_user_id' => $user_id])->one()) {
            $model = new Cart;
        } else {
            $data['Cart']['amount'] = $model->amount + $num;
        }
        //  var_dump($data);exit;
        $model->load($data);
        $model->save();
        return $this->redirect(['shop/shop-list']);
    }

    /**
     * 购物车列表 
     */
    public function actionShopList() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/admin']);
        }
        $cart = Cart::find()->where('user_id = :_user_id', [':_user_id' => $this->user_id])->asArray()->all();
        return $this->render('shop-list', ['data' => $cart]);
    }

    /**
     *  购物车提交
     * @throws \Exception
     */
    public function actionCardSubmit() {
        try {
            if (empty($this->user_id)) {
                throw new \Exception();
            }

            //开起事务 
            $trans = Yii::$app->db->beginTransaction();
            //获取购物车info
            $sql = "SELECT SUM(price*amount) as _totbal_price FROM cart WHERE user_id ={$this->user_id} ";
            $result = Yii::$app->db->createCommand($sql);
            $integralArr = $result->queryAll();
            $_totbal_price = $integralArr[0]['_totbal_price'];

            //用户金额是否足够
            $account_row = Account::find()->where('user_id=:_user_id', [':_user_id' => $this->user_id])->one();
            if($account_row['balance'] <$_totbal_price){
                throw new \Exception('余额不够!');
            }

            //1.向order表插入
            $data['Order'] = ['user_id' => $this->user_id, 'price' => $_totbal_price, 'status' => 1];
            $order = new Order;
            $order->load($data);
            $order->save(FALSE);

            $order_id = Yii::$app->db->getLastInsertID();
            //2.向orderr_detail表插入
            $Carts = Cart::find()->where('user_id = :_user_id', [':_user_id' => $this->user_id])->asArray()->all();
            foreach ($Carts as $Cart) {
                unset($data);
                $data['OrderDetail'] = ['order_id' => $order_id, 'product_price' => $Cart['price'], 'product_amount' => $Cart['amount'], 'produce_id' => $Cart['procduct_id']];
                //a.order_detial入库
                $OrderDetail = new OrderDetail;
                $OrderDetail->load($data);
                $OrderDetail->save(FALSE);

                //b.判断库存是否足够
                $producgtg_row = Procduct::find()->where('id=:product_id', [':product_id' => $Cart['procduct_id']])->one();
                if ($producgtg_row['amount'] < $Cart['amount']) {
                    throw new \Exception('库存不够');
                }
                $product_update = Procduct::updateAll(['amount' => $producgtg_row['amount'] - $Cart['amount']], 'id=:product_id', [':product_id' => $Cart['procduct_id']]);
                //c.product 库存减去
                if (!$product_update) {
                    throw new \Exception('库存减去失败!');
                }
            }
            //3.清空card表记录
            $cart_delete = Cart::deleteAll(['user_id' => $this->user_id]);
            if (!$cart_delete) {
                throw new \Exception('购物车清除失败');
            }
            //4.先冻结金额
           $account_update =  Account::updateAll(['frozen'=>$account_row['frozen']+$_totbal_price], 'user_id=:_user_id',[':_user_id'=>$this->user_id]);
           if(!$account_update){
               throw new \Exception('用户金额冻结失败!');
           }
            
            $trans->commit();
            $this->redirect(['shop/index']);
        } catch (\Exception $e) {
            if (Yii::$app->db->getTransaction()) {
                $trans->rollback();
            }
            Yii::$app->session->setFlash('info', $e->getMessage());
            $this->redirect(['shop/shop-list']);
        }
    }

}
