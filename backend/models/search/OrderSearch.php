<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Order;

/**
 * OrderSearch represents the model behind the search form about `backend\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'member_id', 'stage', 'status', 'order_weight', 'order_quantity', 'created_at', 'pay_at', 'express_at', 'confirm_at', 'express_csi', 'service_csi'], 'integer'],
            [['order_type', 'consignee', 'mobile', 'telphone', 'idcard', 'province', 'city', 'area', 'address', 'buyer', 'buyer_mobile', 'buyer_idcard', 'invoice', 'invoice_title', 'currency', 'order_sn', 'pay_method', 'pay_sn', 'express_com', 'express_sn'], 'safe'],
            [['product_amount', 'shipping_fee', 'tax', 'save', 'order_amount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'member_id' => $this->member_id,
            'stage' => $this->stage,
            'status' => $this->status,
            'order_weight' => $this->order_weight,
            'order_quantity' => $this->order_quantity,
            'product_amount' => $this->product_amount,
            'shipping_fee' => $this->shipping_fee,
            'tax' => $this->tax,
            'save' => $this->save,
            'order_amount' => $this->order_amount,
            'created_at' => $this->created_at,
            'pay_at' => $this->pay_at,
            'express_at' => $this->express_at,
            'confirm_at' => $this->confirm_at,
            'express_csi' => $this->express_csi,
            'service_csi' => $this->service_csi,
        ]);

        $query->andFilterWhere(['like', 'order_type', $this->order_type])
            ->andFilterWhere(['like', 'consignee', $this->consignee])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'telphone', $this->telphone])
            ->andFilterWhere(['like', 'idcard', $this->idcard])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'buyer', $this->buyer])
            ->andFilterWhere(['like', 'buyer_mobile', $this->buyer_mobile])
            ->andFilterWhere(['like', 'buyer_idcard', $this->buyer_idcard])
            ->andFilterWhere(['like', 'invoice', $this->invoice])
            ->andFilterWhere(['like', 'invoice_title', $this->invoice_title])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'pay_method', $this->pay_method])
            ->andFilterWhere(['like', 'pay_sn', $this->pay_sn])
            ->andFilterWhere(['like', 'express_com', $this->express_com])
            ->andFilterWhere(['like', 'express_sn', $this->express_sn]);

        return $dataProvider;
    }
}
