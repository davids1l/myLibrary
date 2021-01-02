<?php

namespace app\models;

use Bluerhinos\phpMQTT;
use Yii;

/**
 * This is the model class for table "requisicao".
 *
 * @property int $id_requisicao
 * @property string $dta_levantamento
 * @property string $dta_entrega
 * @property string $estado
 * @property int $id_utilizador
 * @property int $id_bib_levantamento
 */
class Requisicao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requisicao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['dta_levantamento', 'dta_entrega'], 'safe'],
            [['estado', 'id_utilizador'], 'required'],
            [['id_utilizador', 'id_bib_levantamento'], 'integer'],
            [['estado'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_requisicao' => 'Id Requisicao',
            //'dta_levantamento' => 'Dta Levantamento',
            //'dta_entrega' => 'Dta Entrega',
            'estado' => 'Estado',
            'id_utilizador' => 'Id Utilizador',
            'id_bib_levantamento' => 'Id Bib Levantamento',
        ];
    }

    public function FazSubscribe($subTopic) {
        $server = '127.0.0.1';
        $port = 1883;
        $username = '';
        $password = '';
        $client_id = 'phpMQTT-subscriber'.rand();

        $mqtt = new phpMQTT($server, $port, $client_id);
        if(!$mqtt->connect(true, NULL, $username, $password)) {
            exit(1);
        }

        $mqtt->debug = true;

        $topics[$subTopic] = array('qos' => 0, 'function' => 'procMsg');
        $mqtt->subscribe($topics, 0);

        while($mqtt->proc()) {
        }

        $mqtt->close();

        function procMsg($topics, $msg){
            //var_dump($topics . " : " . $msg);
            echo 'Msg Received: ' . date('r') . "\n";
            echo "Topic: {$topics}\n\n";
            echo "\t$msg\n\n";
        }
    }

    public function getBiblioteca()
    {
        return $this->hasOne(Biblioteca::className(), ['id_biblioteca' => 'id_bib_levantamento']);
    }
}
