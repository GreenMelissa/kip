<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class TaskSearch extends Task
{
    public function search($params)
    {
        $query = Task::find();

        if (\Yii::$app->user->identity->getRole() !== User::ROLE_ADMIN) {
            $query->andWhere(['ldap_uid' => \Yii::$app->user->identity->username]);
        }

        $this->load($params);

        $query->andFilterWhere(['like', 'ldap_uid', $this->ldap_uid]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['active_until' => $this->active_until]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}