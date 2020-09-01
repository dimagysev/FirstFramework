<?php

require_once '../vendor/autoload.php';


try {
    $request = new FirstFramework\Http\Request\Request();
    $data = $request->getQueryParams();
    (new \FirstFramework\Http\Response\Response('test'))->send();
}catch (Throwable $e){
    dump($e);
}
