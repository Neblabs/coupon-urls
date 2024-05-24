<?php

namespace CouponURLs\App\Dashboard;

use CouponURLs\App\Components\Abilities\DashboardExportable;
use CouponURLs\App\Components\Abilities\Exportable;
use CouponURLs\Original\Collections\Collection;
use CouponURLs\Original\Environment\Env;
use function CouponURLs\Original\Utilities\Collection\_;
use function CouponURLs\Original\Utilities\Collection\a;

class DashboardData implements Exportable
{
    public function __construct(
        protected Collection/*<DashboardExportable>*/ $dashboardExporters
    ) {}

    public function addExporter(DashboardExportable $exporter) : self
    {
        $this->dashboardExporters->push($exporter);
        
        return $this;
    }
    
    public function export() : Collection
    {
        return _(
            textDomain: Env::textDomain(),
            components: a(
                events: [
                    a(
                        name: 'Posts',
                        events: [
                            a(
                                type: 'StatusChange',
                                name: 'Post status change',
                                description: 'Triggers when the status of a post changes. Drafts and new are excluded.',
                                data: a(
                                    post: ['editedpost'],
                                    user: ['postauthor', 'userupdating']
                                ),
                                templates: [
                                    a(
                                        type: 'PostHasBeenPublished',
                                        name: 'Post is published',
                                        description: 'Fires when a the status of a post is set to: publish.'
                                    ),
                                    a(
                                        type: 'PostHasBeenTrashed',
                                        name: 'Post moved to trash',
                                        description: 'Fires when a the status of a post is set to: trash.'
                                    ),
                                    a(
                                        type: 'PostHasBeenScheduled',
                                        name: 'Post is scheduled',
                                        description: 'Fires when a the status of a post is set to: future'
                                    ),
                                    a(
                                        type: 'PostSubmittedForReview',
                                        name: 'Post submitted for review',
                                        description: 'Fires when the status of a post is set to: pending.'
                                    ),
                                ]
                            ),
                            a(
                                type: 'StatusChanged',
                                name: 'Post Permanently Deleted',
                                description: 'Triggers when the status of a post changes. Drafts and new are excluded.',
                                data: a(
                                    post: ['editedpost'],
                                    user: ['postauthor', 'userupdating']
                                ),
                                templates: [
                                    a(
                                        type: 'PostHasBeenPublished',
                                        name: 'Post is published',
                                        description: 'Fires when a the status of a post is set to: publish.'
                                    ),
                                    a(
                                        type: 'PostHasBeenTrashed',
                                        name: 'Post moved to trash',
                                        description: 'Fires when a the status of a post is set to: trash.'
                                    ),
                                    a(
                                        type: 'PostHasBeenScheduled',
                                        name: 'Post is scheduled',
                                        description: 'Fires when a the status of a post is set to: future'
                                    ),
                                    a(
                                        type: 'PostSubmittedForReview',
                                        name: 'Post submitted for review',
                                        description: 'Fires when the status of a post is set to: pending.'
                                    ),
                                ]
                            ),
                        ]
                    )
                ],
                dataTypes: [
                    a(
                        type: 'post',
                        name: 'Posts',
                        nameSingular: 'Post'
                    ),
                    a(
                        type: 'user',
                        name: 'Users',
                        nameSingular: 'User'
                    )
                ],
                data: a(
                    post: [
                        a(
                            type: 'editedpost',
                            name: 'Edited Post',
                            description: 'The post being edited'
                        ),
                    ],
                    user: [
                        a(
                            type: 'postauthor',
                            name: 'Post Author',
                            description: 'The author of the post'
                        ),
                        a(
                            type: 'userupdating',
                            name: 'User Submitting Update',
                            description: 'The logged in user that submitted the updates'
                        )
                    ]
                ),
                values: a(
                    post: [
                        a(
                            type: 'title',
                            form: 'text',
                            name: 'Title',
                            description: 'The title of the post'
                        ),
                        /*a(
                            type: 'id',
                            form: 'number',
                            name: 'ID',
                            description: 'The id of the post'
                        )*/
                    ],
                    user: [
                        a(
                            type: 'email',
                            form: 'text->email',
                            name: 'Account e-mail',
                            description: ''
                        )
                    ]
                ),
                forms: [
                    a(type: 'text', name: 'Text'),
                    a(type: 'text->email', name: 'Email'),
                    a(type: 'number', name: 'Number'),
                    a(type: 'number->integer', name: 'Integer'),
                    a(type: 'number->float', name: 'Decimal'),
                ],
                conditions: a(
                    post: [
                        a(
                            type: 'PostStatus',
                            name: 'Status',
                            description: 'Restricts to specific post statuses',
                            options: [
                                //each array item is a line
                                [
                                    a(
                                        type: 'isAllowed',
                                        valueType: 'boolean',
                                        value: a(
                                            allowed: [
                                                 a(
                                                    type: true,
                                                    name: 'Is',
                                                    description: 'Only the selected items are allowed'
                                                ),
                                                a(
                                                    type: false,
                                                    name: 'Is Not',
                                                    description: 'All items are allowed except the selected items'
                                                )
                                            ],
                                            default: true
                                        ),
                                    ),
                                    a(
                                        type: 'statuses',
                                        valueType: 'collection',
                                        name: 'status',
                                        labels: a(
                                            //
                                        ),
                                        value: a(
                                            allowed: [
                                                a(
                                                    type: 'publish',
                                                    name: 'Published',
                                                    description: ''
                                                ),
                                                a(
                                                    type: 'pending',
                                                    name: 'Pending',
                                                    description: ''
                                                ),
                                                a(
                                                    type: 'future',
                                                    name: 'Future',
                                                    description: ''
                                                ),
                                                a(
                                                    type: 'trash',
                                                    name: 'Trash',
                                                    description: ''
                                                ),
                                            ], 
                                            default: []
                                        )                                    
                                    ),
                                ]
                            ]
                        ),
                        a(
                            type: 'InCategories',
                            name: 'Categories',
                            description: 'Restricts to specific post statuses',
                            options: [
                                //each array item is a line
                                [
                                    a(
                                        type: 'isAllowed',
                                        valueType: 'boolean',
                                        value: a(
                                            allowed: [
                                                 a(
                                                    type: true,
                                                    name: 'includes',
                                                    description: 'Only the selected items are allowed'
                                                ),
                                                a(
                                                    type: false,
                                                    name: 'Is Not',
                                                    description: 'All items are allowed except the selected items'
                                                )
                                            ],
                                            default: true
                                        ),
                                    ),
                                    a(
                                        type: 'isAllowed',
                                        valueType: 'boolean',
                                        value: a(
                                            allowed: [
                                                 a(
                                                    type: true,
                                                    name: 'subscriber',
                                                    description: 'Only the selected items are allowed'
                                                ),
                                                a(
                                                    type: false,
                                                    name: 'Is Not',
                                                    description: 'All items are allowed except the selected items'
                                                )
                                            ],
                                            default: true
                                        ),
                                    ),
                                ],
                                [
                                    a(
                                        type: 'isAllowed',
                                        valueType: 'boolean',
                                        value: a(
                                            allowed: [
                                                 a(
                                                    type: true,
                                                    name: 'includes',
                                                    description: 'Only the selected items are allowed'
                                                ),
                                                a(
                                                    type: false,
                                                    name: 'Is Not',
                                                    description: 'All items are allowed except the selected items'
                                                )
                                            ],
                                            default: true
                                        ),
                                    ),
                                    a(
                                        type: 'isAllowed',
                                        valueType: 'boolean',
                                        value: a(
                                            allowed: [
                                                 a(
                                                    type: true,
                                                    name: 'subscriber',
                                                    description: 'Only the selected items are allowed'
                                                ),
                                                a(
                                                    type: false,
                                                    name: 'Is Not',
                                                    description: 'All items are allowed except the selected items'
                                                )
                                            ],
                                            default: true
                                        ),
                                    ),
                                ]
                            ]
                        ),
                    ],
                    user: [
                        a(
                            type: 'UserEmail',
                            name: 'Email',
                            description: 'Restricts to specific post statuses',
                            options: [
                                [
                                    a(
                                        type: 'isAllowed',
                                        valueType: 'boolean',
                                        value: a(
                                            allowed: [
                                                 a(
                                                    type: true,
                                                    name: 'Is',
                                                    description: 'Only the selected items are allowed'
                                                ),
                                                a(
                                                    type: false,
                                                    name: 'Is Not',
                                                    description: 'All items are allowed except the selected items'
                                                )
                                            ],
                                            default: true
                                        ),
                                    ),
                                    a(
                                        type: 'isAllowed',
                                        valueType: 'boolean',
                                        value: a(
                                            allowed: [
                                                 a(
                                                    type: true,
                                                    name: 'admin',
                                                    description: 'Only the selected items are allowed'
                                                ),
                                                a(
                                                    type: false,
                                                    name: 'Is Not',
                                                    description: 'All items are allowed except the selected items'
                                                )
                                            ],
                                            default: true
                                        ),
                                    ),
                                ]
                            ]
                        ),
                    ]
                ),
                passable: a(
                    all: a(
                        type: 'all',
                        name: 'AND',
                        description: 'All conditions must pass'
                    ),
                    only: a(
                        type: 'only',
                        name: 'OR',
                        description: 'Only one condition must pass'
                    )
                )
            ),
            state: a(
                subject: '',
                body: 'You\'re a member now!'
            ),
            fields: [
                'automatedemails-event',
                'automatedemails-conditions',
                'automatedemails-recipients',
                'automatedemails-subject',
                'automatedemails-body'
            ]
        );
    }
}