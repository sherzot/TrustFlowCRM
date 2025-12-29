<?php

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/admin/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.auth.login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.auth.logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.pages.custom-dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/kanban-board' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.pages.kanban-board',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/locale-switcher' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.pages.locale-switcher',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/o-k-r-dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.pages.o-k-r-dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/system-health' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.pages.system-health',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/accounts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.accounts.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/accounts/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.accounts.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/contacts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.contacts.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/contacts/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.contacts.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/deals' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.deals.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/deals/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.deals.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/invoices' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.invoices.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/invoices/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.invoices.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/leads' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.leads.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/leads/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.leads.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/projects' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.projects.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/projects/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.projects.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/tasks' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.tasks.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/tasks/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.tasks.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/horizon/api/stats' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.stats.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/horizon/api/workload' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.workload.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/horizon/api/masters' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.masters.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/horizon/api/monitoring' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.monitoring.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.monitoring.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/horizon/api/metrics/jobs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.jobs-metrics.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/horizon/api/metrics/queues' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.queues-metrics.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/horizon/api/batches' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.jobs-batches.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/horizon/api/jobs/pending' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.pending-jobs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/horizon/api/jobs/completed' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.completed-jobs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/horizon/api/jobs/silenced' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.silenced-jobs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/horizon/api/jobs/failed' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.failed-jobs.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sanctum/csrf-cookie' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sanctum.csrf-cookie',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'livewire.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/livewire.js' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ejpOKiCfBc4uJm60',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/livewire.min.js.map' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uLRlFn2Uqd6689Pw',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/upload-file' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'livewire.upload-file',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/health-check' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.healthCheck',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/execute-solution' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.executeSolution',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/_ignition/update-config' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ignition.updateConfig',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/up' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wDpREz0iaYIMcv3J',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GFGHjPvSGd1PQTEW',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/web-to-lead' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'web-to-lead.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/filament/(?|exports/([^/]++)/download(*:45)|imports/([^/]++)/failed\\-rows/download(*:90))|/admin/(?|accounts/([^/]++)/edit(*:130)|contacts/([^/]++)/edit(*:160)|deals/([^/]++)/edit(*:187)|invoices/([^/]++)/edit(*:217)|leads/([^/]++)/edit(*:244)|projects/([^/]++)/edit(*:274)|tasks/([^/]++)/edit(*:301))|/horizon(?|/api/(?|m(?|onitoring/(?|([^/]++)(*:354)|(.*)(*:366))|etrics/(?|jobs/([^/]++)(*:398)|queues/([^/]++)(*:421)))|batches/(?|([^/]++)(*:450)|retry/([^/]++)(*:472))|jobs/(?|failed/([^/]++)(*:504)|retry/([^/]++)(*:526)|([^/]++)(*:542)))|(?:/((?:.*)))?(*:566))|/livewire/preview\\-file/([^/]++)(*:607)|/tenancy/assets(?:/((?:.*)))?(*:644))/?$}sDu',
    ),
    3 => 
    array (
      45 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.exports.download',
          ),
          1 => 
          array (
            0 => 'export',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      90 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.imports.failed-rows.download',
          ),
          1 => 
          array (
            0 => 'import',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      130 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.accounts.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      160 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.contacts.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      187 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.deals.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      217 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.invoices.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      244 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.leads.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      274 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.projects.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      301 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'filament.admin.resources.tasks.edit',
          ),
          1 => 
          array (
            0 => 'record',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      354 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.monitoring-tag.paginate',
          ),
          1 => 
          array (
            0 => 'tag',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      366 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.monitoring-tag.destroy',
          ),
          1 => 
          array (
            0 => 'tag',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      398 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.jobs-metrics.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      421 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.queues-metrics.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      450 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.jobs-batches.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      472 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.jobs-batches.retry',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      504 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.failed-jobs.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      526 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.retry-jobs.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      542 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.jobs.show',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      566 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'horizon.index',
            'view' => NULL,
          ),
          1 => 
          array (
            0 => 'view',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      607 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'livewire.preview-file',
          ),
          1 => 
          array (
            0 => 'filename',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      644 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'stancl.tenancy.asset',
            'path' => NULL,
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'filament.exports.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'filament/exports/{export}/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'filament.actions',
        ),
        'uses' => 'Filament\\Actions\\Exports\\Http\\Controllers\\DownloadExport@__invoke',
        'controller' => 'Filament\\Actions\\Exports\\Http\\Controllers\\DownloadExport',
        'as' => 'filament.exports.download',
        'namespace' => NULL,
        'prefix' => 'filament',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.imports.failed-rows.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'filament/imports/{import}/failed-rows/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'filament.actions',
        ),
        'uses' => 'Filament\\Actions\\Imports\\Http\\Controllers\\DownloadImportFailureCsv@__invoke',
        'controller' => 'Filament\\Actions\\Imports\\Http\\Controllers\\DownloadImportFailureCsv',
        'as' => 'filament.imports.failed-rows.download',
        'namespace' => NULL,
        'prefix' => 'filament',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.auth.login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/login',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
        ),
        'uses' => 'Filament\\Pages\\Auth\\Login@__invoke',
        'controller' => 'Filament\\Pages\\Auth\\Login',
        'as' => 'filament.admin.auth.login',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.auth.logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/logout',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'uses' => 'Filament\\Http\\Controllers\\Auth\\LogoutController@__invoke',
        'controller' => 'Filament\\Http\\Controllers\\Auth\\LogoutController',
        'as' => 'filament.admin.auth.logout',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.pages.custom-dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'uses' => 'App\\Filament\\Pages\\CustomDashboard@__invoke',
        'controller' => 'App\\Filament\\Pages\\CustomDashboard',
        'as' => 'filament.admin.pages.custom-dashboard',
        'namespace' => NULL,
        'prefix' => 'admin/',
        'where' => 
        array (
        ),
        'excluded_middleware' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.pages.kanban-board' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/kanban-board',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'uses' => 'App\\Filament\\Pages\\KanbanBoard@__invoke',
        'controller' => 'App\\Filament\\Pages\\KanbanBoard',
        'as' => 'filament.admin.pages.kanban-board',
        'namespace' => NULL,
        'prefix' => 'admin/',
        'where' => 
        array (
        ),
        'excluded_middleware' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.pages.locale-switcher' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/locale-switcher',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'uses' => 'App\\Filament\\Pages\\LocaleSwitcher@__invoke',
        'controller' => 'App\\Filament\\Pages\\LocaleSwitcher',
        'as' => 'filament.admin.pages.locale-switcher',
        'namespace' => NULL,
        'prefix' => 'admin/',
        'where' => 
        array (
        ),
        'excluded_middleware' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.pages.o-k-r-dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/o-k-r-dashboard',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'uses' => 'App\\Filament\\Pages\\OKRDashboard@__invoke',
        'controller' => 'App\\Filament\\Pages\\OKRDashboard',
        'as' => 'filament.admin.pages.o-k-r-dashboard',
        'namespace' => NULL,
        'prefix' => 'admin/',
        'where' => 
        array (
        ),
        'excluded_middleware' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.pages.system-health' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/system-health',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'uses' => 'App\\Filament\\Pages\\SystemHealth@__invoke',
        'controller' => 'App\\Filament\\Pages\\SystemHealth',
        'as' => 'filament.admin.pages.system-health',
        'namespace' => NULL,
        'prefix' => 'admin/',
        'where' => 
        array (
        ),
        'excluded_middleware' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.accounts.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/accounts',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\AccountResource\\Pages\\ListAccounts@__invoke',
        'controller' => 'App\\Filament\\Resources\\AccountResource\\Pages\\ListAccounts',
        'as' => 'filament.admin.resources.accounts.index',
        'namespace' => NULL,
        'prefix' => 'admin/accounts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.accounts.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/accounts/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\AccountResource\\Pages\\CreateAccount@__invoke',
        'controller' => 'App\\Filament\\Resources\\AccountResource\\Pages\\CreateAccount',
        'as' => 'filament.admin.resources.accounts.create',
        'namespace' => NULL,
        'prefix' => 'admin/accounts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.accounts.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/accounts/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\AccountResource\\Pages\\EditAccount@__invoke',
        'controller' => 'App\\Filament\\Resources\\AccountResource\\Pages\\EditAccount',
        'as' => 'filament.admin.resources.accounts.edit',
        'namespace' => NULL,
        'prefix' => 'admin/accounts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.contacts.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/contacts',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\ContactResource\\Pages\\ListContacts@__invoke',
        'controller' => 'App\\Filament\\Resources\\ContactResource\\Pages\\ListContacts',
        'as' => 'filament.admin.resources.contacts.index',
        'namespace' => NULL,
        'prefix' => 'admin/contacts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.contacts.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/contacts/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\ContactResource\\Pages\\CreateContact@__invoke',
        'controller' => 'App\\Filament\\Resources\\ContactResource\\Pages\\CreateContact',
        'as' => 'filament.admin.resources.contacts.create',
        'namespace' => NULL,
        'prefix' => 'admin/contacts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.contacts.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/contacts/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\ContactResource\\Pages\\EditContact@__invoke',
        'controller' => 'App\\Filament\\Resources\\ContactResource\\Pages\\EditContact',
        'as' => 'filament.admin.resources.contacts.edit',
        'namespace' => NULL,
        'prefix' => 'admin/contacts',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.deals.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/deals',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\DealResource\\Pages\\ListDeals@__invoke',
        'controller' => 'App\\Filament\\Resources\\DealResource\\Pages\\ListDeals',
        'as' => 'filament.admin.resources.deals.index',
        'namespace' => NULL,
        'prefix' => 'admin/deals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.deals.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/deals/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\DealResource\\Pages\\CreateDeal@__invoke',
        'controller' => 'App\\Filament\\Resources\\DealResource\\Pages\\CreateDeal',
        'as' => 'filament.admin.resources.deals.create',
        'namespace' => NULL,
        'prefix' => 'admin/deals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.deals.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/deals/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\DealResource\\Pages\\EditDeal@__invoke',
        'controller' => 'App\\Filament\\Resources\\DealResource\\Pages\\EditDeal',
        'as' => 'filament.admin.resources.deals.edit',
        'namespace' => NULL,
        'prefix' => 'admin/deals',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.invoices.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/invoices',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\InvoiceResource\\Pages\\ListInvoices@__invoke',
        'controller' => 'App\\Filament\\Resources\\InvoiceResource\\Pages\\ListInvoices',
        'as' => 'filament.admin.resources.invoices.index',
        'namespace' => NULL,
        'prefix' => 'admin/invoices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.invoices.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/invoices/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\InvoiceResource\\Pages\\CreateInvoice@__invoke',
        'controller' => 'App\\Filament\\Resources\\InvoiceResource\\Pages\\CreateInvoice',
        'as' => 'filament.admin.resources.invoices.create',
        'namespace' => NULL,
        'prefix' => 'admin/invoices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.invoices.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/invoices/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\InvoiceResource\\Pages\\EditInvoice@__invoke',
        'controller' => 'App\\Filament\\Resources\\InvoiceResource\\Pages\\EditInvoice',
        'as' => 'filament.admin.resources.invoices.edit',
        'namespace' => NULL,
        'prefix' => 'admin/invoices',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.leads.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/leads',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\LeadResource\\Pages\\ListLeads@__invoke',
        'controller' => 'App\\Filament\\Resources\\LeadResource\\Pages\\ListLeads',
        'as' => 'filament.admin.resources.leads.index',
        'namespace' => NULL,
        'prefix' => 'admin/leads',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.leads.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/leads/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\LeadResource\\Pages\\CreateLead@__invoke',
        'controller' => 'App\\Filament\\Resources\\LeadResource\\Pages\\CreateLead',
        'as' => 'filament.admin.resources.leads.create',
        'namespace' => NULL,
        'prefix' => 'admin/leads',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.leads.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/leads/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\LeadResource\\Pages\\EditLead@__invoke',
        'controller' => 'App\\Filament\\Resources\\LeadResource\\Pages\\EditLead',
        'as' => 'filament.admin.resources.leads.edit',
        'namespace' => NULL,
        'prefix' => 'admin/leads',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.projects.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/projects',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\ProjectResource\\Pages\\ListProjects@__invoke',
        'controller' => 'App\\Filament\\Resources\\ProjectResource\\Pages\\ListProjects',
        'as' => 'filament.admin.resources.projects.index',
        'namespace' => NULL,
        'prefix' => 'admin/projects',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.projects.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/projects/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\ProjectResource\\Pages\\CreateProject@__invoke',
        'controller' => 'App\\Filament\\Resources\\ProjectResource\\Pages\\CreateProject',
        'as' => 'filament.admin.resources.projects.create',
        'namespace' => NULL,
        'prefix' => 'admin/projects',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.projects.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/projects/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\ProjectResource\\Pages\\EditProject@__invoke',
        'controller' => 'App\\Filament\\Resources\\ProjectResource\\Pages\\EditProject',
        'as' => 'filament.admin.resources.projects.edit',
        'namespace' => NULL,
        'prefix' => 'admin/projects',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.tasks.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/tasks',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\TaskResource\\Pages\\ListTasks@__invoke',
        'controller' => 'App\\Filament\\Resources\\TaskResource\\Pages\\ListTasks',
        'as' => 'filament.admin.resources.tasks.index',
        'namespace' => NULL,
        'prefix' => 'admin/tasks',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.tasks.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/tasks/create',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\TaskResource\\Pages\\CreateTask@__invoke',
        'controller' => 'App\\Filament\\Resources\\TaskResource\\Pages\\CreateTask',
        'as' => 'filament.admin.resources.tasks.create',
        'namespace' => NULL,
        'prefix' => 'admin/tasks',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'filament.admin.resources.tasks.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/tasks/{record}/edit',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'panel:admin',
          1 => 'Illuminate\\Cookie\\Middleware\\EncryptCookies',
          2 => 'Illuminate\\Cookie\\Middleware\\AddQueuedCookiesToResponse',
          3 => 'Illuminate\\Session\\Middleware\\StartSession',
          4 => 'App\\Http\\Middleware\\SetLocale',
          5 => 'Filament\\Http\\Middleware\\AuthenticateSession',
          6 => 'Illuminate\\View\\Middleware\\ShareErrorsFromSession',
          7 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
          8 => 'Illuminate\\Routing\\Middleware\\SubstituteBindings',
          9 => 'Filament\\Http\\Middleware\\DisableBladeIconComponents',
          10 => 'Filament\\Http\\Middleware\\DispatchServingFilamentEvent',
          11 => 'Filament\\Http\\Middleware\\Authenticate',
        ),
        'excluded_middleware' => 
        array (
        ),
        'uses' => 'App\\Filament\\Resources\\TaskResource\\Pages\\EditTask@__invoke',
        'controller' => 'App\\Filament\\Resources\\TaskResource\\Pages\\EditTask',
        'as' => 'filament.admin.resources.tasks.edit',
        'namespace' => NULL,
        'prefix' => 'admin/tasks',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.stats.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/stats',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\DashboardStatsController@index',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\DashboardStatsController@index',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.stats.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.workload.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/workload',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\WorkloadController@index',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\WorkloadController@index',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.workload.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.masters.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/masters',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\MasterSupervisorController@index',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\MasterSupervisorController@index',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.masters.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.monitoring.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/monitoring',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\MonitoringController@index',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\MonitoringController@index',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.monitoring.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.monitoring.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'horizon/api/monitoring',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\MonitoringController@store',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\MonitoringController@store',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.monitoring.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.monitoring-tag.paginate' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/monitoring/{tag}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\MonitoringController@paginate',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\MonitoringController@paginate',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.monitoring-tag.paginate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.monitoring-tag.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'horizon/api/monitoring/{tag}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\MonitoringController@destroy',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\MonitoringController@destroy',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.monitoring-tag.destroy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'tag' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.jobs-metrics.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/metrics/jobs',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\JobMetricsController@index',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\JobMetricsController@index',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.jobs-metrics.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.jobs-metrics.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/metrics/jobs/{id}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\JobMetricsController@show',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\JobMetricsController@show',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.jobs-metrics.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.queues-metrics.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/metrics/queues',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\QueueMetricsController@index',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\QueueMetricsController@index',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.queues-metrics.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.queues-metrics.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/metrics/queues/{id}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\QueueMetricsController@show',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\QueueMetricsController@show',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.queues-metrics.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.jobs-batches.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/batches',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\BatchesController@index',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\BatchesController@index',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.jobs-batches.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.jobs-batches.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/batches/{id}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\BatchesController@show',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\BatchesController@show',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.jobs-batches.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.jobs-batches.retry' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'horizon/api/batches/retry/{id}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\BatchesController@retry',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\BatchesController@retry',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.jobs-batches.retry',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.pending-jobs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/jobs/pending',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\PendingJobsController@index',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\PendingJobsController@index',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.pending-jobs.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.completed-jobs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/jobs/completed',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\CompletedJobsController@index',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\CompletedJobsController@index',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.completed-jobs.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.silenced-jobs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/jobs/silenced',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\SilencedJobsController@index',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\SilencedJobsController@index',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.silenced-jobs.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.failed-jobs.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/jobs/failed',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\FailedJobsController@index',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\FailedJobsController@index',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.failed-jobs.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.failed-jobs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/jobs/failed/{id}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\FailedJobsController@show',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\FailedJobsController@show',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.failed-jobs.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.retry-jobs.show' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'horizon/api/jobs/retry/{id}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\RetryController@store',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\RetryController@store',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.retry-jobs.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.jobs.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/api/jobs/{id}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\JobsController@show',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\JobsController@show',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon/api',
        'where' => 
        array (
        ),
        'as' => 'horizon.jobs.show',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'horizon.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'horizon/{view?}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Laravel\\Horizon\\Http\\Controllers\\HomeController@index',
        'controller' => 'Laravel\\Horizon\\Http\\Controllers\\HomeController@index',
        'namespace' => 'Laravel\\Horizon\\Http\\Controllers',
        'prefix' => 'horizon',
        'where' => 
        array (
        ),
        'as' => 'horizon.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'view' => '(.*)',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sanctum.csrf-cookie' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sanctum/csrf-cookie',
      'action' => 
      array (
        'uses' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'controller' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'namespace' => NULL,
        'prefix' => 'sanctum',
        'where' => 
        array (
        ),
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'sanctum.csrf-cookie',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'livewire.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'livewire/update',
      'action' => 
      array (
        'uses' => 'Livewire\\Mechanisms\\HandleRequests\\HandleRequests@handleUpdate',
        'controller' => 'Livewire\\Mechanisms\\HandleRequests\\HandleRequests@handleUpdate',
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'livewire.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ejpOKiCfBc4uJm60' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'livewire/livewire.js',
      'action' => 
      array (
        'uses' => 'Livewire\\Mechanisms\\FrontendAssets\\FrontendAssets@returnJavaScriptAsFile',
        'controller' => 'Livewire\\Mechanisms\\FrontendAssets\\FrontendAssets@returnJavaScriptAsFile',
        'as' => 'generated::ejpOKiCfBc4uJm60',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::uLRlFn2Uqd6689Pw' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'livewire/livewire.min.js.map',
      'action' => 
      array (
        'uses' => 'Livewire\\Mechanisms\\FrontendAssets\\FrontendAssets@maps',
        'controller' => 'Livewire\\Mechanisms\\FrontendAssets\\FrontendAssets@maps',
        'as' => 'generated::uLRlFn2Uqd6689Pw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'livewire.upload-file' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'livewire/upload-file',
      'action' => 
      array (
        'uses' => 'Livewire\\Features\\SupportFileUploads\\FileUploadController@handle',
        'controller' => 'Livewire\\Features\\SupportFileUploads\\FileUploadController@handle',
        'as' => 'livewire.upload-file',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'livewire.preview-file' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'livewire/preview-file/{filename}',
      'action' => 
      array (
        'uses' => 'Livewire\\Features\\SupportFileUploads\\FilePreviewController@handle',
        'controller' => 'Livewire\\Features\\SupportFileUploads\\FilePreviewController@handle',
        'as' => 'livewire.preview-file',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.healthCheck' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '_ignition/health-check',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\HealthCheckController',
        'as' => 'ignition.healthCheck',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.executeSolution' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/execute-solution',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\ExecuteSolutionController',
        'as' => 'ignition.executeSolution',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ignition.updateConfig' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => '_ignition/update-config',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'Spatie\\LaravelIgnition\\Http\\Middleware\\RunnableSolutionsEnabled',
        ),
        'uses' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController@__invoke',
        'controller' => 'Spatie\\LaravelIgnition\\Http\\Controllers\\UpdateConfigController',
        'as' => 'ignition.updateConfig',
        'namespace' => NULL,
        'prefix' => '_ignition',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'stancl.tenancy.asset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tenancy/assets/{path?}',
      'action' => 
      array (
        'uses' => 'Stancl\\Tenancy\\Controllers\\TenantAssetsController@asset',
        'controller' => 'Stancl\\Tenancy\\Controllers\\TenantAssetsController@asset',
        'as' => 'stancl.tenancy.asset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '(.*)',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wDpREz0iaYIMcv3J' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'up',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:807:"function () {
                    $exception = null;

                    try {
                        \\Illuminate\\Support\\Facades\\Event::dispatch(new \\Illuminate\\Foundation\\Events\\DiagnosingHealth);
                    } catch (\\Throwable $e) {
                        if (app()->hasDebugModeEnabled()) {
                            throw $e;
                        }

                        report($e);

                        $exception = $e->getMessage();
                    }

                    return response(\\Illuminate\\Support\\Facades\\View::file(\'/var/www/html/vendor/laravel/framework/src/Illuminate/Foundation/Configuration\'.\'/../resources/health-up.blade.php\', [
                        \'exception\' => $exception,
                    ]), status: $exception ? 500 : 200);
                }";s:5:"scope";s:54:"Illuminate\\Foundation\\Configuration\\ApplicationBuilder";s:4:"this";N;s:4:"self";s:32:"0000000000000e980000000000000000";}}',
        'as' => 'generated::wDpREz0iaYIMcv3J',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GFGHjPvSGd1PQTEW' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:44:"function () {
    return \\view(\'welcome\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"0000000000000e950000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::GFGHjPvSGd1PQTEW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'web-to-lead.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'web-to-lead',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\WebToLeadController@store',
        'controller' => 'App\\Http\\Controllers\\WebToLeadController@store',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'web-to-lead.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
