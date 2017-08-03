<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%deposits_history}}".
 *
 * @property integer $id
 * @property integer $deposit_id
 * @property integer $deposit_operation_id
 * @property double $sum_before
 * @property double $sum_change
 * @property double $percent
 * @property integer $created_at
 * @property integer $created_by
 */
class DepositsHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%deposits_history}}';
    }

    public function behaviors()
    {
        return [
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'created_by',
                ],
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deposit_id', 'deposit_operation_id'], 'required'],
            [['deposit_id', 'deposit_operation_id', 'created_by'], 'integer'],
            [['sum_before', 'sum_change', 'percent'], 'number'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deposit_id' => 'Номер депозита',
            'deposit_operation_id' => 'Операция',
            'sum_before' => 'Сума до изменений',
            'sum_change' => 'Сума изменений',
            'created_at' => 'Дата именений',
            'created_by' => 'Кто делал',
            'percent' => 'Процент депозита',
            'comment' => 'Коментарий',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(DepositOperations::className(), ['id' => 'deposit_operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function incomeCommissionByMonth()
    {
        $time = 'DATE_FORMAT(FROM_UNIXTIME(created_at), \'%Y-%m\')';

        return self::find()
            ->select(new Expression("ABS(SUM(sum_change)) as sum, $time as season, alias"))
            ->joinWith('operation o')
            ->where(['in', 'o.alias', [DepositOperations::ALIAS_ADD_PERCENT, DepositOperations::ALIAS_MINUS_COMMISSIONS]])
            ->groupBy(new Expression("$time, alias"))
            ->orderBy('season')
            ->asArray()
            ->all();
    }
}
