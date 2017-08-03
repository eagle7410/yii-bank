<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "deposit_operations".
 *
 * @property integer $id
 * @property string $name
 * @property string $alias
 */
class DepositOperations extends \yii\db\ActiveRecord
{
    const ALIAS_CREATE = 'create';
    const ALIAS_UPDATE_EMPLOYEE = 'changeEmployee';
    const ALIAS_ADD_PERCENT = 'addPercent';
    const ALIAS_MINUS_COMMISSIONS = 'minusCommissions';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deposit_operations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['alias'], 'string', 'max' => 100],
            [['alias'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'alias' => 'Системное имя',
        ];
    }

    /**
     * @return int|string
     */
    public function getCountUsed()
    {
        return $this->hasMany(DepositsHistory::className(), ['deposit_operation_id' => 'id'])->count();
    }

    public static function getIdByAlias($alias)
    {
        return self::find()
            ->select('id')
            ->where(['alias' => $alias])
            ->scalar();
    }
}
