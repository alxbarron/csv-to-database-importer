<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CsvHandlerController extends Controller
{
    private $folder = 'csv-imports';
    private $max_file_content = 1000;

    protected function fileImport($csv_file)
    {
        try {
            $file_extension = $csv_file->getClientOriginalExtension();
            $file_name = time().".$file_extension";
            $path = $csv_file->storeAs($this->folder, $file_name);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $path;
    }

    protected function getFileContent($file_name, $sample_length = 0, $initial_index = 0)
    {
        $path = storage_path('app');
        $file = file_exists("$path/$file_name") ?
                     file( "$path/$file_name" ) :[];
        
        if ($sample_length == 0) {
            $file_limited = array_slice($file, 0, $this->max_file_content);
            return array_map('str_getcsv', $file_limited);
        }

        $sample_length = $sample_length < $this->max_file_content ? 
                                                   $sample_length : $this->max_file_content;

        $array_content = array_slice($file, $initial_index, $sample_length++);
        
        return array_map('str_getcsv', $array_content);
    }
}
