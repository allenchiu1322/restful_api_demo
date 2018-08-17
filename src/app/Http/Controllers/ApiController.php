<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

use App\Http\Requests;

use App\Restful\Services\PhonebookService;

class ApiController extends Controller
{

    protected $phonebookService;

    public function __construct() {
        $this->phonebookService = new phonebookService;
    }

    // todo api crud functions

    public function build_api_param() {
        /*
        $param = [
            'action' => 'all_routes',
        ];
        $param = [
            'action' => 'stations_in_a_route',
            'route_id' => 2,
        ];
        $param = [
            'action' => 'search_stations',
            'search_string' => '橋',
        ];
        $param = [
            'action' => 'query_station',
            'station_id' => 35,
        ];
         */
        $param = [
            'action' => 'neighbor_stations',
            'station_id' => 35,
        ];
        return json_encode($param);
    }

    public function phonebook(Request $request, $id = null) {
        if ($request->isMethod('get')) {
            if ($id == null) {
                return Response::json($this->phonebookService->get_all_data());
            } else {
                $ret = $this->phonebookService->get_by_id($id);
                if (sizeof($ret) <= 0) {
                    return Response::json([
                        'errmsg' => '找不到資料'
                    ], 404);
                } else {
                    return Response::json($this->phonebookService->get_by_id($id));
                }
            }
        } else if ($request->isMethod('post')) {
            $name = trim($request->input('name'));
            $tel = trim($request->input('tel'));
            // todo 改用laravel內建validator
            if (($name == '') || ($tel == '')) {
                return Response::json([
                    'errmsg' => '參數錯誤'
                ], 400);
            } else {
                $this->phonebookService->create([
                    'name' => $name,
                    'tel'  => $tel,
                ]);
                return Response::json([
                    'result' => 'ok'
                ]);
            }
        } else if ($request->isMethod('put')) {
            $id = trim($request->input('id'));
            $name = trim($request->input('name'));
            $tel = trim($request->input('tel'));
            // todo 改用laravel內建validator
            if (($id == '') || ($name == '') || ($tel == '')) {
                return Response::json([
                    'errmsg' => '參數錯誤'
                ], 400);
            } else {
                $this->phonebookService->update([
                    'id' => $id,
                    'name' => $name,
                    'tel'  => $tel,
                ]);
                return Response::json([
                    'result' => 'ok'
                ]);
            }
        } else if ($request->isMethod('delete')) {
            // todo 改用laravel內建validator
            if ($id == null) {
                return Response::json([
                    'errmsg' => '參數錯誤'
                ], 400);
            } else {
                $this->phonebookService->delete([
                    'id' => $id,
                ]);
                return Response::json([
                    'result' => 'ok'
                ]);
            }
        } else {
            return Response::json([
                'errmsg' => '參數錯誤'
            ], 403);
        }
    }

        /*
    public function fetch_data(Request $request) {

        //參數檢查
        $param = json_decode($request->param);
        $check = TRUE;
        if (!$param) {
            $ret = $this->apiService->format_output('400', 'Param Error!');
            $check = FALSE;
        } else {
            $ret = $this->apiService->format_output('200', 'OK');
        }

        //處理資料
        if ($check) {
            $result = $this->dataFetchService->fetch_data($param);
            if ($result === TRUE) {
                $ret = $this->apiService->format_output('200', 'OK');
            } else {
                if (is_array($result)) {
                    if ((isset($result['result']) && isset($result['message']))) {
                        $ret = $this->apiService->format_output($result['result'], $result['message'], $result['body']);
                    } else {
                        $ret = $this->apiService->format_output('500', __FILE__ . __LINE__);
                    }
                } else {
                    $ret = $this->apiService->format_output('500', __FILE__ . __LINE__);
                }
            }

        }

        return $ret;

    }
         */
}
