<?php

namespace Sitedata;

class CertificatesRoutes implements \Main\Routes
{
    private $authorsTable;
    private $certificatesTable;
    private $vehiclesTable;
    private $authentication;

    public function __construct()
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';

        $this->certificatesTable = new \Main\DatabaseTable($pdo, 'certificates', 'id');
        $this->authorsTable = new \Main\DatabaseTable($pdo, 'author', 'id');
        $this->vehiclesTable = new \Main\DatabaseTable($pdo, 'vehicles', 'id');
        $this->tahoTable = new \Main\DatabaseTable($pdo, 'taho', 'id');
        $this->vehiclesownersTable = new \Main\DatabaseTable($pdo, 'vehiclesowners', 'id');
        $this->authentication = new \Main\Authentication($this->authorsTable, 'email', 'password');
    }

    public function getRoutes(): array
    {
        $certificatesController = new \Sitedata\Controllers\Certificate($this->certificatesTable, $this->authorsTable, $this->authentication);
        $authorController = new \Sitedata\Controllers\Register($this->authorsTable);
        $userController = new \Sitedata\Controllers\Author($this->authorsTable, $this->authentication);
        $vehiclesController = new \Sitedata\Controllers\Vehicles($this->vehiclesTable);
        $vehiclesownersController = new \Sitedata\Controllers\Vehiclesowners($this->vehiclesownersTable, $this->authentication);
        $tahoController = new \Sitedata\Controllers\Taho($this->tahoTable);
        $loginController = new \Sitedata\Controllers\Login($this->authentication);

        $routes = [
            'author/register' => [
                'GET' => [
                    'controller' => $authorController,
                    'action' => 'registrationForm'
                ],
                'POST' => [
                    'controller' => $authorController,
                    'action' => 'registerUser'
                ]
            ],
            'author/success' => [
                'GET' => [
                    'controller' => $authorController,
                    'action' => 'success'
                ]
            ],
            'certificates/edit' => [
                'POST' => [
                    'controller' => $certificatesController,
                    'action' => 'saveEdit'
                ],
                'GET' => [
                    'controller' => $certificatesController,
                    'action' => 'edit'
                ],
                'login' => true

            ],
            'certificate/delete' => [
                'POST' => [
                    'controller' => $certificatesController,
                    'action' => 'delete'
                ],
                'login' => true
            ],
            'joke/list' => [
                'GET' => [
                    'controller' => $certificatesController,
                    'action' => 'list'
                ]
            ],
            'login/error' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'error'
                ]
            ],
            'login/success' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'success'
                ]
            ],
            'logout' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'logout'
                ]
            ],
            'login' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'loginForm'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'action' => 'processLogin'
                ]
            ],
            'certificates/list' => ['GET' => ['controller' => $certificatesController, 'action' => 'list'], 'login' => true],
            'certificates/edit' => ['GET' => ['controller' => $certificatesController, 'action' => 'saveEdit'], 'login' => true],
            'certificates/delete' => ['GET' => ['controller' => $certificatesController, 'action' => 'delete'], 'login' => true],
            'vehicles/list' => ['GET' => ['controller' => $vehiclesController, 'action' => 'list'], 'login' => true],
            'taho/list' => ['GET' => ['controller' => $tahoController, 'action' => 'list'], 'login' => true],
            'taho/edit' => ['GET' => ['controller' => $tahoController, 'action' => 'saveEdit'], 'login' => true],
            'users/list' => ['GET' => ['controller' => $userController, 'action' => 'list'], 'login' => true],
            'vehiclesowners/list' => ['GET' => ['controller' => $vehiclesownersController, 'action' => 'list'], 'login' => true],
            'vehiclesowners/edit' => ['GET' => ['controller' => $vehiclesownersController, 'action' => 'saveEdit'], 'login' => true],
            '' =>                  ['GET' => ['controller' => $certificatesController, 'action' => 'home']]
        ];

        return $routes;
    }

    public function getAuthentication(): \Main\Authentication
    {
        return $this->authentication;
    }
}
