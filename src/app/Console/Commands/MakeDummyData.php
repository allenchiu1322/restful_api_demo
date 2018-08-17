<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Sunra\PhpSimple\HtmlDomParser;

use App\Restful\Services\PhonebookService;

class MakeDummyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:makedummydata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill random name and tel data to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->info('orz');
        // 取得亂數姓名
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://www.richyli.com/name/index.asp');
        $body = iconv('Big5', 'UTF-8//IGNORE', $res->getBody());

        $dom = HtmlDomParser::str_get_html($body);
        $names = $dom->find('td')[10]->plaintext;

        // 産生亂數電話號碼
        $name_tel_map = [];
        foreach(explode('、', $names) as $name) {
            if (mb_strlen(trim($name)) == 3) {
                $name_tel_map[] = [
                    'name' => trim($name),
                    'tel' => $this->random_mobile_phone_number(),
                ];
            }
        }

        // 寫入資料庫
        foreach($name_tel_map as $v) {
            $rec = new PhonebookService;
            $ret = $rec->create($v);
            $this->info(json_encode($v, JSON_UNESCAPED_UNICODE) . '已寫入');
            unset($ret);
            unset($rec);
        }

        $this->info('sto');
    }

    private function random_mobile_phone_number() {
        $base = '0123456789';
        $tail = '';
        for ($i = 1; $i <= 8; $i++) {
            $tail .= substr($base, rand(0, 10), 1);
        }
        return '09' . $tail;
    }
}
