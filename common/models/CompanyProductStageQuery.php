<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[CompanyProductStage]].
 *
 * @see CompanyProductStage
 */
class CompanyProductStageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CompanyProductStage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CompanyProductStage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
