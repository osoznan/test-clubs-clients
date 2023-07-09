<?php

namespace console\controllers;

use common\models\User;
use frontend\models\Client;
use frontend\models\Club;
use yii\console\Controller;
use Yii;

class GenerateTestDataController extends Controller
{
    // сгенерируем-ка для проекта учётную запись юзера + тестовые данные таблиц
    public function actionIndex()
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {

            Client::deleteAll();
            Club::deleteAll();
            User::deleteAll();

            $user = new User([
                'username' => 'admin',
                'auth_key' => '6pxC03LdtsV1A7QPsOoAErCOPz8ZOxw1',
                'password_hash' => '$2y$13$BteS/IW6zkzoEIPhjFNXBeaaFFJIX4k.UAVlOpVyeGSWejOs2nu.m',
                'email' => 'admin@admin.ru',
                'status' => 10,
                'verification_token' => 'GYtHGJLEheSJx7jrPxCJy5l_xcs-i-uk_1688745283'
            ]);

            $user->save();

            $faker = \Faker\Factory::create();


            $commonFields = ['created_at', 'user_created_at', 'updated_at', 'user_updated_at', 'deleted_at', 'user_deleted_at'];
            $timeSpan = 10000000;

            Club::deleteAll();

            $clubs = [];
            $clubsCount = 30;
            for ($i = 0; $i < $clubsCount; $i++) {
                $club = $clubs[] = [
                    'name' => $faker->name,
                    'address' => $faker->address,
                    'created_at' => $creation = $faker->unixTime - $timeSpan,
                    'user_created_at' => $user->id,
                    'updated_at' => $updation = $creation + random_int(0, $timeSpan / 2),
                    'user_updated_at' => $user->id,
                    'deleted_at' => ($rand = random_int(0, 4)) == 1 ? $updation + random_int(0, $timeSpan / 2) : null,
                    'user_deleted_at' => $rand == 1 ? $user->id : null,
                ];
            }

            Yii::$app->db->createCommand()->batchInsert(
                Club::tableName(), array_merge(['name', 'address'], $commonFields), $clubs
            )->execute();


            // для генерации списка ИД клубов у клиентов
            $clubIds = array_column(Club::find()->asArray()->all(), 'id');

            $clients = [];
            for ($i = 0; $i < 30; $i++) {
                shuffle($clubIds);

                $client = $clients[] = [
                    'name' => $faker->company,
                    'sex' => $faker->randomElement(['М', 'Ж']),
                    'birth_date' => $faker->date(),
                    'clubs' => join(',', array_slice($clubIds, 0, random_int(0, 5))),
                    'created_at' => $creation = $faker->unixTime - $timeSpan,
                    'user_created_at' => $user->id,
                    'updated_at' => $updation = $creation + random_int(0, $timeSpan / 2),
                    'user_updated_at' => $user->id,
                    'deleted_at' => ($rand = random_int(0, 4)) == 1 ? $updation + random_int(0, $timeSpan / 2) : null,
                    'user_deleted_at' => $rand == 1 ? $user->id : null
                ];
            }

            Yii::$app->db->createCommand()->batchInsert(
                Client::tableName(), array_merge(['name', 'sex', 'birth_date', 'clubs'], $commonFields), $clients
            )->execute();

            $transaction->commit();

            echo 'Данные сгенерированы успешно!';

        } catch (\Exception $e) {
            echo $e->getMessage();
            $transaction->rollBack();
        }
    }
}