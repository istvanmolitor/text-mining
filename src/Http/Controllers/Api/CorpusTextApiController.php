<?php

namespace Molitor\TextMining\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Molitor\TextMining\DataTables\CorpusTextDataTable;
use Molitor\TextMining\Http\Requests\StoreCorpusTextRequest;
use Molitor\TextMining\Http\Requests\UpdateCorpusTextRequest;
use Molitor\TextMining\Http\Resources\CorpusTextResource;
use Molitor\TextMining\Models\CorpusText;
use Molitor\TextMining\Services\TextMiningService;

class CorpusTextApiController extends Controller
{
    public function __construct(private TextMiningService $textMiningService)
    {
    }

    public function index(CorpusTextDataTable $dataTable): AnonymousResourceCollection
    {
        return $dataTable->getResponse();
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
        $corpusText = $this->textMiningService->createText($validated['name'], $validated['text']);

        return response()->json([
            'data' => new CorpusTextResource($corpusText),
            'message' => __('text-mining::corpus-text.messages.created'),
        ], 201);
    }

    public function update(UpdateCorpusTextRequest $request, CorpusText $corpusText): JsonResponse
    {
        $validated = $request->validated();
        $this->textMiningService->updateText($corpusText, $validated['text']);

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
