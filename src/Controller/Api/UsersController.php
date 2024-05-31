<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Utility\Text;
use Cake\View\JsonView;
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

    #[OpenApiHeader(name: 'X-Authorization-Token', type: 'string', description: 'Token')]
    #[OpenApiHeader(name: 'X-CSRF-TOKEN', type: 'string', description: 'csrf_token')]
    public function login()
    {
        $this->request->allowMethod(['post']);
        //$this->request->withHeader('Authorization'));
        $user = $this->Authentication->getResult()->getData();
        if ($user) {
            // Générer un token unique
            $data = [
                'success' => true,
                'data' => [
                    'token' => $user->token
                ]
            ];
        } else {
            $data = [
                'success' => false,
                'message' => 'Invalid username or password'
            ];
        }
        $this->set(compact('data'));
        $this->viewBuilder()->setOption('serialize', 'data');
    }
}
