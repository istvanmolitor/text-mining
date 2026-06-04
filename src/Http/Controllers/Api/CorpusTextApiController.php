<?php

namespace Molitor\TextMining\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Molitor\Admin\Traits\HasAdminFilters;
use Molitor\TextMining\Http\Requests\StoreCorpusTextRequest;
use Molitor\TextMining\Http\Requests\UpdateCorpusTextRequest;
use Molitor\TextMining\Http\Resources\CorpusTextResource;
use Molitor\TextMining\Models\CorpusText;

class CorpusTextApiController extends Controller
{
    use HasAdminFilters;

    public function index(Request $request): JsonResponse
    {
        $query = CorpusText::query();
        $corpusTexts = $this->applyAdminFilters($query, $request, ['name', 'text'])
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'data' => CorpusTextResource::collection($corpusTexts->items()),
            'meta' => [
                'current_page' => $corpusTexts->currentPage(),
                'last_page' => $corpusTexts->lastPage(),
                'per_page' => $corpusTexts->perPage(),
                'total' => $corpusTexts->total(),
            ],
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    public function create(): JsonResponse
    {
        return response()->json([]);
    }

    public function show(CorpusText $corpusText): JsonResponse
    {
        return response()->json([
            'data' => new CorpusTextResource($corpusText),
        ]);
    }

    public function edit(CorpusText $corpusText): JsonResponse
    {
        return response()->json([
            'data' => new CorpusTextResource($corpusText),
        ]);
    }

    public function store(StoreCorpusTextRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $corpusText = CorpusText::create([
            'name' => $validated['name'],
            'text' => $validated['text'],
        ]);

        return response()->json([
            'data' => new CorpusTextResource($corpusText),
            'message' => __('text-mining::corpus-text.messages.created'),
        ], 201);
    }

    public function update(UpdateCorpusTextRequest $request, CorpusText $corpusText): JsonResponse
    {
        $validated = $request->validated();

        $corpusText->update([
            'name' => $validated['name'],
            'text' => $validated['text'],
        ]);

        return response()->json([
            'data' => new CorpusTextResource($corpusText->fresh()),
            'message' => __('text-mining::corpus-text.messages.updated'),
        ]);
    }

    public function destroy(CorpusText $corpusText): JsonResponse
    {
        $corpusText->delete();

        return response()->json([
            'message' => __('text-mining::corpus-text.messages.deleted'),
        ]);
    }
}
