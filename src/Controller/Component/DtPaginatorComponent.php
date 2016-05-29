<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller\Component;

use Cake\Controller\Component\PaginatorComponent;

/**
 * Description of DtPaginatorComponent
 *
 * @author AnhKiet
 */
class DtPaginatorComponent extends PaginatorComponent {

    /**
     * Rewite paginate method for dbtable
     * 
     * @param Table $object
     * @param array $settings
     * @return array
     */
    public function paginate($object, array $settings = array()) {
        $data = parent::paginate($object, $settings);
        $request = $this->_registry->getController()->request;
        $draw = $request->query('draw') ? $request->query('draw') : 0;
        $alias = $alias = $object->alias();
        $paging = $request->params['paging'][$alias];
        return [
            'draw' => $draw,
            'data' => $data,
            'recordsFiltered' => $paging['count'],
            'recordsTotal' => $paging['count'],
            'page' => $paging['page'] ? $paging['page'] : 1,
            'limit' => (int)($paging['limit'] ? $paging['limit'] : $settings['limit']),
            'defaultLimit' => $settings['limit'],
            'sort' => str_replace($alias . ".", "", $paging['sort']),
            'direction' => $paging['direction']
        ];
    }

}
