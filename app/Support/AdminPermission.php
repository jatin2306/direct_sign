<?php

namespace App\Support;

class AdminPermission
{
    public static function all(): array
    {
        return [
            'dashboard' => ['label' => 'Dashboard', 'actions' => ['view']],
            'properties' => ['label' => 'Properties', 'actions' => ['view', 'create', 'edit', 'delete', 'verify']],
            'banners' => ['label' => 'Banners', 'actions' => ['view', 'create', 'edit', 'delete']],
            'carousels' => ['label' => 'Carousels', 'actions' => ['view', 'create', 'edit', 'delete']],
            'amenities' => ['label' => 'Amenities', 'actions' => ['view', 'create', 'edit', 'delete']],
            'transactions' => ['label' => 'Transactions', 'actions' => ['view', 'create', 'edit', 'delete']],
            'users' => ['label' => 'Users (front-end)', 'actions' => ['view', 'edit', 'delete', 'suspend']],
        
            'notifications' => ['label' => 'Notifications', 'actions' => ['view']],
            'admin-users' => ['label' => 'Admin Users', 'actions' => ['view', 'create', 'edit', 'delete']],
        ];
    }

    public static function allFlattened(): array
    {
        $list = [];
        foreach (self::all() as $resource => $config) {
            foreach ($config['actions'] as $action) {
                $list[] = "{$resource}.{$action}";
            }
        }
        return $list;
    }

    public static function actionLabel(string $action): string
    {
        $labels = [
            'view' => 'View',
            'create' => 'Create',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'verify' => 'Verify / Unverify',
            'approve' => 'Approve',
            'reject' => 'Reject',
            'suspend' => 'Suspend / Activate',
        ];
        return $labels[$action] ?? ucfirst($action);
    }

    /**
     * Ensure "view" is included for every resource that has any other permission.
     * When saving permissions, call this so edit/delete/create etc. always imply view.
     */
    public static function ensureViewForPermissions(array $permissions): array
    {
        $permissions = array_values(array_unique($permissions));
        $resourcesWithView = [];
        foreach (self::all() as $resource => $config) {
            $viewPerm = $resource . '.view';
            if (! in_array('view', $config['actions'], true)) {
                continue;
            }
            foreach ($permissions as $p) {
                if (strpos($p, $resource . '.') === 0 && $p !== $viewPerm) {
                    $resourcesWithView[$viewPerm] = true;
                    break;
                }
            }
        }
        foreach (array_keys($resourcesWithView) as $viewPerm) {
            if (! in_array($viewPerm, $permissions, true)) {
                $permissions[] = $viewPerm;
            }
        }
        return array_values(array_unique($permissions));
    }
}
