<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use Auth;

class HomeController extends Controller {

    private $roles;

    private $users;

    public function __construct(RoleRepository $roles,
                                UserRepository $users) {
        $this->roles = $roles;
        $this->users = $users;
    }

    public function home() {
        $user = Auth::user();

        foreach ($this->roles->all() as $role) {
            if ($user->hasRole($role->name)) {
                $method = strtolower($role->name) . 'Home';
                if (method_exists($this, $method)) {
                    return $this->$method();
                }
                break;
            }
        }

		return $this->defaultHome();
	}

    private function adminHome() {
        return $this->adminView();
    }

    private function supervisorHome() {
        return $this->adminView();
    }

    private function managerHome() {
        return $this->adminView();
    }

    private function defaultHome() {
        return view('frontend.default');
    }

    private function adminView() {
        return view('frontend.admin');
    }

}
