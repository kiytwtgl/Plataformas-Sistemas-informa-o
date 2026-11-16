<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "museu".
 *
 * @property int $id_museu
 * @property string $nome
 * @property string|null $tipo
 * @property string|null $descricao
 * @property string|null $morada
 * @property float|null $preco
 * @property string|null $horario_abertura
 * @property string|null $horario_fecho
 *
 * @property Bilhete[] $bilhetes
 * @property Colaborador[] $colaboradors
 * @property Lembranca[] $lembrancas
 * @property Localizacao[] $localizacaos
 * @property LotacaoHora[] $lotacaoHoras
 * @property Obra[] $obras
 * @property VerificacaoDiaria[] $verificacaoDiarias
 * @property Visita[] $visitas
 */
class Museu extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'museu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo', 'descricao', 'morada', 'preco', 'horario_abertura', 'horario_fecho'], 'default', 'value' => null],
            [['nome'], 'required'],
            [['descricao'], 'string'],
            [['preco'], 'number'],
            [['horario_abertura', 'horario_fecho'], 'safe'],
            [['nome'], 'string', 'max' => 100],
            [['tipo'], 'string', 'max' => 50],
            [['morada'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_museu' => 'Id Museu',
            'nome' => 'Nome',
            'tipo' => 'Tipo',
            'descricao' => 'Descricao',
            'morada' => 'Morada',
            'preco' => 'Preco',
            'horario_abertura' => 'Horario Abertura',
            'horario_fecho' => 'Horario Fecho',
        ];
    }

    /**
     * Gets query for [[Bilhetes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBilhetes()
    {
        return $this->hasMany(Bilhete::class, ['id_museu' => 'id_museu']);
    }

    /**
     * Gets query for [[Colaboradors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColaboradors()
    {
        return $this->hasMany(Colaborador::class, ['id_museu' => 'id_museu']);
    }

    /**
     * Gets query for [[Lembrancas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLembrancas()
    {
        return $this->hasMany(Lembranca::class, ['id_museu' => 'id_museu']);
    }

    /**
     * Gets query for [[Localizacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacaos()
    {
        return $this->hasMany(Localizacao::class, ['id_museu' => 'id_museu']);
    }

    /**
     * Gets query for [[LotacaoHoras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLotacaoHoras()
    {
        return $this->hasMany(LotacaoHora::class, ['id_museu' => 'id_museu']);
    }

    /**
     * Gets query for [[Obras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObras()
    {
        return $this->hasMany(Obra::class, ['id_museu' => 'id_museu']);
    }

    /**
     * Gets query for [[VerificacaoDiarias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVerificacaoDiarias()
    {
        return $this->hasMany(VerificacaoDiaria::class, ['id_museu' => 'id_museu']);
    }

    /**
     * Gets query for [[Visitas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVisitas()
    {
        return $this->hasMany(Visita::class, ['id_museu' => 'id_museu']);
    }

}
