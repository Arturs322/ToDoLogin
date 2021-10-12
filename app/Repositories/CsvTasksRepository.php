<?php

namespace App\Repositories;

use App\Models\Collections\TasksCollection;
use App\Models\Task;
use Carbon\Carbon;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;

class CsvTasksRepository implements TasksRepository
{
    private Reader $reader;

    public function __construct()
    {
        $this->reader = Reader::createFromPath(base_path() . 'storage/tasks.csv');
        $this->reader->setDelimiter(';');

    }

    public function getAll(array $filters = []): TasksCollection
    {
        $collection = new TasksCollection();
        $statement = Statement::create()
            ->orderBy(function (array $a, array $b) {
                $timeA = new Carbon($a[3]);
                $timeB = new Carbon($b[3]);

                return $timeA->eq($timeB) ? 0 : ($timeA->lessThan($timeB) ? 1 : -1);
            });
        if (isset($filters['title'])) {
            $statement = $statement->where(function (array $record) use ($filters) {
                return $record[1] === $filters['title'];
            });
        }
        if (isset($filters['status'])) {
            $statement = $statement->where(function (array $record) use ($filters) {
                return $record[2] === $filters['status'];
            });
        }
        foreach ($statement->process($this->reader) as $record) {
            $collection->add(new Task(
                $record[0],
                $record[1],
                $record[2],
                $record[3]
            ));
        }
        return $collection;
    }

    public function save(Task $task): void
    {
        $writer = Writer::createFromPath(base_path() . 'storage/tasks.csv', 'a+');
        $writer->setDelimiter(';');
        $writer->insertOne($task->toArray());
    }

    public function getOne(string $id): ?Task
    {
        $statement = Statement::create()
            ->where(function ($record) use ($id) {
                return $record[0] === $id;
            })->limit(1);
        $record = $statement->process($this->reader)->fetchOne();

        if (empty($record)) return null;
        return new Task(
            $record[0],
            $record[1],
            $record[2],
            $record[3],
        );
    }

    public function delete(Task $task): void
    {
        $tasks = $this->getAll();
        unset($tasks[$task->getId()]);

        $records = [];

        foreach ($tasks as $task) {
            /** @var Task $task */
            $records[] = $task->toArray();
        }

        $writer = Writer::createFromPath(base_path() . 'storage/tasks.csv', 'w');
        $writer->setDelimiter(';');
        $writer->insertAll($records);
    }
}