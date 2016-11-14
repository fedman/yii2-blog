<?php

namespace pendalf89\blog\widgets;

use Yii;

/**
 * Class ViewCounterWidget
 *
 * Example of usage:
 * <?php
 *     use pendalf89\blog\widgets\ViewsCounterWidget;
 *     echo ViewsCounterWidget::widget(['model' => $model]);
 * ?>
 *
 * Counts and return the number of views post on the each load.
 * Just place this widget on the page of post and specify Post $model.
 *
 * @author Zabolotskikh Boris <zabolotskich@bk.ru>
 */
class ViewsCounterWidget extends \yii\base\Widget
{
    /**
     * @var \pendalf89\blog\models\Post null Post model
     */
    public $model = null;

    public function run()
    {
        if ($this->allowViewsIncrement($this->model->id)) {

            ++$this->model->views;
            $this->model->detachBehaviors();
            $this->model->save();
            $viewed = Yii::$app->session->get('postViewsIncremented');
            $viewed = is_array($viewed) ? Yii::$app->session->get('postViewsIncremented') : [];
            $viewed[] = $this->model->id;
            Yii::$app->session->set('postViewsIncremented', $viewed);
        }

        return $this->model->views;
    }

    /**
     * This method checks whether it is possible to increase the number
     * of views for the current session.
     *
     * @return bool if views increment impossible return false.
     */
    protected static function allowViewsIncrement($postId)
    {
        $viewed = Yii::$app->session->get('postViewsIncremented');
        if (is_array($viewed)) {
            return !in_array($postId, $viewed);
        }
        
        return TRUE;
    }
}
