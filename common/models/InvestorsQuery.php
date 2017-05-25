<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Investors]].
 *
 * @see Investors
 */
class InvestorsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Investors[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Investors|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
