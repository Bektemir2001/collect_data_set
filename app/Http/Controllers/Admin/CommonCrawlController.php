<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CrawlUrls;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CommonCrawlController extends Controller
{
    public function index($list=null)
    {
        $urls = DB::table('crawl_urls')
            ->select('host_name', 'list_name', DB::raw('count(*) as url_count'))
            ->where('user_id', auth()->user()->id)
            ->where('list_name', $list)
            ->groupBy('host_name', 'list_name')
            ->get();
        return view('admin.crawl.index', compact('urls'));
    }

    public function show(Request $request)
    {
        $data = $request->validate(['host_name' => 'required']);
        $host_name = $data['host_name'];
        $nextHostName = DB::table('crawl_urls')
            ->select('host_name')
            ->where('user_id', auth()->user()->id)
            ->where('host_name', '>', $host_name)
            ->where('list_name', null)
            ->orderBy('host_name')
            ->first();
        $previousHostName = DB::table('crawl_urls')
            ->select('host_name')
            ->where('user_id', auth()->user()->id)
            ->where('host_name', '<', $host_name)
            ->where('list_name', null)
            ->orderByDesc('host_name')
            ->first();
        $urls = CrawlUrls::where('host_name', $host_name)
            ->where('user_id', auth()->user()->id)
            ->pluck('url');
        return view('admin.crawl.show', compact('host_name', 'urls', 'nextHostName', 'previousHostName'));
    }

    public function getSiteContent(Request $request)
    {
        $data = $request->validate(['url' => 'required']);
        $url = $data['url'];
        try {
            $response = Http::get($url);
            $content = $response->body();
            return response($content);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function blackList(Request $request)
    {
        $data = $request->validate(['host_name' => 'required', 'next_host' => 'nullable']);
        DB::table('crawl_urls')
            ->where('user_id', auth()->user()->id)
            ->where('host_name', $data['host_name'])
            ->update(['list_name' => 'BLACK']);
        return $this->justShow($data['next_host']);

    }

    public function whiteList(Request $request)
    {
        $data = $request->validate(['host_name' => 'required', 'next_host' => 'nullable']);
        DB::table('crawl_urls')
            ->where('user_id', auth()->user()->id)
            ->where('host_name', $data['host_name'])
            ->update(['list_name' => 'WHITE']);
        return $this->justShow($data['next_host']);
    }

    public function justShow($host_name)
    {
        $nextHostName = DB::table('crawl_urls')
            ->select('host_name')
            ->where('user_id', auth()->user()->id)
            ->where('host_name', '>', $host_name)
            ->orderBy('host_name')
            ->first();
        $previousHostName = DB::table('crawl_urls')
            ->select('host_name')
            ->where('user_id', auth()->user()->id)
            ->where('host_name', '<', $host_name)
            ->orderByDesc('host_name')
            ->first();
        $urls = CrawlUrls::where('host_name', $host_name)
            ->where('user_id', auth()->user()->id)
            ->pluck('url');
        return view('admin.crawl.show', compact('host_name', 'urls', 'nextHostName', 'previousHostName'));
    }
}
