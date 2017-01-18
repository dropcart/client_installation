<?php

namespace App\Http\Controllers;

class AssetController extends Controller
{
    const ALLOWED_IMAGES = ['jpg', 'png', 'gif', 'svg', 'jpeg', 'bmp'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    private function assetExistsInPublic($file)
    {
        $path = resource_path('../public/' . $file);
        if(file_exists($path))
            return $path;

        return FALSE;
    }

    private function assetExistsInStorage($file)
    {
        $path = storage_path('app/' . $file);
        if(file_exists($path))
            return $path;

        return FALSE;
    }

    private function assetExistsInTheme($file)
    {
        $path = resource_path('themes/' . env('THEME', 'default') . '/assets/' . $file);
        if(file_exists($path))
            return $path;

        return FALSE;
    }

    public function css()
    {
        $params = func_get_args();

        $file = 'css/' . implode('/', $params);
        $contents = $this->loadFile($file);

        header('Content-Type: text/css');
        header('Content-Length: ' . strlen($contents) );
        die($contents);
    }

    public function js()
    {
        $params = func_get_args();

        $file = 'js/' . implode('/', $params);
        $contents = $this->loadFile($file);

        header('Content-Type: text/js');
        header('Content-Length: ' . strlen($contents) );
        die($contents);
    }

    public function img()
    {
        $params = func_get_args();

        $file = 'img/' . implode('/', $params);
        $extension = explode('.', $file);
        $extension = strtolower(end($extension));

        if(!in_array($extension, self::ALLOWED_IMAGES))
            return abort(406, 'File not supported');

        if      (($path = $this->assetExistsInPublic($file)) !== FALSE) {}
        elseif  (($path = $this->assetExistsInStorage($file)) !== FALSE) {}
        elseif  (($path = $this->assetExistsInTheme($file)) !== FALSE) {}
        else
                abort(404, $file . ' does not exists');

        exec("cd " . getcwd());
        $pathToFile = escapeshellcmd($path);
        $mimeType = exec("file -b --mime-type $pathToFile");
        if(preg_match("/image\//", $mimeType))
            header('Content-Type: ' . $mimeType);
        else
            abort(406, 'File not supported');

        header('Content-Disposition: inline;');
        header('Content-Length: ' . filesize($pathToFile) );
        passthru('cat ' . $pathToFile);
        exit;
    }

    private function loadFile($file)
    {

        if(($path = $this->assetExistsInPublic($file)) !== FALSE)
            return file_get_contents($path);
        elseif(($path = $this->assetExistsInStorage($file)) !== FALSE)
            return file_get_contents($path);
        elseif(($path = $this->assetExistsInTheme($file)) !== FALSE)
        {
            return file_get_contents($path);
        }
        else
            abort(404, $file . ' does not exists');
    }
}
