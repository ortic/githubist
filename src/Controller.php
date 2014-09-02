<?php

namespace Ortic\Githubist;

use Desarrolla2\Cache\Cache;
use Desarrolla2\Cache\Adapter\File;

class Controller {

    private static $LANGUAGE_EXT_MAPPING = array(
        'php' => 'php',
        'java' => 'java',
        'cs' => 'csharp',
        'c' => 'c',
        'cpp' => 'cpp',
        'd' => 'd',
        'cfm' => 'cfm',
        'js' => 'javascript',
        'html' => 'html5',
    );

    public function displayInfo() {
        return 'nothing here';
    }

    protected static function getCache() {
        $cacheDir = sys_get_temp_dir();
        $adapter = new File($cacheDir);
        $adapter->setOption('ttl', 3600);
        return new Cache($adapter);
    }

    public static function displayFileStatic($request, $response, $service) {
        $cache = static::getCache();
        $requestIdentifier = sha1(sprintf('%s---%s---%s', $request->user, $request->repo, $request->file));

        // try to find request in cache
        $formattedCode = $cache->get($requestIdentifier);

        if (!$formattedCode) {

            $client = new \Github\Client();
            $fileContent = $client->api('repo')->contents()->download($request->user, $request->repo, $request->file);

            // set language based on file extension
            $fileExtension = substr(strrchr($request->file, '.'), 1);
            $language = '';
            if (array_key_exists($fileExtension, static::$LANGUAGE_EXT_MAPPING)) {
                $language = static::$LANGUAGE_EXT_MAPPING[$fileExtension];
            }

            // get highlighted code using geshi
            $geshi = & new \GeSHi($fileContent, $language);
            $formattedCode = $geshi->parse_code();

            // put result in cache to speed up future request
            $cache->set($requestIdentifier, $formattedCode);
        }

        $uniqId = 'githubist' . uniqid();

        return $service->render(__DIR__ . '/views/file_static.phtml', array('fileName' => basename($request->file), 'formattedCode' => $formattedCode, 'uniqId' => $uniqId));
    }

    public static function displayFileJs($request, $response, $service) {
        $client = new \Github\Client();
        $fileContent = $client->api('repo')->contents()->download($request->user, $request->repo, $request->file);

        $uniqId = 'githubist' . uniqid();

        return $service->render(__DIR__ . '/views/file_js.phtml', array('fileName' => basename($request->file), 'fileContent' => $fileContent, 'uniqId' => $uniqId));
    }

}
