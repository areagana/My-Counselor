<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// users
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push('Users', route('users'));
});

/**
 * 
 */
//clients routes
Breadcrumbs::for('clients', function ($trail) {
    $trail->parent('home');
    $trail->push('Clients', route('clients'));
});
Breadcrumbs::for('client.create', function ($trail) {
    $trail->parent('clients');
    $trail->push('create', route('client.create'));
});
Breadcrumbs::for('client.edit', function ($trail,$id) {
    $trail->parent('clients');
    $trail->push('Edit', route('client.edit',$id));
});
Breadcrumbs::for('client.view', function ($trail,$id) {
    $trail->parent('clients');
    $trail->push('View', route('client.view',$id));
});
// background crumbs
Breadcrumbs::for('client.background', function ($trail,$id) {
    $trail->parent('clients');
    $trail->push('Background', route('client.background',$id));
});
// client schedules
Breadcrumbs::for('client.schedules', function ($trail,$client,$id) {
    $trail->parent('clients');
    $trail->push($client->name.' - schedules', route('client.schedules',$id));
});





/**
 * 
 */
// category routes
Breadcrumbs::for('category', function ($trail) {
    $trail->parent('home');
    $trail->push('Category', route('category'));
});
Breadcrumbs::for('category.documents', function ($trail,$id) {
    $trail->parent('category');
    $trail->push('documents', route('category.documents',$id));
});

Breadcrumbs::for('category.schedules', function ($trail,$id) {
    $trail->parent('category');
    $trail->push('schedules', route('category.schedules',$id));
});

Breadcrumbs::for('category.clients', function ($trail,$id) {
    $trail->parent('category');
    $trail->push('clients', route('category.clients',$id));
});





/**
 * 
 */
// schedules crumbs
Breadcrumbs::for('schedule', function ($trail) {
    $trail->parent('home');
    $trail->push('Schedule', route('schedule'));
});
//create schedule
Breadcrumbs::for('schedule.create', function ($trail) {
    $trail->parent('schedule');
    $trail->push('Create', route('schedule.create'));
});




/**
 * Records Crumbs
 */
Breadcrumbs::for('records', function ($trail) {
    $trail->parent('home');
    $trail->push('Records', route('records'));
});