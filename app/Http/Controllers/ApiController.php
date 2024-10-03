<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoricalRequest;
use App\Http\Requests\SymbolRequest;
use App\Models\Symbols;
use Illuminate\Support\Facades\Log;
use App\Services\ScrapeService;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiController extends Controller
{
    
}
