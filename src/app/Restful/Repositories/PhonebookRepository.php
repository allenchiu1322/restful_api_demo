<?php
namespace App\Restful\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Phonebook;

class PhonebookRepository {

    /**
     * 依姓名搜尋
     */
    public function search_by_name($search_string) {
        $ret = Station::where([
            ['name', 'LIKE', '%' . $search_string . '%'],
        ])
        ->select('id', 'name', 'tel')
        ->get();
        return $ret;
    }

    /**
     * 依電話搜尋
     */
    public function search_by_tel($search_string) {
        $ret = Station::where([
            ['tel', 'LIKE', '%' . $search_string . '%'],
        ])
        ->select('id', 'name', 'tel')
        ->get();
        return $ret;
    }

    /**
     * 取得單一記錄資訊
     */
    public function query_phonebook($phonebook_id) {
        $ret = Phonebook::where([
            ['id', '=', $phonebook_id],
        ])
        ->select('id', 'name', 'tel')
        ->get();
        return $ret;
    }

    /**
     * 取得所有資料
     */
    public function get_all_phonebook() {
        $ret = Phonebook::orderBy('id', 'asc')
            ->select('id', 'name', 'tel')
            ->get();
        return $ret;
    }

    /**
     * 建立單筆資料
     */
    public function create($data) {
        $phonebook = new Phonebook;
        $phonebook->name = $data['name'];
        $phonebook->tel  = $data['tel'];
        $phonebook->save();

        return $phonebook;
    }

    /**
     * 更新單筆資料
     */
    public function update($data) {
        $ret = $this->query_phonebook($data['id']);
        $record = $ret[0];

        $record->name = $data['name'];
        $record->tel = $data['tel'];
        $record->save();

        return $record;
    }

    /**
     * 刪除單筆資料
     */
    public function delete($data) {
        $ret = $this->query_phonebook($data['id']);
        $record = $ret[0];

        $record->delete();

        return true;
    }

}

