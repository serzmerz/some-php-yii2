<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompanyRaising]].
 *
 * @see CompanyRaising
 */
class CompanyRaisingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CompanyRaising[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CompanyRaising|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
