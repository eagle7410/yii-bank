<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "{{%deposits}}".
 *
 * @property integer $id
 * @property integer $client_id
 * @property double $sum
 * @property double $percent
 * @property string $start_at
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class Deposits extends \yii\db\ActiveRecord
{
    const STATUS_CREATE = 0;
    const STATUS_RUN = 5;
    const STATUS_NO_MONEY = 10;
    const STATUS_OWNER_DELETE = 15;
    const SCENARIO_UPDATE = 'update';
    public static $statusLabels = [
        self::STATUS_CREATE => 'Открыт',
        self::STATUS_RUN => 'Запушен',
        self::STATUS_OWNER_DELETE => 'Клиент удален',
    ];

    /**
     * Return label for status.
     *
     * @return int|mixed
     */
    public function getStatusLabel()
    {
        return isset(self::$statusLabels[$this->status]) ? self::$statusLabels[$this->status] : $this->status;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%deposits}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'start_at', 'sum', 'percent'], 'required'],
            [['client_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['sum', 'percent'], 'number'],
            [['sum', 'percent'], 'moreZero'],
            ['start_at', 'isFuture'],
            [['created_at', 'updated_at', 'seePercent'], 'safe'],
            ['!client_id', 'safe', 'on' => self::SCENARIO_UPDATE]
        ];
    }

    public function isFuture($attribute)
    {
        if ((int)$this->created_at > $this->getAttribute($attribute)) {
            $this->addError($attribute, 'Депозит не может работать раньше создания.');
        }

    }

    public function moreZero($attribute)
    {
        if ($this->getAttribute($attribute) <= 0) {
            $this->addError($attribute, 'Значение долно быть больше ноля.');
        }
    }

    public function behaviors()
    {
        return [
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'updated_by'
                ],
            ],
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
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
            'client_id' => 'Клиент',
            'sum' => 'Сума',
            'percent' => 'Процент',
            'seePercent' => 'Процент',
            'start_at' => 'Дата старта',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'created_by' => 'Кем создан',
            'updated_at' => 'Дата обновления',
            'updated_by' => 'Кем обновленный',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    public function getSeePercent()
    {
        if (empty($this->percent)) {
            return null;
        }

        return $this->percent * 100;
    }

    public function setSeePercent($value)
    {
        if (empty($value)) {
            $this->percent = null;
        }

        $this->percent = $value / 100;
    }

    public function getById($id)
    {
        return self::findOne($id);
    }

    /**
     * Return deposits for income and commissions.
     *
     * @return array|ActiveRecord[]
     */
    public static function getForRecalculation()
    {
        return self::find()
            ->select(['id', 'sum', 'percent', 'start_at'])
            ->where([
                'in',
                'status',
                [
                    self::STATUS_CREATE,
                    self::STATUS_RUN
                ]
            ])
            ->all();
    }

    public function getAvarageDepositSumByClientAgeGroup()
    {
        $now = new \DateTime();

        $now->modify('- 18 years');
        $ts18 = $now->getTimestamp();

        $now->modify('- 7 years');
        $ts25 = $now->getTimestamp();

        $now->modify('- 25 years');
        $ts50 = $now->getTimestamp();

        $spitByGroup = 'SELECT
            sum,
            c.name,
            CASE
              WHEN birthday > ' . $ts18 . ' THEN "group0"
              WHEN birthday <= ' . $ts18 . ' AND birthday > ' . $ts25 . ' THEN "group1"
              WHEN birthday <= ' . $ts25 . ' AND birthday > ' . $ts50 . ' THEN "group2"
              WHEN birthday <= ' . $ts50 . ' THEN "group3"
            END AS age_group
        FROM deposits d JOIN clients c ON d.client_id = c.id';

        return \Yii::$app->db->createCommand(
            'SELECT age_group, AVG(tg.sum) as sum '
            . 'FROM ('.$spitByGroup.') tg '
            . 'WHERE age_group <> "group0" '
            . 'GROUP BY age_group '
        )->queryAll();
    }
}
