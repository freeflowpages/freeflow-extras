<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

use humhub\components\Application;

/** @noinspection MissedFieldInspection **/
return [
    'id' => 'freeflow_extras',
    'class' => 'humhub\modules\freeflow_extras\Module',
    'namespace' => 'humhub\modules\freeflow_extras',
    'events' => [
        [Application::class, Application::EVENT_BEFORE_REQUEST, ['\humhub\modules\freeflow_extras\Events', 'onBeforeRequest']]
    ]
];
?>
