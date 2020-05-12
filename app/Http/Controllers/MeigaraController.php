<?php

namespace App\Http\Controllers;

use App\Meigara;
use Illuminate\Http\Request;

class MeigaraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meigaras = Meigara::all();
        return view('meigara', compact('meigaras'));
    }

    public function import()
    {
        $puppeteer = new Puppeteer;
        $browser = $puppeteer->launch();
        $page = $browser->newPage();
        //要検討
        //245ページを1度にスクレイピングできない。30秒のタイムアウトにひっかかる
        $ulrs = array(
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=0050&p=1', //水産・農林業 (11)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=1050&p=1', //鉱業 (6)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=1', //建設業 (171)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=2050&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=1', //食料品 (126)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3050&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3100&p=1', //繊維製品 (55)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3100&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3100&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3150&p=1', //パルプ・紙 (26)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3150&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=1', //化学 (213)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3200&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3250&p=1', //医薬品 (68)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3250&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3250&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3250&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3300&p=1', //石油・石炭製品 (11)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3350&p=1', //ゴム製品 (19)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3400&p=1', //ガラス・土石製品 (59)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3400&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3400&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3450&p=1', //鉄鋼 (46)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3450&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3450&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3500&p=1', //非鉄金属 (34)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3500&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3550&p=1', //金属製品 (94)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3550&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3550&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3550&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3550&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=1', //機械 (232)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=6', 
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3600&p=12',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=1', //電気機器 (247)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=12',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3650&p=13',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3700&p=1', //輸送用機器 (95)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3700&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3700&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3700&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3700&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3750&p=1', //精密機器 (52)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3750&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3750&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3800&p=1', //その他製品 (111)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3800&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3800&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3800&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3800&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=3800&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=4050&p=1', //電気・ガス業 (24)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=4050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5050&p=1', //陸運業 (66)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5100&p=1', //海運業 (13)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5150&p=1', //空運業 (5)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5200&p=1', //倉庫・運輸関連業 (39)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5200&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=1', //情報・通信 (478)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=12',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=13',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=14',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=15',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=16',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=17',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=18',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=19',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=20',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=21',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=22',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=23',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=5250&p=24',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=1', //卸売業 (330)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=12',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=13',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=14',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=15',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=16',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6050&p=17',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=1', //小売業 (357)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=12',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=13',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=14',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=15',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=16',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=17',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=6100&p=18',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7050&p=1', //銀行業 (88)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7050&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7100&p=1', //証券業 (40)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7100&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7150&p=1', //保険業 (14)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7200&p=1', //その他金融業 (35)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=7200&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=1', //不動産業 (138)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=8050&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=1', //サービス業 (485)
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=2',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=3',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=4',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=5',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=6',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=7',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=8',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=9',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=10',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=11',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=12',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=13',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=14',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=15',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=16',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=17',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=18',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=19',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=20',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=21',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=22',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=23',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=24',
            'https://stocks.finance.yahoo.co.jp/stocks/qi/?ids=9050&p=25'
        );        
        //var els_code, els_market, els_name, els_price;  //, jsHandle, text;
        //var urlindex, meigaraindex;
        
        //URL分ループ
        for ($urlindex=0; $urlindex < count($ulrs); $urlindex++) { 
            $page->goto($ulrs[$urlindex]);
            //ページ中の銘柄分ループ
            //カウンタのmaxを30に十分大きい場合、エラーとならない
            //カウンタのmaxが23だと、ページの最後の銘柄を読んだときなぜかエラーになる
            for ($meigaraindex = 2; $meigaraindex < 30; $meigaraindex++) {
                $els_code = "";
                $els_market = "";
                $els_name = "";
                $els_price = "";
                //コード
                $els_code = $page->querySelectorAll("#listTable > table > tbody > tr:nth-child(" . $meigaraindex . ") > td.center.yjM > a"); 
                //銘柄が存在する場合は以下の処理をする。銘柄がない場合は以下の処理は飛ばす
                if (count($els_code) != 0) {
                    //output(els_code);
                    //市場
                    $els_market = $page->querySelectorAll("#listTable > table > tbody > tr:nth-child(" . $meigaraindex . ") > td.center.yjSt"); 
                    //output(els_market);
                    //名称
                    $els_name = $page->querySelectorAll("#listTable > table > tbody > tr:nth-child(" . $meigaraindex . ") > td:nth-child(3) > strong > a");
                    //output(els_name);
                    //取引値
                    //querySelectorAllの返り値 増減がある場合はfont要素がある
                    $els_price = $page->querySelectorAll("#listTable > table > tbody > tr:nth-child(" . $meigaraindex . ") > td:nth-child(4) > div.price.yjM > font"); 
                    //増減なしの場合font要素はない
                    if (count($els_price) == 0) {
                        //dd($els_price);
                        $els_price = $page->querySelectorAll("#listTable > table > tbody > tr:nth-child(" . $meigaraindex . ") > td:nth-child(4) > div.price.yjM"); 
                    }
                    //---
                    //コード コードが存在する場合のみここに来る
                    //var_dump($els_code[0]);
                    $jsHandle_code = $els_code[0]->getProperty('innerText');    //戻り地は elementHandle
                    $code = $jsHandle_code->jsonValue();
                    //dd($code);
                    //市場
                    if (count($els_market) == 0) {
                        $market = "市場なし";
                    } else {
                        $jsHandle_market = $els_market[0]->getProperty('innerText');
                        $market = $jsHandle_market->jsonValue();
                    }
                    //名称
                    if (count($els_name) == 0) {
                        $name = "名称なし";
                    } else {
                        $jsHandle_name = $els_name[0]->getProperty('innerText');
                        $name = $jsHandle_name->jsonValue();
                    }
                    //取引値　取得しない
                    if (count($els_price) == 0) {
                        $price = "取引値なし";
                    } else {
                        $jsHandle_price = $els_price[0]->getProperty('innerText');
                        $price = $jsHandle_price->jsonValue();
                    }
                    //業種コード
                    $tmpstr = strstr($ulrs[$urlindex], 'ids=');
                    $industrycode = substr($tmpstr, 4, 4);
                    //dd($industrycode);
                    //業種
                    //セレクタ #listTable > h1
                    //例) 業種別銘柄一覧：建設業
                    $els_industry = $page->querySelectorAll("#listTable > h1");
                    $jsHandle_industry = $els_industry[0]->getProperty('innerText');
                    $tmpstr= $jsHandle_industry->jsonValue();
                    $tmpstr = strstr($tmpstr, '：');
                    $industry = mb_substr($tmpstr, 1);
                    //dd($industry);
                    //市場コード
                    switch ($market) {
                        case "東証1部":
                            $marketcode = 1;
                            break;
                        case "東証2部":
                            $marketcode = 2;
                            break;
                        case "東証":
                            $marketcode = 3;
                            break;
                        case "東証外国":
                            $marketcode = 4;
                            break;
                        case "東証JQS":
                            $marketcode = 5;
                            break;
                        case "東証JQG":
                            $marketcode = 6;
                            break;
                        case "マザーズ":
                            $marketcode = 7;
                            break;
                        case "札証":
                            $marketcode = 8;
                            break;
                        case "札幌ア":
                            $marketcode = 9;
                            break;
                        case "福証":
                            $marketcode = 10;
                            break;
                        case "福岡Q":
                            $marketcode = 11;
                            break;
                        case "名証1部":
                            $marketcode = 12;
                            break;
                        case "名証2部":
                            $marketcode = 13;
                            break;
                        case "名古屋セ":
                            $marketcode = 14;
                            break;
                        default:    //上記以外
                            $marketcode = 99;
                    }

                    //DBに登録処理 Eloquentモデル
                    $meigara = Meigara::updateOrCreate(
                        ['code' => $code],
                        ['name' => $name, 'market' => $market, 'marketcode' => $marketcode,
                         'industry' => $industry, 'industrycode' => $industrycode]
                    ); 
                    //デバッグコード
                    //print_r($code . ":" . $market . ":" . $name . ":" . $price ."/");

                    //CSV出力
                    //Give up：csv-writerが使えない。
                    //npm run devで以下のエラー
                    //ERROR in ./node_modules/csv-writer/dist/lib/file-writer.js
                    //Module not found: Error: Can't resolve 'fs' in '/Users/0gravity/0g/021_laravel_srv/kabuboard/node_modules/csv-writer/dist/lib'
                    //output_csv(els_code, els_market, els_name, els_price);

                } //銘柄かある場合は以下の処理をする。銘柄がない場合は以下の処理は飛ばす END
            }   //ページ中の銘柄分ループ END
        }   //URL分ループ END

        $browser->close();        

        return view('meigara', compact('meigaras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meigara  $meigara
     * @return \Illuminate\Http\Response
     */
    public function show(Meigara $meigara)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meigara  $meigara
     * @return \Illuminate\Http\Response
     */
    public function edit(Meigara $meigara)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meigara  $meigara
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meigara $meigara)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meigara  $meigara
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meigara $meigara)
    {
        //
    }
}
