<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "cron_run_history".
 *
 * @property integer $id
 * @property integer $cron_type
 * @property integer $cron_start_at
 * @property integer $start_ignore
 * @property integer $updated_at
 * @property integer $updated_by
 */
class CronRunHistory extends \yii\db\ActiveRecord
{
    const TYPE_INCOME_COMMISSIONS = 1;

    public static $cronLabels = [
        self::TYPE_INCOME_COMMISSIONS => 'Начисление выплат и комиссий'
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cron_run_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cron_type', 'cron_start_at'], 'required'],
            [['cron_type', 'cron_start_at', 'updated_at', 'updated_by'], 'integer'],
        ];
    }

    public function behaviors()
    {
        return [
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['updated_by'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by']
                ],
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cron_type' => 'Название крона',
            'cron_start_at' => 'Время старта',
            'start_ignore' => 'Игнорировать єтот старт',
            'updated_at' => 'Время обновления',
            'updated_by' => 'Кем обновлено',
            'cronLabel' => 'Название крона',
        ];
    }

    public function countRunToday()
    {
        return self::find()
            ->where(new Expression(
                'start_ignore = false AND cron_type = :type AND DATE_FORMAT(FROM_UNIXTIME(`cron_start_at`), \'%d-%m-%Y\') = DATE_FORMAT(FROM_UNIXTIME(:check), \'%d-%m-%Y\') ',
                [
                    ':type' => $this->cron_type,
                    ':check' => $this->cron_start_at
                ]
            ))
            ->count();

    }

    public function getCronLabel()
    {
        return self::$cronLabels[$this->cron_type] ? self::$cronLabels[$this->cron_type] : $this->cron_type ;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
}
