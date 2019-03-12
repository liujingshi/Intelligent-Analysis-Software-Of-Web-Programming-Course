<?php
namespace app\index\controller;

use \think\Db;

class Index
{
    public function index()
    {
        $sql = 'SELECT a.name, a.id, b.name iclass FROM eg a, iclass b WHERE a.class_id = b.id';
        $rows = Db::query($sql);
        $egs = [];
        foreach ($rows as $row) {
            if (array_key_exists($row['iclass'], $egs)) {
                $egs[$row['iclass']][] = $row;
            } else {
                $egs[$row['iclass']] = [$row];
            }
        }
        return view('index', [
            'iclass' => $egs
        ]);
    }
}
