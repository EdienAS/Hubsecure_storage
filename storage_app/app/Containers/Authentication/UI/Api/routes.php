<?php
/**
 * @SWG\Swagger(
 *     schemes={"http"},
 *     host="api.mynutribox.com",
 *     basePath="/v1/",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Nutribox",
 *     ),
 *     @SWG\SecurityScheme(
 *         securityDefinition="Bearer",
 *         type="apiKey",
 *         name="Authorization",
 *         in="header"
 *     ),
 * )
 */

/**
 * @var $router Dingo\Api\Routing\Router
 */

require 'Routes/auth.php';
