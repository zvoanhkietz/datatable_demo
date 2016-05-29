<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Event\Event;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class AdminController extends AppController {

    /**
     * 
     */
    public function initialize() {
        parent::initialize();
        $this->loadModel('Users');
        $this->loadComponent('Paginator', [
            'className' => 'App\Controller\Component\DtPaginatorComponent'
        ]);

        // response json with aja request
        if ($this->request->is('ajax')) {
            $this->set('_serialize', true);
            $this->RequestHandler->renderAs($this, 'json');
        } else {
            $this->viewBuilder()->layout('admin');
        }
    }

    /**
     * 
     * @param \Cake\Event\Event $event
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);

        // set limit from request
        if ($limit = $this->request->query('limit')) {
            $this->paginate['limit'] = $limit;
        }
    }

}
