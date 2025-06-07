<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class DepartmentSearch extends Department
{
    public function search($params)
    {
        $query = Department::find();

        $this->load($params);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'code', $this->code]);
        $query->andFilterWhere(['like', 'contact', $this->contact]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}