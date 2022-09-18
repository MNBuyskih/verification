<?php

namespace Sitedata\Controllers;

use \Main\DatabaseTable;
use \Main\Authentication;

class Certificate
{
    private $holderTable;
    private $certificatesTable;
    private $authentication;

    public function __construct(DatabaseTable $certificatesTable, DatabaseTable $holderTable, Authentication $authentication)
    {
        $this->certificatesTable = $certificatesTable;
        $this->holderTable = $holderTable;
        $this->authentication = $authentication;
    }

    public function list()
    {
        $result = $this->certificatesTable->findAll();

        $certificates = [];
        foreach ($result as $certificate) {
            $holder = $this->holderTable->findById($certificate['authorId']);

            $certificates[] = [
                'id' => $certificate['id'],
                'date' => $certificate['date'],
                'vehicle' => $certificate['vehicle'],
                'taho' => $certificate['taho'],
                'authorId' => $holder['name']               
            ];
        }

        $title = '-=Certificates=-';

        $totalCertificates = $this->certificatesTable->total();

        $holder = $this->authentication->getUser();

        return [
            'template' => 'certificates.html.php',
            'title' => $title,
            'variables' => [
            'totalCertificates' => $totalCertificates, 
            'certificates' => $certificates,
            'userId' => $holder['id'] ?? null
            ]
        ];
    }

    public function home()
    {
        $title = 'Certificates';

        return ['template' => 'home.html.php', 'title' => $title];
    }

    public function delete()
    {

        $author = $this->authentication->getUser();

        $certificate = $this->certificatesTable->findById($_POST['id']);

        if ($certificate['authorId'] != $author['id']) {
            return;
        }

        $this->certificatesTable->delete($_POST['id']);

        header('location: /certificates/list');
    }

    public function saveEdit()
    {
        $author = $this->authentication->getUser();

        if (isset($_GET['id'])) {
            $verification = $this->certificatesTable->findById($_GET['id']);

            if ($verification['authorId'] != $author['id']) {
                return;
            }
        }

        $verification = $_POST['verification'];
        $verification['date'] = new \DateTime();
        $verification['authorId'] = $author['id'];

        $this->certificatesTable->save($verification);

        header('location: /certificates/list');
    }

    public function edit()
    {
        $holder = $this->authentication->getUser();

        if (isset($_GET['id'])) {
            $certificate = $this->certificatesTable->findById($_GET['id']);
        }

        $title = 'Edit joke';

        return [
            'template' => 'certificatesEdit.html.php',
            'title' => $title,
            'variables' => [
                'certificate' => $certificate ?? null,
                'userId' => $holder['id'] ?? null
            ]
        ];
    }
}
