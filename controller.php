<?php

require_once 'Service/TaskService.php';

if(!isset($_GET['action']))
    die('error');

switch ($_GET['action'])
{
    case 'addTask':
        echo(json_encode($_GET));
        break;

    case 'getTask':
        $task = new TaskService();
        $task = $task->getTask($_GET['id']);
        echo(encodeTaskJSON($task));
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
function encodeTaskJSON($task)
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

    foreach($labels AS $label)
    {
        $taskArr['labels'][ $label->getId() ] = $label->getName();
    }
    return json_encode($taskArr);
}
