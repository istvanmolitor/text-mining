<?php

declare(strict_types=1);

namespace Molitor\TextMining\DataTables;

use Molitor\Admin\DataTables\DataTable;
use Molitor\TextMining\Http\Resources\CorpusTextResource;
use Molitor\TextMining\Models\CorpusText;

class CorpusTextDataTable extends DataTable
{
    protected function getModelClass(): string
    {
        return CorpusText::class;
    }

    protected function getResourceClass(): string
    {
        return CorpusTextResource::class;
    }

    protected function initColumns(): void
    {
        $this->addColumn('name')->setSearchable()->setOrderable();
        $this->addColumn('text')->setSearchable();
    }
}
