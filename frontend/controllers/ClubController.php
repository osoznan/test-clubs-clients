<?php

namespace frontend\controllers;

use frontend\models\Model;
use Yii;
use yii\helpers\Url;
use frontend\models\ClubSearch;
use frontend\models\Club;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Club controller
 */
class ClubController extends Controller
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
                ],
            ]
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ]
        ];
    }

    public function actionIndex()
    {
        $search = new ClubSearch();
        $search->scenario = Model::SCENARIO_FILTER;

        if ($search->load(Yii::$app->request->get())) {
            $search->validate();
            $data = $search->search();
        }

        return $this->render('index', [
            'model' => $search,
            'query' => $data ?? $search->search()
        ]);
    }

    public function actionCreate()
    {
        $model = new Club();

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->save()) {
            $this->redirect(Url::toRoute('club/view').'?id='.$model->id);
        }

        return $this->render('create-update', [
            'model' => $model,
            'clubList' => Club::find()->asArray()->all()
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Club::findOne($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('info', 'Запись обновлена');
        }

        return $this->render('create-update', [
            'model' => $model,
            'clubList' => Club::find()->asArray()->all()
        ]);
    }

    public function actionView($id): string
    {
        $model = Club::findOne($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionDelete($id) {

        $model = Club::findOne($id);
        if($model === null)
            throw new NotFoundHttpException('The requested page does not exist.');

        $model->delete();

        return $this->redirect(Url::toRoute('club/index'));

    }
}
