<?php

/**
 * UserController - This allows add, delete and edit users
 * @autor Francis Gonzales <fgonzalestello91@gmail.com>
 */

namespace Panel\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Panel\Form\UserForm;
use Panel\DataSource\OracleSelect;
use ZfcDatagrid\Column;

class UserController extends AbstractActionController
{
    public function listAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $postData = $request->getPost();
        }
        
        $sl = $this->getServiceLocator();
        $objUsuario = $sl->get('Panel\Model\GeUsuarioTable');
        $objUsuarioRol = $sl->get('Panel\Model\GeUsuarioRolTable');
        $objOracle = $sl->get('Application\Db\Oracle');
        $grid = $sl->get('ZfcDatagrid\Datagrid');
        $grid->setDefaultItemsPerPage(15);
        $grid->setToolbarTemplate('layout/export-toolbar');
        $usuarioRol = $objUsuario->getUsersList($objUsuarioRol);
        
        
        $usuarioRol = $objUsuario->getUsersList($objUsuarioRol);
        $objOracleSelect = new OracleSelect($usuarioRol, $objOracle);
        
        $grid->setDataSource($objOracleSelect);
     
        $col = new Column\Select('CODIGO_USUARIO');
        $col->setLabel('User');
        $col->setWidth(20);
        $grid->addColumn($col);
        $grid->render();

        return $grid->getResponse();
    }
}