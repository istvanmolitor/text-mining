<?php

namespace Molitor\TextMining\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Molitor\Admin\Traits\HasAdminFilters;
use Molitor\TextMining\Http\Requests\StoreKeywordRequest;
use Molitor\TextMining\Http\Requests\UpdateKeywordRequest;
use Molitor\TextMining\Http\Resources\KeywordResource;
use Molitor\TextMining\Http\Resources\KeywordSimpleResource;
use Molitor\TextMining\Models\Keyword;

class KeywordApiController extends Controller
{
    use HasAdminFilters;

    public function index(Request $request): JsonResponse
    {
        $query = Keyword::query()->with('aliasKeyword');
        $keywords = $this->applyAdminFilters($query, $request, ['name'])
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'data' => KeywordResource::collection($keywords->items()),
            'meta' => [
                'current_page' => $keywords->currentPage(),
                'last_page' => $keywords->lastPage(),
                'per_page' => $keywords->perPage(),
                'total' => $keywords->total(),
            ],
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    public function create(): JsonResponse
    {
        return response()->json([
            'alias_keywords' => KeywordSimpleResource::collection(
                Keyword::query()->orderBy('name')->get()
            ),
        ]);
    }

    public function show(Keyword $keyword): JsonResponse
    {
        $keyword->load('aliasKeyword');

        return response()->json([
            'data' => new KeywordResource($keyword),
        ]);
    }

    public function edit(Keyword $keyword): JsonResponse
    {
        $keyword->load('aliasKeyword');

        return response()->json([
            'data' => new KeywordResource($keyword),
            'alias_keywords' => KeywordSimpleResource::collection(
                Keyword::query()
                    ->whereKeyNot($keyword->id)
                    ->orderBy('name')
                    ->get()
            ),
        ]);
    }

    public function store(StoreKeywordRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $keyword = Keyword::create([
            'name' => $validated['name'],
            'is_stop_word' => (bool) ($validated['is_stop_word'] ?? false),
            'alias_keyword_id' => $validated['alias_keyword_id'] ?? null,
        ]);

        $keyword->load('aliasKeyword');

        return response()->json([
            'data' => new KeywordResource($keyword),
            'message' => __('text-mining::keyword.messages.created'),
        ], 201);
    }

    public function update(UpdateKeywordRequest $request, Keyword $keyword): JsonResponse
    {
        $validated = $request->validated();

        $keyword->update([
            'name' => $validated['name'],
            'is_stop_word' => (bool) ($validated['is_stop_word'] ?? false),
            'alias_keyword_id' => $validated['alias_keyword_id'] ?? null,
        ]);

        $keyword->load('aliasKeyword');

        return response()->json([
            'data' => new KeywordResource($keyword),
            'message' => __('text-mining::keyword.messages.updated'),
        ]);
    }

    public function destroy(Keyword $keyword): JsonResponse
    {
        $keyword->delete();

        return response()->json([
            'message' => __('text-mining::keyword.messages.deleted'),
        ]);
    }
}
