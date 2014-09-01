<?php

namespace Ortic\Githubist;

class Controller
{
    public function displayInfo()
    {
        return 'nothing here';
    }
    
    public static function displayFile($request, $response, $service)
    {
        $client = new \Github\Client();
        $fileContent = $client->api('repo')->contents()->download($request->user, $request->repo, $request->file);

        $uniqId = 'githubist' . uniqid();
        
        return $service->render(__DIR__ . '/views/file.phtml', array('fileName' => basename($request->file), 'fileContent' => $fileContent, 'uniqId' => $uniqId));
    }
}