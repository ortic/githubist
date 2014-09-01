<?php

namespace Ortic\Githubist;

class Controller
{
    public function displayInfo()
    {
        return 'nothing here';
    }
    
    public static function displayFile($request)
    {
        $client = new \Github\Client();
        $fileContent = $client->api('repo')->contents()->download($request->user, $request->repo, $request->file);
        return $fileContent;
    }
}