<?php
/**
 * author: loen.wang email:425389019@qq.com
 * date:2017-06-06
 * eg:
 *  $excel = new ExcelOutput();
    $head = ['uid','nickname','email','phone','avatar','city'];
    
    $excel->setFileName("下载用户信息测试!");
    $excel->download($head,$userinfo);
 */
class Exceloutput {
	
	var $filename='默认excel文件名';

	/**
	 * 设置文件名
	 */
	function setFileName($filename){
		$this->filename = $filename;
	}

	/**
	 * 写入数据
	 */
	function setData($head = [],$data){

		if(empty($head)) {
			die("未指定输出字段!");
		}

		$xlsdata = "<table>";
	    $xlsdata .= "<tr>";
	    foreach($head as $v){
	     $xlsdata .= "<td>".iconv('utf-8','gb2312',$v)."</td>";
	    }
	    $xlsdata .= "<tr>";

	    // 逐行取出数据，节约内存
	    foreach ( $data as $key=>$val ) {
	      $xlsdata .= "<tr>";
	      foreach( $head as $hkey => $hval){
	      	$xlsdata .= "<td>".iconv('utf-8', 'gb2312', $val[$hval])."</td>";
	      }
	      $xlsdata .= "</tr>";
	    }

	    $xlsdata .= "</table>";

		return $xlsdata;

	}

	/**
	 * 下载excel
	 * @return [type] [description]
	 */
  	function download( $head = [], $data ){

	    ini_set('memory_limit','300M');

	    header('Content-Type: application/vnd.ms-excel;charset=utf-8');
	    $name = $this->filename.".xlsx";
	    header('Content-Disposition: attachment;filename='.$name.'');
	    header('Cache-Control: max-age=0');

	    $xlsdata = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
	      xmlns:x="urn:schemas-microsoft-com:office:excel"
	      xmlns="http://www.w3.org/TR/REC-html40">
	    <head>
	      <meta http-equiv="expires" content="Mon, 06 Jan 1999 00:00:01 GMT">
	      <meta http-equiv=Content-Type content="text/html; charset=gb2312">
	      <!--[if gte mso 9]><xml>
	      <x:ExcelWorkbook>
	      <x:ExcelWorksheets>
	       <x:ExcelWorksheet>
	       <x:Name></x:Name>
	       <x:WorksheetOptions>
	        <x:DisplayGridlines/>
	       </x:WorksheetOptions>
	       </x:ExcelWorksheet>
	      </x:ExcelWorksheets>
	      </x:ExcelWorkbook>
	      </xml><![endif]-->
	    </head>';

	    echo $xlsdata.$this->setData( $head, $data );

  	}

	
}