<?php

namespace AppBundle\Factory\DTO;

use AppBundle\DTO\TaskDTO;
use AppBundle\Entity\Task;

class TaskDTOFactory
{
    /**
     * @param Task $task
     * @return TaskDTO
     */
    public static function create(Task $task)
    {
        $taskDTO = new TaskDTO(
            $task->getTitle(),
            $task->getContent()
        );

        return $taskDTO;
    }
}
