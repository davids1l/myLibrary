<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "leitor".
 *
 * @property int $id_leitor
 * @property string $num_leitor
 * @property int|null $bloqueado
 * @property string|null $dta_bloqueado
 */
class Leitor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leitor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['num_leitor'], 'required'],
            [['bloqueado'], 'integer'],
            [['dta_bloqueado'], 'safe'],
            [['num_leitor'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_leitor' => 'Id Leitor',
            'num_leitor' => 'Num Leitor',
            'bloqueado' => 'Bloqueado',
            'dta_bloqueado' => 'Dta Bloqueado',
        ];
    }
}
