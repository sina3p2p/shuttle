<?php

namespace Sina\Shuttle\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Sina\Tools\GoogleAnalytics;
use Illuminate\Http\Request;
use Analytics;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Analytics\Period;
use League\Flysystem\Util;
use Sina\Shuttle\Models\Menu;
use Sina\Shuttle\Models\ScaffoldInterface;

class DashboardController extends Controller
{
    public function index()
    {
        $menuItems = ScaffoldInterface::all();
        return view('shuttle::dashboard');
    }

    public function shuttle()
    {
        $menuItems = Menu::where('name', 'shuttle_menu')->first()->items()->get()->append(['label', 'link']);
        return $menuItems;
    }

    public function show()
    {
        $data = array();
        $analyticsData_one = Analytics::fetchTotalVisitorsAndPageViews(Period::days(14));
        //        $data['dates'] = $analyticsData_one->pluck('date');
        $data['visitors'] = $analyticsData_one->pluck('visitors');
        //        $data['pageViews'] = $analyticsData_one->pluck('pageViews');
        $data['browser'] = GoogleAnalytics::topbrowsers();
        //
        //        $result = GoogleAnalytics::country();
        //
        $data['country'] = GoogleAnalytics::country();
        //
        $data['today'] = GoogleAnalytics::todayVisit();
        //
        $data['yesterday'] = GoogleAnalytics::yesterdayVisit();
        //
        //        $data['realtime'] = GoogleAnalytics::realtimeVisitors();
        //
        $data['channels'] = GoogleAnalytics::channels();

        return response()->json($data);
    }

    public function assets($fileName)
    {
        try {
            $path = dirname(__DIR__, 3) . '/resources/assets/' . $fileName;
        } catch (\LogicException $e) {
            abort(404);
        }

        if (File::exists($path)) {
            if (Str::endsWith($path, '.js')) {
                $mime = 'text/javascript';
            } elseif (Str::endsWith($path, '.css')) {
                $mime = 'text/css';
            } else {
                $mime = File::mimeType($path);
            }
            $response = response(File::get($path), 200, ['Content-Type' => $mime]);
            $response->setSharedMaxAge(31536000);
            $response->setMaxAge(31536000);
            $response->setExpires(new \DateTime('+1 year'));
            return $response;
        }

        return response('', 404);
    }

    public function assetsVue($fileName)
    {
        try {
            $path = dirname(__DIR__, 3) . '/public/shuttle-vue/' . $fileName;
        } catch (\LogicException $e) {
            abort(404);
        }

        if (File::exists($path)) {
            if (Str::endsWith($path, '.js')) {
                $mime = 'text/javascript';
            } elseif (Str::endsWith($path, '.css')) {
                $mime = 'text/css';
            } else {
                $mime = File::mimeType($path);
            }
            $response = response(File::get($path), 200, ['Content-Type' => $mime]);
            // $response->setSharedMaxAge(31536000);
            // $response->setMaxAge(31536000);
            // $response->setExpires(new \DateTime('+1 year'));
            return $response;
        }

        return response('', 404);
    }
}
