<?php

namespace Molitor\TextMining\Database\Seeders;

use Illuminate\Database\Seeder;
use Molitor\User\Exceptions\PermissionException;
use Molitor\User\Services\AclManagementService;

class TextMiningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            /** @var AclManagementService $aclService */
            $aclService = app(AclManagementService::class);

            $aclService->createPermission(
                'text-mining',
                'Text mining kezelese',
                'admin',
                'Text Mining'
            );
        } catch (PermissionException $e) {
            $this->command?->error($e->getMessage());
        }
    }
}