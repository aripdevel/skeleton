<?php

$project = dir(realpath("."));

$replacer=basename(realpath("."));

/** Create directory for namespace App */

(is_dir($project->path) ? mkdir('app') : exit());
(is_dir($project->path) ? mkdir('tests') : exit()); 

foreach( glob(__DIR__.DIRECTORY_SEPARATOR."file/*.*") as $file){

    /** Copy sources */

    $target= $project->path . DIRECTORY_SEPARATOR . basename($file);

    copy($file,$target);

    /** Editing composer.json */

    applyComposerjson($target,$replacer);
}

function applyComposerjson($file, $replacer)
{

    $er = file_get_contents($file);

    file_put_contents($file, str_replace("{{projectname}}", $replacer, $er));
}

function delTree($dir){

    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

/** Delete src dir */

delTree("src");
