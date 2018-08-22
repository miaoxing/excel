<?php

namespace Miaoxing\Excel\Controller\Admin;

class Excel extends \Miaoxing\Plugin\BaseController
{
    protected $guestPages = ['admin/excel/parseToJson', 'admin/excel/uploadAndParseToJson'];

    public function parseToJsonAction($req)
    {
        $cols = $req['cols'] ?: 10;

        if (!is_file($req['file'])) {
            return $this->err('文件不存在');
        }

        $ret = wei()->excel->parseToArray($req['file'], $cols);

        return $ret;
    }

    public function uploadAndParseToJsonAction($req)
    {
        $upload = wei()->upload;

        $result = $upload([
            'name' => '文件',
            'exts' => ['xls', 'xlsx'],
            'dir' => wei()->upload->getDir() . '/files/' . date('Ymd'),
        ]);
        $req['file'] = $upload->getFile();

        return $this->parseToJsonAction($req);
    }
}
