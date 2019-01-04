<?php

namespace Miaoxing\Excel\Service;

use ErrorException;
use Miaoxing\Plugin\BaseService;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Wei\Logger;
use Wei\Response;
use Wei\RetTrait;

/**
 * @property Logger logger
 * @property Response response
 */
class Excel extends BaseService
{
    use RetTrait;

    /**
     * @param string $file
     * @param int $cols 总共有多少列
     * @param int $startRow
     * @param int $maxRow 最多包含
     * @return array
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
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
        if ($sheet->getHighestRow() > $maxRow + 1) {
            return $this->err(['表格不能超过%s行', $maxRow], -2);
        }

        $data = $sheet->toArray();
        $data = array_slice($data, $startRow - 1);
        $data = $this->removeNullRow($data);

        if (!$data) {
            return $this->err('表格数据为空,请根据范例填写后再提交', -3);
        }

        return $this->suc([
            'message' => '解析文件成功',
            'total' => count($data),
            'data' => $data,
        ]);
    }

    protected function removeNullRow($data)
    {
        for ($i = count($data) - 1; $i > 0; $i--) {
            $row = array_unique($data[$i]);
            if ($row == [null]) {
                unset($data[$i]);
            } else {
                return $data;
            }
        }
        return $data;
    }

    public function export($fileName, $data)
    {
        $res = $this->response;
        $res->setHeader([
            'Content-type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment;filename=' . $fileName . '.xlsx',
        ]);
        $res->sendHeader();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $startRow = '1';
        $startColumn = 'A';

        foreach ($data as $rowData) {
            $currentColumn = $startColumn;
            foreach ($rowData as $cellValue) {
                // 大于15位数字开始变0 12位空间不足变科学计数法
                if (is_numeric($cellValue) && strlen($cellValue) >= 12) {
                    $sheet->setCellValueExplicit($currentColumn . $startRow, $cellValue, DataType::TYPE_STRING);
                } else {
                    $sheet->setCellValue($currentColumn . $startRow, $cellValue);
                }
                ++$currentColumn;
            }
            ++$startRow;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
