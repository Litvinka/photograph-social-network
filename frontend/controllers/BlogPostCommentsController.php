<?php

namespace frontend\controllers;

use Yii;
use frontend\models\BlogPostComments;
use frontend\models\search\BlogPostComments as BlogPostCommentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BlogPostCommentsController implements the CRUD actions for BlogPostComments model.
 */
class BlogPostCommentsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all BlogPostComments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlogPostCommentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($post_id, $user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($post_id, $user_id),
        ]);
    }


    public function actionCreate()
    {
        $model = new BlogPostComments();
        if ($model->load(Yii::$app->request->post())){
            if(isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])){
                $uploaddir = 'blog_image/';
                $uploadfile = $uploaddir.basename($_FILES['image']['name']);
                    if (copy($_FILES['image']['tmp_name'], $uploadfile))
                {
                    $model->image="blog_image/".$_FILES['image']["name"];
                }
            }
            $model->save();
            print_r($model->getErrors());}
            return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Updates an existing BlogPostComments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $post_id
     * @param integer $user_id
     * @return mixed
     */
    public function actionUpdate($post_id, $user_id)
    {
        $model = $this->findModel($post_id, $user_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'post_id' => $model->post_id, 'user_id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BlogPostComments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $post_id
     * @param integer $user_id
     * @return mixed
     */
    public function actionDelete($post_id, $user_id)
    {
        $this->findModel($post_id, $user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BlogPostComments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $post_id
     * @param integer $user_id
     * @return BlogPostComments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($post_id, $user_id)
    {
        if (($model = BlogPostComments::findOne(['post_id' => $post_id, 'user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
