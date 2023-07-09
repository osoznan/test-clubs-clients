<?php

namespace frontend\controllers;

use frontend\models\Client;
use frontend\models\ClientSearch;
use frontend\models\Club;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Client controller
 */
class ClientController extends Controller
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
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $search = new ClientSearch();

        if ($search->load(Yii::$app->request->get())) {
            $search->validate();
            $data = $search->search();
        }

        return $this->render('index', [
            'model' => $search,
            'data' => $data ?? $search->search(),
        ]);
    }

    public function actionCreate()
    {
        $model = new Client();

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->save()) {
            $this->redirect(Url::toRoute('client/view').'?id='.$model->id);
        }

        return $this->render('create-update', [
            'model' => $model,
            'clubList' => Club::find()
                ->orderBy('name')->asArray()->all()
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Client::findOne($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('info', 'Запись обновлена');
        }

        return $this->render('create-update', [
            'model' => $model,
            'clubList' => Club::find()
                ->orderBy('name')->asArray()->all()
        ]);
    }

    public function actionView($id): string
    {
        $model = Client::findOne($id);

        return $this->render('view', [
            'model' => $model->attachClubsData([$model])[0]
        ]);
    }

    public function actionDelete($id) {

        $model = Client::findOne($id);
        if($model === null)
            throw new NotFoundHttpException('The requested page does not exist.');

        $model->delete();

        return $this->redirect(Url::toRoute('client/index'));

    }

}
