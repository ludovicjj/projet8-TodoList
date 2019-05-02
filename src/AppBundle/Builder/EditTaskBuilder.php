<?php

namespace AppBundle\Builder;

use AppBundle\DTO\TaskDTO;
use AppBundle\Entity\Task;

class EditTaskBuilder
{
    /**
     * @param TaskDTO $dto
     * @param Task $task
     * @throws \Exception
     */
    public static function build(TaskDTO $dto, Task $task)
    {
        $task->update(
            $dto->title,
            $dto->content
        );

        $task->onUpdatedAt();
    }
}
