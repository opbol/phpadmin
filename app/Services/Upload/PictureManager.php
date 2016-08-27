<?php

namespace App\Services\Upload;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;

abstract class PictureManager {

	/**
	 * @var Filesystem
	 */
	protected $fs;

	public function __construct(Filesystem $fs) {
		$this->fs = $fs;
	}

    public function create(Model $model, array $input) {
        return $this->savePictures($model, $input);
    }

    public function update(Model $model, array $input, $name) {
        $pictures = [];

        if (!empty($input[$name.'_src'])) {
            $pictures = is_array($input[$name.'_src']) ? $input[$name.'_src'] : explode(',', $input[$name.'_src']);
            if (!empty($model->$name)) {
                $delAll = array_diff($model->$name, $pictures);
                if (!empty($delAll)) {
                    foreach ($delAll as $del) {
                        $this->deletePicture($del);
                    }
                }
            }
        }
        if (!empty($input[$name])) {
            $res = $this->savePictures($model, $input[$name]);
            if (!empty($res)) {
                $pictures = array_merge($pictures, $res);
            }
        }

        return $pictures;
    }

    /**
     * Get destination directory where picture should be uploaded.
     *
     * @return string
     */
    abstract protected function getDestinationDirectory();

    /**
     * Upload picture photo for provided identification and
     * delete old picture if exists.
     *
     * @param Model $model
     * @param string $base64data
     * @return string
     */
    private function upload(Model $model, $base64data) {
        $name = $this->generatePictureName($model);

        $file = $this->getDestinationDirectory() . '/' . $name;

        if (! $this->fs->exists(dirname($file)))
            $this->fs->makeDirectory(dirname($file), 0775, true, true);

        $this->fs->put($file, base64_decode($base64data));

        return $name;
    }

    private function savePictures(Model $model, $pictures) {
        $files = null;

        if (! empty($pictures)) {
            if (! is_array($pictures) ) {
                $pictures = explode(',', $pictures);
            }
            foreach ($pictures as $picture) {
                $file = $this->upload($model, $picture);
                if ($file) {
                    $files[] = $file;
                }
            }
        }

        return $files;
    }

    /**
     * @param string $name
     */
    private function deletePicture($name) {
        $path = sprintf("%s/%s", $this->getDestinationDirectory(), $name);
        $this->fs->delete($path);
    }

	/**
	 * Build random picture name.
	 *
     * @param Model $model
     *
	 * @return string
	 */
	private function generatePictureName(Model $model) {
		return sprintf("%08d", floor($model->id / 8888)) . '/' . md5(str_random() . time()) . '.png';
	}

}