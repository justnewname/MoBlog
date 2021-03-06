<?php

namespace backend\controllers;

use Yii;
use common\models\Content;
use backend\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use common\components\PageComp;

/**
 * PageController implements the CRUD actions for Content model.
 */
class PageController extends BaseController
{

    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {
        $pages=new Pagination([
            'totalCount'=>PageComp::getInstance()->getPageCount(),
        ]);
        $dataList=PageComp::getInstance()->getPageList($pages->offset,$pages->limit);
        return $this->render('index',['dataList'=>$dataList,'pages'=>$pages]);
    }


    /**
     * Creates a new Content model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Content();
        $model->allowComment=true;
        $model->allowFeed=true;
        $model->allowPing=true;
        if(Yii::$app->request->isPost){

            if($model->load(Yii::$app->request->post())){
                $model->type=Content::TYPE_PAGE;
                if ($model->save()) {

                    return $this->redirect(['index']);
                }
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Content model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost){

            if($model->load(Yii::$app->request->post())){
                $model->type=Content::TYPE_PAGE;
                if ($model->save()) {

                    return $this->redirect(['index']);
                }
            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Content model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Content the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Content::findOne(['cid'=>$id,'type'=>Content::TYPE_PAGE])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
