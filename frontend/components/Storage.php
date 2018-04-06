<?php
namespace frontend\components;

use yii\base\Component;
use yii\web\UploadedFile;
use Yii;
use yii\helpers\FileHelper;

class Storage extends Component implements StorageInterface
{
    private $fileName;

    /**
     * Save given Uploadedfile instance to disk
     * @param UploadedFile $file
     * @return string|null
     */
    public function saveUploadedFile(UploadedFile $file)
    {
        $path = $this->preparePath($file);

        if ($path && $file->saveAs($path)) {
            return $this->fileName;
        }
    }

    protected function preparePath(UploadedFile $file)
    {
        $this->fileName = $this->getFileName($file);
        // oc/a9/234534653fsdfw45trg3t53y545y54.jpg

        $path = $this->getStoragePath() . $this->fileName;
        //    /var/www/image/frontebd/web/uploads/0c/a9/356783tg98er7t978r6t34yutiure7t6er7.jpg

        $path = FileHelper::normalizePath($path);

        if (FileHelper::createDirectory(dirname($path)))
        {
            return $path;
        }
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    protected function getFilename(UploadedFile $file)
    {
        //$file->tmpname - /tmp/qio93kf
        $hash = sha1_file($file->tempName); //0ca9ttlsjhgsfhguihgsjklghjsklgho

        $name = substr_replace($hash, '/',2,0);
        $name = substr_replace($name, '/',5,0); // 0c/a9/423798wtwreuitywyt9478tyweryt47
        return $name . '.' . $file->extension; // 0c/a9/23548tguiorwetu3489ty8wtwurioethwu.jpg
    }

    /*
     * @return string
     */
    protected function getStoragePath()
    {
        return Yii::getAlias(Yii::$app->params['storagePath']);
    }

    /*
     * @param string $filename
     * @return string
     */
    public function getFile(string $filename)
    {
        return Yii::$app->params['storageUri'].$filename;
    }


}