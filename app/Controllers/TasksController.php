<?php

namespace App\Controllers;

use App\Models\Task;
use App\Repositories\CsvTasksRepository;
use App\Repositories\MySqlRepository;
use App\Repositories\TasksRepository;
use Ramsey\Uuid\Uuid;

class TasksController
{
    private TasksRepository $tasksRepository;

    public function __construct()
    {
        $this->tasksRepository = new MySqlRepository();
    }

    public function index()
    {
        $tasks = $this->tasksRepository->getAll($_GET);
        require_once "app/Views/show.template.php";
    }

    public function create()
    {
        require_once "app/Views/create.template.php";
    }

    public function store()
    {
        $task = new Task(
            Uuid::uuid4(),
            $_POST['title']
        );
        $this->tasksRepository->save($task);
        header('Location /tasks');
    }

    public function delete(array $vars)
    {
        $id = $vars['id'] ?? null;
        if ($id == null) header('Location: /');
        $task = $this->tasksRepository->getOne($id);

        if ($task !== null) {
            $this->tasksRepository->delete($task);
        }

        header('Location /tasks');
    }

    public function show(array $vars)
    {
        $id = $vars['id'] ?? null;
        if ($id == null) header('Location: /');
        $task = $this->tasksRepository->getOne($id);

        if ($task === null) header('Location: /');

        require_once 'app/Views/show.template.php';
    }
}