<?php

namespace Modules\Blog\Models;

use  Modules\Core\Models\Traits\TranslatableJson;

class Tag extends \Spatie\Tags\Tag
{
    use TranslatableJson;
}
