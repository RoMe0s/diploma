<?php

namespace App\Services\Handlers\Author\Task;

use App\Models\Task;
use App\Services\Text\Helper;

class Update
{
    /**
     * @var Helper
     */
    private $helper;

    /**
     * Update constructor.
     * @param Helper $helper
     */
    function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @param Task $task
     * @param array $data
     */
    public function update(Task $task, array $data): void
    {
        $this->helper->setHtml($data['content']);

        $task->text()->update([
            'content' => $this->helper->getHtml(),
            'length' => $this->helper->length(),
            'name' => $data['name'] ?? null
        ]);
    }
}