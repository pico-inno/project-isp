<?php

use App\Http\Controllers\NetworkMonitorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use RouterOS\Client;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', \App\Livewire\Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard')->lazy();

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/about', \App\Livewire\About::class)->middleware(['auth', 'verified'])->name('about')->lazy();


    Route::get('/users', \App\Livewire\User\Index::class)->name('users.index')->lazy()->middleware('permission:read,User');
    Route::get('/users/create', \App\Livewire\User\Form::class)->name('users.create')->lazy()->middleware('permission:create,User');
    Route::get('/users/{user}/edit', \App\Livewire\User\Form::class)->name('users.edit')->lazy()->middleware('permission:update,User');

    Route::get('/role-permissions', \App\Livewire\Role\Index::class)->name('role-permissions.index')->lazy()->middleware('permission:read,Role');
    Route::get('/role-permissions/create', \App\Livewire\Role\Form::class)->name('role-permissions.create')->lazy()->middleware('permission:create,Role');
    Route::get('/role-permissions/{role}/edit', \App\Livewire\Role\Form::class)->name('role-permissions.edit')->lazy()->middleware('permission:update,Role');


    Route::prefix('routers')->group(function () {
        Route::get('/', \App\Livewire\Router\Index::class)->name('routers.index')->lazy()->middleware('permission:read,Router');
        Route::get('/create', \App\Livewire\Router\Form::class)->name('routers.create')->lazy()->middleware('permission:create,Router');
        Route::get('/{router}/edit', \App\Livewire\Router\Form::class)->name('routers.edit')->lazy()->middleware('permission:update,Router');
        Route::get('/{router}/dashboard', \App\Livewire\Router\Dashboard::class)->name('routers.dashboard')->lazy()->middleware('permission:read,Router');
        Route::get('/{router}/dhcp-releases', \App\Livewire\Router\DhcpReleases::class)->name('routers.dhcp-releases')->lazy()->middleware('permission:read,Router');
        Route::get('/{router}/network-logs', \App\Livewire\Router\NetworkLogs::class)->name('routers.network-logs')->lazy()->middleware('permission:read,Router');
        Route::get('/nas', \App\Livewire\Router\Nas\Index::class)->name('routers.nas.index')->lazy()->middleware('permission:read,Router');
        Route::get('/nas/create', \App\Livewire\Router\Nas\Form::class)->name('routers.nas.create')->lazy()->middleware('permission:read,Router');
        Route::get('/nas/{nas}/edit', \App\Livewire\Router\Nas\Form::class)->name('routers.nas.edit')->lazy()->middleware('permission:read,Router');
    });

    Route::get('/profiles', \App\Livewire\PppProfile\Index::class)->name('ppp_profiles.index')->lazy()->middleware('permission:read,Router');
    Route::get('/profiles/create', \App\Livewire\PppProfile\Form::class)->name('ppp_profiles.create')->lazy()->middleware('permission:create,Router');
    Route::get('/profiles/{pppProfile}/edit', \App\Livewire\PppProfile\Form::class)->name('ppp_profiles.edit')->lazy()->middleware('permission:update,Router');

    Route::get('/hotspot/profiles', \App\Livewire\HotspotProfile\Index::class)->name('hotspot_profiles.index')->lazy()->middleware('permission:read,Router');
    Route::get('/hotspot/profiles/create', \App\Livewire\HotspotProfile\Form::class)->name('hotspot_profiles.create')->lazy()->middleware('permission:create,Router');
    Route::get('/hotspot/profiles/{pppProfile}/edit', \App\Livewire\HotspotProfile\Form::class)->name('hotspot_profiles.edit')->lazy()->middleware('permission:update,Router');
    Route::get('/hotspot/profiles/{pppProfile}/edit', \App\Livewire\HotspotProfile\Form::class)->name('hotspot')->lazy()->middleware('permission:update,Router');

    Route::get('/{router}/radius', \App\Livewire\Radius\Index::class)->name('radius.index')->lazy()->middleware('permission:read,Router');
    Route::get('/{router}/radius/create', \App\Livewire\Radius\Form::class)->name('radius.create')->lazy()->middleware('permission:create,Router');
    Route::get('/{router}/radius/{id}/edit', \App\Livewire\Radius\Form::class)->name('radius.edit')->lazy()->middleware('permission:update,Router');

    Route::get('/radcheck/{serviceType}', \App\Livewire\RadCheck\Index::class)->name('radcheck.index')->lazy()->middleware('permission:read,Router');
    Route::get('/radcheck/{serviceType}/create', \App\Livewire\RadCheck\Form::class)->name('radcheck.create')->lazy()->middleware('permission:create,Router');
    Route::get('/radcheck/{radCheck}/edit', \App\Livewire\RadCheck\Form::class)->name('radcheck.edit')->lazy()->middleware('permission:update,Router');

    Route::prefix('reports')->group(function () {
        Route::get('/radiusafsd', \App\Livewire\Report\RadiusLog::class)->name('reports.radius.log')->lazy()->middleware('permission:update,Router');
    });

    Route::prefix('status')->group(function () {
        Route::get('/services', \App\Livewire\Status\Service::class)->name('status.services')->lazy()->middleware('permission:update,Router');
        Route::get('/server', \App\Livewire\Status\Server::class)->name('status.server')->lazy()->middleware('permission:update,Router');
    });

    Route::get('/openwrt', function () {
        try {
            $client = new Client([
                'host' => '192.168.1.1',
                'user' => 'root',
                'pass' => 'password',
                'port' => 22
            ]);

            $response = $client->query('/system/resource/print')->read();
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });
});

require __DIR__.'/auth.php';

Route::get('/snmp/hostname/{ip}/{community}', [NetworkMonitorController::class, 'getDeviceHostname']);
Route::get('/snmp/interfaces/{ip}/{community}', [NetworkMonitorController::class, 'getInterfaceDetails']);
Route::get('/snmp/uptime/{ip}/{community}', [NetworkMonitorController::class, 'getDeviceUptime']);
Route::get('/snmp/write/{ip}/{community}/{name}', [NetworkMonitorController::class, 'writeSystem']);
Route::get('/snmp/script-execute/{ip}/{community}/{scriptName}', [NetworkMonitorController::class, 'executeMikrotikScript']);
