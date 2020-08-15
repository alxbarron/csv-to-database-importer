<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends CsvHandlerController
{
    protected $fields = ['team_id', 'name', 'email', 'phone'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactList = Contact::with('customAttributes')->get();
        
        return view('contact_list.index', compact('contactList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request)
    {
        try {
            $request->validate(['csv-file' => 'file|mimes:csv,txt']);
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        }

        $path = $this->fileImport( $request->file('csv-file') );
        $sample = $this->getFileContent($path, $sample_length = 1);
        
        if ( empty($sample) )            
            return response()->json(
                ['success' => false, 'message' => $path],
                Response::HTTP_INTERNAL_SERVER_ERROR);

        $response = [
            'success' => true,
            'data' => [
                'fields' => $this->fields,
                'file_headers' => $sample[0],
                'content_sample' => $sample,
                'csv_file' => $path
            ],
            'message' => 'CSV file Uploaded successfully'
        ];

        return response()->json($response, 200);
    }

    /**
     * Import the specified resource in storage to database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importContacts(Request $request)
    {
        try {
            $request->validate(['csv_file' => 'required|string', 'csv_field' => 'required']);
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        }
        
        $file_path = $request->csv_file;
        $csv_content = $this->getFileContent($file_path);

        return response()->json(['success' => true], 200);
    }
}
