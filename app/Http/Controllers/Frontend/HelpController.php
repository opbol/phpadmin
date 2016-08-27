<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

/**
 * Class HelpController
 * @package App\Http\Controllers
 */
class HelpController extends Controller {

	public function index() {
        return view('frontend.help.index');
	}

}