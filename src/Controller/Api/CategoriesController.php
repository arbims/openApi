<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\View\JsonView;
use SwaggerBake\Lib\Attribute\OpenApiHeader;
use SwaggerBake\Lib\Attribute\OpenApiPaginator;
use SwaggerBake\Lib\Attribute\OpenApiQueryParam;
use SwaggerBake\Lib\Attribute\OpenApiSecurity;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    #[OpenApiPaginator]
    #[OpenApiHeader(name: 'X-Authorization-Token', type: 'string', description: 'token bearer')]
    public function index()
    {
        $this->request->allowMethod('get');
        $categories = $this->paginate($this->Categories);

        $this->set(compact('categories'));
        $this->viewBuilder()->setOption('serialize', 'categories');
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     */
    public function view($id = null)
    {
        $this->request->allowMethod('get');
        $category = $this->Categories->get($id, [
            'contain' => [],
        ]);

        $this->set('category', $category);
        $this->viewBuilder()->setOption('serialize', 'category');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\OpenApiExceptionSchema
     * @throws \Exception
     */
    #[OpenApiHeader(name: 'X-Authorization-Token', type: 'string', description: 'token bearer')]
    public function add()
    {
        $this->request->allowMethod('post');
        $category = $this->Categories->newEmptyEntity();
        $category = $this->Categories->patchEntity($category, $this->request->getData());
        if ($this->Categories->save($category)) {
            $this->set('category', $category);
            $this->viewBuilder()->setOption('serialize', 'category');

            return;
        }
        throw new \Exception("Record not created");
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \MixerApi\ExceptionRender\OpenApiExceptionSchema
     * @throws \Exception
     */
    #[OpenApiHeader(name: 'X-Authorization-Token', type: 'string', description: 'token bearer')]
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $category = $this->Categories->get($id, [
            'contain' => [],
        ]);
        $category = $this->Categories->patchEntity($category, $this->request->getData());
        if ($this->Categories->save($category)) {
            $this->set('category', $category);
            $this->viewBuilder()->setOption('serialize', 'category');

            return;
        }
        throw new \Exception("Record not saved");
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException
     * @throws \Cake\Http\Exception\MethodNotAllowedException
     * @throws \Exception
     */
    #[OpenApiHeader(name: 'X-Authorization-Token', type: 'string', description: 'token bearer')]
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            return $this->response->withStatus(204);
        }
        throw new \Exception("Record not deleted");
    }
}
