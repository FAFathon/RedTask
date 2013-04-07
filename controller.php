<?php

require_once 'Service/TaskService.php';

if(!isset($_GET['action']))
    die('error');

switch ($_GET['action'])
{
    case 'addTask':
        $task = new TaskService();
        echo(json_encode($task->addTask($_POST['title'])));
        break;

    case 'editTask':
        $data = json_decode($_POST['data']);
        $data = get_object_vars($data);
        $id = $data['id'];
        unset($data['id']);

        $data['deadline'] = $data['dl_date'] . " " . $data['dl_time'] . ":00";
        unset($data['dl_date']);
        unset($data['dl_time']);
        unset($data['hour']);
        unset($data['minute']);
        unset($data['label']);

        //var_dump($data);
        $task = new TaskService();
        $task->editTask($id, $data);
        echo(json_encode(true));
        break;

    case 'getTask':
        $task = new TaskService();
        $task = $task->getTask($_GET['id']);
        echo(encodeTask(json_encode($task)));
        break;

    case 'getTasks':
        $task = new TaskService();
        $tasks = $task->getTasks();
        $result = array();
        foreach($tasks AS $elm)
        {
            $result[] = encodeTask($elm);
        }

        echo(json_encode($result));
        break;

    default:
        die('Unimplemented.');
        break;
}

/**
*
* @param object $task A task object which contains the labels also.
* @return string JSON encoded array.
*/
function encodeTask($task)
{
    $taskArr = array();
    $taskArr['id'] = $task->getId();
    $taskArr['title'] = $task->getTitle();
    $taskArr['description'] = $task->getDescription();
    $taskArr['deadline'] = $task->getDeadline();
    $taskArr['time_estimated'] = $task->getTimeEstimated();
    $taskArr['time_spent'] = $task->getTimeSpent();
    $taskArr['priority'] = $task->getPriority();
    $taskArr['progress'] = $task->getProgress();
    $taskArr['weight'] = $task->getWeigth();
    $taskArr['labels'] = array();
    $labels = $task->getLabels();

    /*foreach($labels AS $label)
    {
        $taskArr['labels'][ $label->getId() ] = $label->getName();
    }*/
    return $taskArr;
}
