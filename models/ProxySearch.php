<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Proxy;

/**
 * ProxySearch represents the model behind the search form of `app\models\Proxy`.
 */
class ProxySearch extends Proxy
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['port'], 'integer'],
            ['ip', 'ip', 'ipv6' => false]
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Proxy::find()
            ->indexBy('id');//for kartik gridview

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
            'id' => $this->id,
            'ip_hash' => $this->ip_hash ? $this->ip_hash : null,//fixme. validate() change null to 0
            'port' => $this->port,
        ]);

        return $dataProvider;
    }
}
