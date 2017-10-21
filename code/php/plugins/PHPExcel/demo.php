<?php
// 下载地址: https://github.com/PHPOffice/PHPExcel/archive/1.8.0.zip
require './PHPExcel/PHPExcel.php';

// 导入
$data = Excel::import('demo.xlsx');
var_dump($data);


// 导出
$exportData = array(
    array('id' => '编号', 'name' => "姓名"),
    array('id' => 1, 'name' => "grass"), 
    array('id' => 2, 'name' => "Rainie"),
);
Excel::export('ok.xlsx', $exportData);

/**
 * 简单的导入导出示例
 */
class Excel
{
    /**
     * 读取Excel数据
     * @param  string $filename Excel文件路径
     * @return array           返回读取出来的二维数组
     */
    public static function import($filename){
        $inputFileType = PHPExcel_IOFactory::identify($filename);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($filename);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        $excelData = array();
        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                 $excelData[$row][] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
        }
        return $excelData;
    }

    /**
     * @param $name string 要保存的Excel的名字
     * @param $data 转换为表格的二维数组
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     */
    public static function export($name, $data){
        $objPHPExcel = new PHPExcel();
        //设置表格
        $objPHPExcel->getProperties()->setCreator($name)
            ->setLastModifiedBy($name)
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        //填充数据
        foreach ($data as $key => $row) {
            $num = $key + 1;
            $i = 0;
            foreach ($row as $key2 => $value2) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit(PHPExcel_Cell::stringFromColumnIndex($i). ($num), $value2, PHPExcel_Cell_DataType::TYPE_STRING);
                $i++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename={$name}");
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}
