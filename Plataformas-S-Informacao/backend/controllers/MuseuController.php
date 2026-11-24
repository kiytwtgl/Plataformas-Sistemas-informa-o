<?php

declare(strict_types=1);

namespace backend\controllers;

use common\models\Museu;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\Localizacao;

class MuseuController extends Controller
{
    
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return (new \yii\db\Query())
                                ->from('perfil')
                                ->where([
                                    'id_user' => Yii::$app->user->id,
                                    'tipo' => 'administrador',
                                ])
                                ->exists();
                        },
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException(
                        'Não tens permissões para gerir museus.'
                    );
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Museu::find()->where(['estado' => 1]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate(): Response|string
    {
        $model = new Museu();
        $localizacao = new Localizacao();

        if ($model->load(Yii::$app->request->post())) {
            $localizacao->load(Yii::$app->request->post());

            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($model->save()) {
                    $localizacao->id_museu = $model->id_museu;

                    if ($localizacao->save()) {
                        $transaction->commit();

                        Yii::$app->session->setFlash(
                            'success',
                            'Museu adicionado com sucesso!'
                        );

                        return $this->redirect(['index']);
                    }
                }

                $transaction->rollBack();

            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('create', [
            'model' => $model,
            'localizacao' => $localizacao,
        ]);
    }



    public function actionUpdate(int $id): Response|string
    {
        $model = $this->findModel($id);

        // Carregar a localização existente ou criar uma nova
        $localizacao = $model->localizacao ?? new Localizacao();

        if ($model->load(Yii::$app->request->post())) {
            $localizacao->load(Yii::$app->request->post());

            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($model->save()) {
                    $localizacao->id_museu = $model->id_museu;

                    if ($localizacao->save()) {
                        $transaction->commit();

                        Yii::$app->session->setFlash(
                            'success',
                            'Museu atualizado com sucesso!'
                        );

                        return $this->redirect(['index']);
                    }
                }

                $transaction->rollBack();

            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('update', [
            'model' => $model,
            'localizacao' => $localizacao,
        ]);
    }


    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);

        $model->estado = 0;
        $model->save(false);

        Yii::$app->session->setFlash(
            'success',
            'Museu desativado com sucesso!'
        );

        return $this->redirect(['index']);
    }

    protected function findModel(int $id): Museu
    {
        if (($model = Museu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('O museu solicitado não existe.');
    }
}