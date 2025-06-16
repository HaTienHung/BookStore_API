<?php

namespace App\Http\Controllers\APP;


use App\Http\Controllers\Controller;
use App\Repositories\Book\BookInterface;


class BookController extends Controller
{
    protected $bookRepository;

    public function __construct(BookInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/api/app/books",
     *     tags={"APP"},
     *     summary="Danh sách Books ",
     *     operationId="app_book_list",
     *     @OA\Parameter(
     *         in="header",
     *         name="X-localication",
     *         required=false,
     *         description="Ngôn ngữ hiển thị",
     *         @OA\Schema(type="string", example="vi")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách sách thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Success."),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        //
        return response()->json([
            'data' => $this->bookRepository->all()
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/app/collection/{slug}",
     *     tags={"APP"},
     *     summary="Lấy danh sách Books theo category slug",
     *     operationId="app_book_listBySlug",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug của danh mục",
     *         @OA\Schema(type="string", example="van-hoc")
     *     ),
     *     @OA\Parameter(
     *         in="header",
     *         name="X-localication",
     *         required=false,
     *         description="Ngôn ngữ hiển thị",
     *         @OA\Schema(type="string", example="vi")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách sách thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Success."),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */

    public function listBooksByCategorySlug(string $slug)
    {
        return response()->json([
            'data' => $this->bookRepository->getBooksByCategorySlug($slug)
        ]);
    }
    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/app/books/{slug}",
     *     tags={"APP"},
     *     summary="Chi tiết thông tin của Book",
     *     operationId="app_book_detailBySlug",
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         description="Slug của book",
     *         @OA\Schema(type="string", example="van-hoc")
     *     ),
     *     @OA\Parameter(
     *         in="header",
     *         name="X-localication",
     *         required=false,
     *         description="Ngôn ngữ hiển thị",
     *         @OA\Schema(type="string", example="vi")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách sách thành công",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Success."),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function show(string $slug)
    {
        //
        return response()->json([
            'data' => $this->bookRepository->findBy('slug', $slug),
        ]);
    }
}
