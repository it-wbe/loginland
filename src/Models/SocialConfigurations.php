<?php

namespace Wbe\Login\Models;

use Wbe\Crud\Models\ContentTypes\ContentTypeFields;
use Wbe\Crud\Models\Translatable;

class SocialConfigurations extends \Eloquent
{
    public $timestamps = false;
    protected $table = 'social_configurations';
}