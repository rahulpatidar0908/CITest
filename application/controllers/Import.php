<?php
/**
 * Description of Import Controller
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Import extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Import_model', 'import');
    }

    // upload xlsx|xls file
    public function index() {
        $data['page'] = 'import';
        $data['title'] = 'Import XLSX | TechArise';
        $this->load->view('import/index', $data);
    }
    // import excel data
    public function save() {
        $this->load->library('excel');
        
        if ($this->input->post('importfile')) {
            $path = './upload/';

            $config['upload_path'] = $path;
            $config['allowed_types'] = 'xlsx|xls|jpg|png';
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('userfile')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
                die;
            } else {
                $data = array('upload_data' => $this->upload->data());
            }
            
            if (!empty($data['upload_data']['file_name'])) {
                $import_xls_file = $data['upload_data']['file_name'];
            } else {
                $import_xls_file = 0;
            }
            $inputFileName = $path . $import_xls_file;
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                        . '": ' . $e->getMessage());
            }
            $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            
            $arrayCount = count($allDataInSheet);
            $flag = 0;
            $createArray = array('first_name', 'contact_no');
            $column_count= count($createArray);
            $makeArray = array('first_name' => 'first_name', 'contact_no' => 'contact_no');
            $SheetDataKey = array();

            echo "<pre>";
            $temp=array();
            foreach ($allDataInSheet as $rowNo => $dataInSheet) {
               
                foreach ($dataInSheet as $key => $value) {


                    if (in_array(trim($value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                    echo $key;
                    var_dump($value);
                        $SheetDataKey[trim($value)] = $key;
                    } else {

                        $temp[$rowNo][]=$value;
                    }
                }
            }

            for ($i = 2; $i <= $arrayCount; $i++) {
                $addresses = array();
                $firstName = $temp[$i][0];
                $contactNo = $temp[$i][1];
                
                $fetchData[] = array('first_name' => $firstName,'contact_no' => $contactNo,'uploaded_file'=>$import_xls_file   );
            }     

            //save to mysql         
            $this->db->insert_batch('import', $fetchData); 
               
            
        }
        $result_data_excel = $this->import->get_excel();
        $this->load->view('import/display', array('excel_file_list'=>$result_data_excel));
        
    }
    function get_excel_list(){
        $result_data_excel = $this->import->get_excel();
        $this->load->model('Import_model', 'ImportData');
        $resultExcel = $this->ImportData->get_excel();
        $this->load->view('import/display', array('excel_file_list'=>$resultExcel));
    }
    function get_excel(){
        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            return $row;
        }
    }

    function get_file_data()
    {
        $file_name=$this->input->post('file_name');
       // print_r($file_name);
        $result_data_excel = $this->import->get_one_excel($file_name);
        echo json_encode($result_data_excel);
        exit();
    }
    
}
?>