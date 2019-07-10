<?php

namespace frontend\controllers;

use Yii;
use frontend\models\BlogPost;
use frontend\models\search\BlogPost as BlogPostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
use frontend\models\BlogPostComments;
use frontend\models\BlogPostView;

/**
 * BlogPostController implements the CRUD actions for BlogPost model.
 */
class BlogPostController extends Controller
{

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


    public function actionIndex()
    {
        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM blog_post WHERE user_id='.Yii::$app->user->identity->id)->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * from blog_post WHERE user_id='.Yii::$app->user->identity->id.' ORDER BY updated_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }

    public function actionPopular()
    {
        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM blog_post WHERE user_id='.Yii::$app->user->identity->id)->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT blog_post.*, count(comment) AS c FROM blog_post LEFT JOIN blog_post_comments ON blog_post.id=post_id WHERE blog_post.user_id='.Yii::$app->user->identity->id.' GROUP BY id ORDER BY c DESC, updated_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $this->render('popular', ['listDataProvider' => $dataProvider]);
    }

    public function actionAllPost()
    {
        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM blog_post')->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * from blog_post ORDER BY updated_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $this->render('allpost', ['listDataProvider' => $dataProvider]);
    }

    public function actionAllPopular()
    {
        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM blog_post')->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT blog_post.*, count(comment) AS c FROM blog_post LEFT JOIN blog_post_comments ON blog_post.id=post_id GROUP BY id ORDER BY c DESC, updated_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $this->render('allpost', ['listDataProvider' => $dataProvider]);
    }
    
    public function actionView($id)
    {
        if((Yii::$app->db->createCommand('SELECT COUNT(*) FROM blog_post_view WHERE post_id='.$id.' AND user_id='.Yii::$app->user->identity->id)->queryScalar()) == 0){
            $view=new BlogPostView();
            $view->user_id=Yii::$app->user->identity->id;
            $view->post_id=$id;
            $view->save();
        }
        $count = Yii::$app->db->createCommand('
            SELECT COUNT(*) FROM blog_post_comments WHERE post_id='.$id)->queryScalar();
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT comment,image,blog_post_comments.created_at,username from blog_post_comments join user ON blog_post_comments.user_id=user.id WHERE post_id='.$id.' ORDER BY blog_post_comments.created_at DESC',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        return $this->render('view', ['model' => $this->findModel($id), 'listDataProvider' => $dataProvider]);
    }


    public function actionCreate()
    {
        $model = new BlogPost();
        if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
            $uploaddir = 'blog_image/';
            $uploadfile = $uploaddir.basename($_FILES['image']['name']);
                if (copy($_FILES['image']['tmp_name'], $uploadfile))
            {
                $model->image="blog_image/".$_FILES['image']["name"];
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())){
            if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
                $uploaddir = 'blog_image/';
                $uploadfile = $uploaddir.basename($_FILES['image']['name']);
                    if (copy($_FILES['image']['tmp_name'], $uploadfile))
                {
                    $model->image="blog_image/".$_FILES['image']["name"];
                }
            }
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', ['model' => $model,]);
    }


    public function actionDelete($id)
    {
        Yii::$app->db->createCommand('DELETE FROM blog_post_comments WHERE post_id='.$id)->execute();
        Yii::$app->db->createCommand('DELETE FROM blog_post_view WHERE post_id='.$id)->execute();
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = BlogPost::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
