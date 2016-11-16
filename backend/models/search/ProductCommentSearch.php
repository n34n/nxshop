<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductComment;

/**
 * ProductCommentSearch represents the model behind the search form about `backend\models\ProductComment`.
 */
class ProductCommentSearch extends ProductComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comment_id', 'reply_id', 'member_id', 'product_id', 'created_at', 'checked_at', 'csi'], 'integer'],
            [['hidden_name', 'comment', 'created_by', 'checked_by', 'display'], 'safe'],
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
        $query = ProductComment::find();

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
            'comment_id' => $this->comment_id,
            'reply_id' => $this->reply_id,
            'member_id' => $this->member_id,
            'product_id' => $this->product_id,
            'created_at' => $this->created_at,
            'checked_at' => $this->checked_at,
            'csi' => $this->csi,
        ]);

        $query->andFilterWhere(['like', 'hidden_name', $this->hidden_name])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'checked_by', $this->checked_by])
            ->andFilterWhere(['like', 'display', $this->display]);

        return $dataProvider;
    }
}
