<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Book Store API",
 *     version="0.1"
 * )
 * @OA\PathItem (
 *     path="/api/documentation",
 *     ),
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller {}
