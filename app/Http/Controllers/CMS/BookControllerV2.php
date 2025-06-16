<?php

namespace App\Http\Controllers\CMS;

use App\Http\Requests\BookRequest;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Repositories\Book\BookInterface;
use App\Services\Book\BookSerivce;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class BookControllerV2 extends Controller
{

  public function __construct(protected BookInterface $bookRepository, protected BookSerivce $bookService)
  {
    $this->bookRepository = $bookRepository;
    $this->bookService = $bookService;
  }
  /**
   * Display a listing of the resource.
   */
  /**
   * @OA\Get(
   *     path="/api/cms/books",
   *     security={{"bearerAuth":{}}},
   *     tags={"CMS Books"},
   *     summary="Danh sách Books ",
   *     operationId="cms_book_list",
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
      'data' => $this->bookService->getBookList()
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
   *     security={{"bearerAuth":{}}},
   *     operationId="cms_book_create",
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
    // Log::debug(' Request data:', $request->all());
    // Log::debug('bool',  Gate::authorize('update', Book::class));
    // Gate::authorize('update', Book::class);
    $data = $request->validated();
    $book = $this->bookService->store($data);
    return response()->json([
      'data' => $book,
    ]);
  }
  /**
   * Display the specified resource.
   */
  /**
   * @OA\Get(
   *     path="/api/cms/books/{id}",
   *     tags={"CMS Books"},
   *     security={{"bearerAuth":{}}},
   *     summary="Chi tiết thông tin của Book",
   *     operationId="cms_book_detail",
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="id của book",
   *         @OA\Schema(type="string", example="1")
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
  public function show(string $id)
  {
    //
    $book = $this->bookRepository->find($id);
    Gate::authorize('view', $book);
    return response()->json([
      'data' => $book,
    ]);
  }
  /**
   * @OA\Get(
   *     path="/api/cms/collection/{id}",
   *     tags={"CMS Books"},
   *     summary="Lấy danh sách Books theo category id",
   *     security={{"bearerAuth":{}}},
   *     operationId="app_book_listById",
   *     @OA\Parameter(
   *         name="id",
   *         in="path",
   *         required=true,
   *         description="id của danh mục",
   *         @OA\Schema(type="string", example="1")
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

  // public function listBooksByCategoryId(int $id)
  // {
  //   return response()->json([
  //     'data' => $this->bookService->getBooksByCategoryId($id)
  //   ]);
  // }
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
   *     operationId="cms_book_update",
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
    $book = $this->bookRepository->find($id);
    // Log::debug('pulisher_id', [$book->publisher_id]);
    Gate::authorize('update', $book);
    return response()->json([
      'data' => $this->bookRepository->createOrUpdate($data, ['id' => $id]),
    ]);
  }
  /**
   * @OA\Delete(
   *     path="/api/cms/books/soft-delete",
   *     tags={"CMS Books"},
   *     security={{"bearerAuth":{}}},
   *     summary="Xoá mềm nhiều Book",
   *     operationId="cms_book_softDelete",
   *     @OA\Parameter(
   *         in="header",
   *         name="X-localication",
   *         required=false,
   *         description="Ngôn ngữ hiển thị",
   *         @OA\Schema(type="string", example="vi")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         description="Danh sách ID cần xoá",
   *         @OA\JsonContent(
   *             required={"ids"},
   *             @OA\Property(
   *                 property="ids",
   *                 type="array",
   *                 @OA\Items(type="integer", example=1)
   *             )
   *         )
   *     ),
   *     @OA\Response(
   *         response=200,
   *         description="Xoá mềm sách thành công",
   *         @OA\JsonContent(
   *             @OA\Property(property="message", type="string", example="Soft delete success."),
   *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
   *         )
   *     ),
   *     @OA\Response(
   *         response=400,
   *         description="Thiếu danh sách ID",
   *         @OA\JsonContent(
   *             @OA\Property(property="message", type="string", example="No IDs provided")
   *         )
   *     )
   * )
   */
  public function softDelete(BookRequest $request, Book $book)
  {
    $ids = $request->validated();
    Gate::authorize('bulkDelete', [$book, $ids]);
    return response()->json([
      'message' => "Xoá thành công , kiểm tra book trong thùng rác",
      'data' => $this->bookRepository->deleteByIds('id', $ids),
    ]);
  }
  /**
   * @OA\Get(
   *     path="/api/cms/books/trash",
   *     security={{"bearerAuth":{}}},
   *     tags={"CMS Books"},
   *     summary="Danh sách Books đã xoá",
   *     operationId="cms_book_trash",
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
  public function getTrashed()
  {
    return $this->bookService->getTrashedList();
  }
  /**
   * @OA\Post(
   *     path="/api/cms/books/recovery",
   *     tags={"CMS Books"},
   *     security={{"bearerAuth":{}}},
   *     summary="Phục hồi book",
   *     operationId="cms_book_recovery",
   *     @OA\Parameter(
   *         in="header",
   *         name="X-localication",
   *         required=false,
   *         description="Ngôn ngữ hiển thị",
   *         @OA\Schema(type="string", example="vi")
   *     ),
   *     @OA\RequestBody(
   *         required=true,
   *         description="Danh sách ID cần phục hồi",
   *         @OA\JsonContent(
   *             required={"ids"},
   *             @OA\Property(
   *                 property="ids",
   *                 type="array",
   *                 @OA\Items(type="integer", example=1)
   *             )
   *         )
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
  public function recovery(BookRequest $request, Book $book)
  {
    $ids = $request->validated();
    Gate::authorize('bulkDelete', [$book, $ids]);
    return response()->json([
      'message' => "Phục hồi thành công , kiểm tra book trong danh sách",
      'data' => $this->bookRepository->restoreByIds('id', $ids),
    ]);
  }
}
