<?php

return [
    'Introduction' => 'docs/introduction',
    'Quick Start' => 'docs/quick-start',
    'Usage' => [
        'url' => 'docs/usage',
        'children' => [
            'Setting up your bot' => 'docs/setting-up-your-bot',
            'Making Request' => 'docs/making-request',
            'Getting Updates' => 'docs/getting-updates',
            'Handling Updates via Webhook' => 'docs/handling-updates',
            'Command System' => 'docs/command-system',
            'Keyboards' => 'docs/keyboards',
            'Inline mode' => 'docs/inline-mode',
        ],
    ],
    'Advanced Usage' => [
        'url' => 'docs/advanced-usage',
        'children' => [
            'Multiple Bot usage' => 'docs/multiple-bot',
            'Asynchronous request' => 'docs/asynchronous',
        ],
    ],
    'Upgrade' => [
        'url' => 'docs/upgrade',
        'children' => [
            'v3.1 to v4.0' => 'docs/upgrade3-4',
        ],
    ],
    'Extensions' => 'docs/extensions',
    'F.A.Q.' => 'docs/faq',
    'Bugreport' => 'docs/bugreport',
    'Contributing' => 'docs/contributing',
    'License' => 'docs/license',
];
