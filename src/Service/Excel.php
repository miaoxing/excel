<?php

namespace Miaoxing\Excel\Service;

use ErrorException;
use miaoxing\plugin\BaseService;
use PHPExcel_IOFactory;
use Wei\Logger;
use Wei\RetTrait;

/**
 * @property Logger logger
 */
class Excel extends BaseService
{
    use RetTrait;

    /**
     * @param string $file
     * @param int $cols 总共有多少列
     * @param int $startRow
     * @param int $maxRow 最多包含
     * @return mixed
     */
    public function parseToArray($file, $cols, $startRow = 2, $maxRow = 1000)
    {
        try {
            $excel = PHPExcel_IOFactory::load($file);
        } catch (ErrorException $e) {
            $this->logger->info($e);

            return $this->err('很抱歉,解析失败,请检查您的文件内容');
        }

        $sheet = $excel->getActiveSheet();

        // 逐行获取数据
        $data = [];
        $endRow = $maxRow + 1;
        for ($i = $startRow; $i < $endRow; ++$i) {

            // 获取一行的数据
            $rows = [];
            $endCol = $cols + 1;
            for ($j = 1; $j < $endCol; ++$j) {
                $rows[] = (string) $sheet->getCell($this->toLetter($j) . $i)->getValue();
            }

            // 如果当前行为空,不再获取
            if (array_unique($rows) == ['']) {
                break;
            } else {
                $data[] = $rows;
            }
        }

        if ($i == $endRow) {
            return ['code' => -2, 'message' => sprintf('表格不能超过%s行', $maxRow)];
        }

        if (empty($data)) {
            return ['code' => -3, 'message' => '表格数据为空,请根据范例填写后再提交'];
        }

        // 检查是否某一个格子为空
        /*foreach ($data as $i => $rows) {
            foreach ($rows as $j => $cell) {
                if (!$cell) {
                    return $this->json(-4, sprintf('表格的第%s行%c列为空,请检查后再提交', $i + $startRow, $j + 65));
                }
            }
        }*/

        return [
            'code' => 1,
            'message' => '解析表格数据成功',
            'total' => count($data),
            'data' => $data,
        ];
    }

    protected function toLetter($number)
    {
        return strtoupper(chr($number + 96));
    }
}
