<?php

namespace Miaoxing\Excel\Service;

use Miaoxing\Plugin\BaseService;
use Wei\RetTrait;

/**
 * Import
 */
class Import extends BaseService
{
    use RetTrait;

    public function import($data, $fn)
    {
        if (!$data) {
            return $this->err('没有读取到导入的数据');
        }

        $rets = [];
        $sucCount = 0;
        $errCount = 0;
        foreach ((array) $data as $i => $row) {
            $index = $i + 1;
            $ret = $fn($row);
            if ($ret['code'] !== 1) {
                $ret['message'] = '第' . $index . '行错误:' . $ret['message'];
                ++$errCount;
                $rets[] = $ret;
                continue;
            } else {
                ++$sucCount;
            }
        }

        array_unshift($rets, $this->suc([
            '一共处理了%s行数据,%s行数据导入成功,%s行数据导入失败',
            count($data),
            $sucCount,
            $errCount,
        ]));

        return $this->suc(['rets' => $rets]);
    }
}
