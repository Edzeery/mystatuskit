<?php

namespace Edzeery\MyStatusKit\View\Components;

use Illuminate\View\Component;
use Edzeery\MyStatusKit\Facades\Status;

class StatusBadge extends Component
{
    public $result;

    public function __construct(
        public string $domain,
        public string $status,
        public ?string $set = null,
        public ?string $class = null,
    ) {
        $this->result = Status::for($domain, $status);
    }

    public function render()
    {
        return view('status-kit::components.status-badge');
    }
}
