<?php

namespace Controllers;

use OpenApi\Annotations as OA;

define('APP_URL', _env(key: 'APP_URL'));

/**
 * This is the base controller for your Leaf API Project.
 * You can initialize packages or define methods here to use
 * them across all your other controllers which extend this one.
 */

/**
 * @OA\Info(
 *      title="Otus homework 17 API",
 *      version="0.1",
 *      @OA\Contact(
 *          email="ant-shvedov@yandex.ru"
 *      )
 * )
 *
 * @OA\SecurityScheme(
 *   type="oauth2",
 *   securityScheme="app_auth",
 *   @OA\Flow(
 *      tokenUrl="/api/v1/login",
 *      flow="password",
 *      scopes={
 *         "read": "read operations are available to the user",
 *         "write": "write operations are available to the user"
 *      }
 *   )
 * )
 *
 * @OA\Server(url=APP_URL)
 *
 * @OA\Schema(
 *     schema="task_uuid",
 *     @OA\Property(
 *         property="uuid",
 *         type="string",
 *         example="a4a4cc90-3de8-439c-bc25-9e1bc455a9fb"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="task_completed",
 *     @OA\Property(
 *         property="uuid",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="result",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="timestamp"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="timestamp"
 *     )
 * )
 *
 * @OA\Examples(
 *     example="task_completed",
 *     value={
 *         "uudi":"a4a4cc90-3de8-439c-bc25-9e1bc455a9fb",
 *         "status":"COMPLETED",
 *         "result":"{'Status':0,'TC':false,'RD':true,'RA':true,'AD':false,'CD':false,'Question':[{'name':'www.xyz.com.','type':28}],'Answer':[{'name':'www.xyz.com.','type':5,'TTL':356,'data':'xyz.com.'}],'Authority':[{'name':'xyz.com.','type':6,'TTL':216,'data':'ns-1664.awsdns-16.co.uk. awsdns-hostmaster.amazon.com. 1 7200 900 1209600 86400'}]}",
 *         "created_at":"2023-03-08 14:44:33",
 *         "updated_at_at":"2023-03-08 14:44:42",
 *     },
 *     summary="task completed response"
 * )
 *
 * @OA\Schema(
 *     schema="task_pending",
 *     @OA\Property(
 *         property="uuid",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="result",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="timestamp"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="timestamp"
 *     )
 * )
 *
 * @OA\Examples(
 *     example="task_pending",
 *     value={
 *         "uudi":"a4a4cc90-3de8-439c-bc25-9e1bc455a9fb",
 *         "status":"PENDING",
 *         "result":"",
 *         "created_at":"2023-03-08 14:44:33",
 *         "updated_at_at":"2023-03-08 14:44:42",
 *     },
 *     summary="task pending response"
 * )
 */

class Controller extends \Leaf\Controller
{
    //
}
