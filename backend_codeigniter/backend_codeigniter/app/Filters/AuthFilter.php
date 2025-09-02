<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null){
        $header = $request->getHeaderLine('Authorization');
        if(!$header) {
            $res = service('response');
            $res->setStatusCode(401);
            $res->setJSON(['error'=>'Missing Authorization header']);
            $res->send();
            exit;
        }

        if(preg_match('/Bearer\s+(.*)$/i', $header, $matches)){
            $token = $matches[1];
        } else {
            $res = service('response');
            $res->setStatusCode(401);
            $res->setJSON(['error'=>'Invalid Authorization header']);
            $res->send();
            exit;
        }

        try{
            $secret = getenv('JWT_SECRET') ?: 'supersecretkeyyoushouldchange';
            $decoded = JWT::decode($token, new Key($secret, 'HS256'));
            // attach to request if needed
            return;
        } catch(\Exception $e){
            $res = service('response');
            $res->setStatusCode(401);
            $res->setJSON(['error'=>'Invalid token: '.$e->getMessage()]);
            $res->send();
            exit;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){ }
}
