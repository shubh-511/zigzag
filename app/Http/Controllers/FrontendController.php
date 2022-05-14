<?php

namespace App\Http\Controllers;
use App\User;
use App\AdminMenu;
use App\Role;
use App\UserPermission;
use App\SiteSetting;
use App\Company;
use Illuminate\Http\Request;
use Session;
use DB;
class FrontendController extends Controller
{
    public function frontview()
    {
        return 111;   
    }
    
}    

