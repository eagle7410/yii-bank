<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "clients".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $middle_name
 * @property string $surname
 * @property integer $birthday
 * @property integer $personal_number
 * @property integer $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $is_man
 */
class Clients extends ActiveRecord
{
    const SCENARIO_CLIENT = 'client';
    const SCENARIO_CLIENT_CHANGE = ['surname'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
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


    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            self::SCENARIO_CLIENT => self::SCENARIO_CLIENT_CHANGE
        ]);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['personal_number', 'surname','name', 'is_man', 'birthday'], 'required'],
            [['surname'], 'safe'],
            [['user_id', 'is_man'], 'integer', ],
            [['name', 'middle_name'], 'string', 'max' => 100 ],
            [['surname'], 'string', 'max' => 150],
            ['birthday', 'moreSeventeen'],
            ['personal_number', 'number'],
            ['personal_number', 'unique'],
        ];
    }


    /**
     * Check age more seventeen.
     *
     * @param $attribute string | int
     */
    public function moreSeventeen($attribute)
    {
        $now = new \DateTime();
        $birthday = clone $now;
        $birthday->setTimestamp((int)$this->$attribute);
        $age = $birthday->diff($now);

        if ($age->y < 18) {
            $this->addError($attribute, "Вы нет восемнадцати");
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'personal_number' => 'Идентификационный номер',
            'name' => 'Имя',
            'middle_name' => 'Отчество',
            'surname' => 'Фамилия',
            'birthday' => 'Дата рождения',
            'is_man' => 'Мужской пол',
            'created_at' => 'Дата создания',
            'created_by' => 'Кем создан',
            'updated_at' => 'Дата обновления',
            'updated_by' => 'Кем обновленный',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeposits()
    {
        return $this->hasMany(Deposits::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getById($clientId)
    {
        return self::findOne($clientId);
    }

    /**
     * Return client full name.
     * @return string
     */
    public function getFullName()
    {
        return "{$this->surname} {$this->name} {$this->middle_name}";
    }

    /**
     * Return user list which active.
     *
     * @return array|ActiveRecord[]
     */
    public function getActiveList()
    {
        return self::find()
            ->alias('c')
            ->select([
                'c.id',
                new Expression('CONCAT(surname, " ", name, " ", middle_name) as full_name')
            ])
            ->joinWith([
                'user' => function ($q) {
                    $q->alias('u')
                        ->select('id, status')
                        ->all();
                }
            ])
            ->where(['u.status' => User::STATUS_ACTIVE])
            ->asArray()
            ->all();
    }

    /**
     * Get client balance by user_id.
     *
     * @param null|int $userId
     *
     * @return false|int|null|string
     */
    public static function getBalanceByUserId($userId = null)
    {
        $tableClient = Clients::tableName();
        $userId = $userId ?? Yii::$app->user->id;

        $balance = Deposits::find()
            ->select(new Expression('SUM(sum)'))
            ->where(new Expression('client_id = (SELECT id FROM ' . $tableClient . ' WHERE user_id =:user)', [
                ':user' => $userId
            ]))
            ->asArray()
            ->scalar();

        return $balance ? $balance : 0;
    }
}
