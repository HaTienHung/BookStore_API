<?php

namespace App\Http\Controllers\APP;

use App\Models\Category;
use App\Repositories\Category\CategoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $categoryRepository;
    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * @OA\Get(
     *     path="/api/app/categories",
     *     tags={"APP"},
     *     summary="Lấy danh sách danh mục",
     *     @OA\Response(
     *         response=200,
     *         description="Danh sách danh mục"
     *     )
     * )
     */
    public function index()
    {
        //
        return $this->categoryRepository->all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/app/categories/{slug}",
     *     tags={"APP"},
     *     summary="Lấy chi tiết danh mục cha kèm danh mục con",
     *     operationId="detailCategory",
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
    public function show($slug)
    {
        //
        return response()->json([
            'data' => $this->categoryRepository->getFirstBy(['slug' => $slug], ['*'], ['children']),
        ]);
    }
}
