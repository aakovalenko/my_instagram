<?php
/**
 * Created by PhpStorm.
 * User: andrii
 * Date: 06.04.18
 * Time: 11:57
 */

namespace frontend\components;

use yii\web\UploadedFile;

interface StorageInterface
{
    public function saveUploadedFile(UploadedFile $file);

    public function getFile(string $filename);
}