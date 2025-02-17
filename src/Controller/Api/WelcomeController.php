<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\View\JsonView;
use MixerApi\Welcome;
use SwaggerBake\Lib\Attribute\OpenApiResponse;

class WelcomeController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    /**
     * Welcome to MixerAPI
     *
     * Welcome to MixerAPI. This endpoint will return information on your environment, CakePHP, and MixerAPI.
     *
     * You can modify or delete this endpoint in `config/routes.php`
     *
     * You can modify or delete this controller in `src/Controller/WelcomeController.php`
     *
     * You can see the sample schema in `config/swagger.yml` > `#/components/schemas/Welcome`
     *
     * @link https://mixerapi.com MixerAPI documentation
     * @return \Cake\Http\Response|null|void
     * @throws \RuntimeException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    #[OpenApiResponse(ref: '#/components/schemas/Welcome')]
    public function info()
    {
        $this->request->allowMethod('get');
        $info = (new Welcome())->info();
        $this->set(compact('info'));
        $this->viewBuilder()->setOption('serialize', 'info');
    }

    public function csrf()
    {
        $csrf = ['csrf' => $this->request->getAttribute('csrfToken')];
        $this->set(compact('csrf'));
        $this->viewBuilder()->setOption('serialize', 'csrf');
    }
}
