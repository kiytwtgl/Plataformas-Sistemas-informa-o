<?php

declare(strict_types=1);

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\PerfilUtilizador;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class UserController extends Controller
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
                    ],
                ],
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
            'query' => User::find()->where(['<>', 'status', User::STATUS_DELETED]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate(int $id): string|Response
    {
        $model = $this->findModel($id);
        $perfil = $model->perfilUtilizador ?? new PerfilUtilizador(['id_user' => $model->id]);

        $postData = Yii::$app->request->post();

        if ($model->load($postData) && $perfil->load($postData)) {
            if (!empty($model->new_password)) {
                $model->setPassword($model->new_password);
                $model->generateAuthKey();
}

            $isValid = $model->validate();
            $isValid = $perfil->validate() && $isValid;

            if ($isValid) {
                $model->save(false);
                $perfil->id_user = $model->id;
                $perfil->save(false);
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'perfil' => $perfil,
        ]);
    }

    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);
        $model->status = User::STATUS_DELETED;
        $model->save(false);

        return $this->redirect(['index']);
    }

    protected function findModel(int $id): User
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('O utilizador solicitado não existe.');
    }
}