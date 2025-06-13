<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Repositories\Book\BookInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
     *     operationId="listBooks",
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
     *     operationId="listBooksByCategorySlug",
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
     * Store a newly created resource in storage.
     */

    /**
     * @author Hungha
     * @OA\Post (
     *     path="/api/cms/books/store",
     *     tags={"CMS Books"},
     *     summary="Thêm book",
     *     operationId="books/store",
     *     @OA\Parameter(
     *          in="header",
     *          name="X-localication",
     *          required=false,
     *          description="Ngôn ngữ",
     *          @OA\Schema(
     *            type="string",
     *            example="vi",
     *          )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dữ liệu sách cần thêm",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string", example="Tên book"),
     *             @OA\Property(property="description", type="string", example="Mô tả"),
     *             @OA\Property(property="author_id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", example="draft"),
     *             @OA\Property(property="price", type="number", format="float", example=99.99),
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="publisher_id", type="integer", example=1),
     *             @OA\Property(property="published_at", type="string", format="date", example="2002-09-29"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Success."),
     *          )
     *     ),
     * )
     */
    public function store(BookRequest $request)
    {
        //
        Log::debug(' Request data:', $request->all());
        $data = $request->validated();
        $book = $this->bookRepository->createOrUpdate($data);
        return response()->json([
            'data' => $book,
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
     *     operationId="bookDetail",
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

    /**
     * Update the specified resource in storage.
     */
    /**
     * @author Hungha
     * @OA\Put (
     *     path="/api/cms/books/update/{id}",
     *     tags={"CMS Books"},
     *     summary="Sửa book",
     *     security={{"bearerAuth":{}}},
     *     operationId="books/update",
     *     @OA\Parameter(
     *          in="header",
     *          name="X-localication",
     *          required=false,
     *          description="Ngôn ngữ",
     *          @OA\Schema(
     *            type="string",
     *            example="vi",
     *          )
     *     ),
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          description="Id của book",
     *          @OA\Schema(
     *            type="number",
     *            example="1",
     *          )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dữ liệu",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string", example="Tên book"),
     *             @OA\Property(property="description", type="string", example="Mô tả"),
     *             @OA\Property(property="author_id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", example="draft"),
     *             @OA\Property(property="price", type="number", format="float", example=99.99),
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="publisher_id", type="integer", example=1),
     *             @OA\Property(property="published_at", type="string", format="date", example="2002-09-29"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *             @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Success."),
     *          )
     *     ),
     * )
     */
    public function update(BookRequest $request, $id)
    {
        //
        $data = $request->all();
        // Log::debug('id', ['id' => $id]);
        // Log::debug('data', ['data' => $data]);
        // return response()->json([]) 
        return response()->json([
            'data' => $this->bookRepository->createOrUpdate($data, ['id' => $id]),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
