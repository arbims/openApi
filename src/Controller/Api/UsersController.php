<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Utility\Text;
use Cake\View\JsonView;
use Firebase\JWT\JWT;
use SwaggerBake\Lib\Attribute\OpenApiForm;
use SwaggerBake\Lib\Attribute\OpenApiHeader;
use SwaggerBake\Lib\Attribute\OpenApiRequestBody;
use SwaggerBake\Lib\Attribute\OpenApiSecurity;

class UsersController extends AppController
{

    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    /**
     * beforeFilter
     *
     * @param  mixed $event
     * @return void
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        $this->Authentication->allowUnauthenticated(['login']);
    }

    #[OpenApiForm(name: "email", type: "string")]
    #[OpenApiForm(name: "password", type: "string")]
    public function login()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $privateKey = file_get_contents(CONFIG . '/jwt.key');
            $user = $result->getData();
            $payload = [
                'iss' => 'myapp',
                'sub' => $user->id,
                'exp' => time() + 60,
            ];
            $json = [
                'token' => JWT::encode($payload, $privateKey, 'RS256'),
            ];
        } else {
            $this->response = $this->response->withStatus(401);
            $json = [];
        }
        $this->set(compact('json'));
        $this->viewBuilder()->setOption('serialize', 'json');
    }
}
