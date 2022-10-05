<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\ConfigInterface;
use App\Model\Model;
use App\Model\SendMessageInterface;
use App\View\View;

class Main
{
    protected $model;
    protected $view;
    protected $config;
    protected $messenger;

    public function __construct(ConfigInterface $config, SendMessageInterface $messenger)
    {
        $this->model = new Model($config, $messenger);
        $this->view = new View();
    }

    public function startPage()
    {
        $this->view->generate('indexTemplate.php');
    }

    public function consumerStart()
    {
        $result = $this->model->consumerStart();
        $this->view->generate('messageTemplate.php', $result);
    }

    public function consumerStop()
    {
        $result = $this->model->consumerStop();
        $this->view->generate('messageTemplate.php', $result);
    }

    public function startReportGenerator()
    {
        $result = $this->model->startReportGenerator($_POST['dateStart'], $_POST['dateEnd'], $_POST['email']);
        $this->view->generate('messageTemplate.php', $result);
    }
}