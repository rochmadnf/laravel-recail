<?php

namespace Rochmadnf\Recail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\HtmlString;
use ReflectionException;

class ReactMailable extends Mailable
{
    /**
     * Override buildView from Mailable to render react-email emails instead of blade views
     *
     * @throws ReflectionException
     */
    protected function buildView(): array
    {
        return array_map(
            fn ($content) => new HtmlString($content),
            Renderer::render($this->view, $this->buildViewData())
        );
    }
}
