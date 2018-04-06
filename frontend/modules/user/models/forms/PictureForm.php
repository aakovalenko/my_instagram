<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 06.04.18
 * Time: 11:10
 */

namespace frontend\modules\user\models\forms;

use Yii;
use yii\base\Model;

class PictureForm extends Model
{
    public $picture;

    public function rules()
    {
        return [
            [['picture'], 'file', 'extensions' => ['jpg'], 'checkExtensionByMimeType' => true],
        ];
    }

    public function save()
    {
        return 1;
    }
}