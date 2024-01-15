<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Pet;
use app\models\User;

class PetController extends Controller
{

    public function beforeAction($action) { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    }


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'submitForm' => ['post'],
                ],
            ],
        ];
    }
    
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionList() {
        $rows = Pet::find()->where(['like', 'name', $_GET['searchQuery'] . '%', false])->all();
        // return $model->attributes;

        return $this->asJson($rows);
    }

    public function actionUserPetList() {
        $rows = Pet::find()
        ->joinWith('users', true, 'LEFT JOIN')
        ->where(['users.id' => 1])
        ->all();

        return $this->asJson($rows);
    }

    public function actionSubmitForm() {
        // Yii::$app->response->format = Response::FORMAT_JSON;
        $request = Yii::$app->request;

        $ids = $request->post('selectedOptions');

        $pets = [];
        
        foreach ($ids as $id) {
            $pets[] = Pet::findOne($id);
        }
        
        $extraColumns = []; // extra columns to be saved to the many to many table
        $unlink = true; // unlink tags not in the list
        $delete = true; // delete unlinked tags
        
        User::findOne(1)->linkAll('pets', $pets, $extraColumns, $unlink, $delete);

        $userPets = Pet::find()
        ->joinWith('users')
        ->where(['users.id' => 1])
        ->all();
        
        $response = [
            'success' => true,
            'message' => '<p>Pets assigned sucessfully.<span class=\"text-secondary\"><i class=\"fa fa-times fa-lg\" style=\"margin-left:1rem ;\"onclick=\"successmsg()\"></i></span><p>',
            'userpets' => $userPets,
        ];
        
        return $this->asJson($response);
    }

    public function actionDeletePet() {
        User::findOne(1)->linkAll('pets', []);

        $response = [
            'success' => true,
            'message' => '<p>Pets delete successfully.#1844<span class=\"text-secondary\"><i style=\"margin-left:1rem ;\" class=\"fa fa-times fa-lg\" onclick=\"successmsg()\"></i></span><p>',
        ];
        
        return $this->asJson($response);
    }
    
}