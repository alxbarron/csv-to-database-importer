<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends CsvHandlerController
{
    protected $fields = ['team_id', 'name', 'email', 'phone', 'sticky_phone_number_id'];

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
            $request->validate(['csv-file' => 'file|mimes:csv,txt|between:1,200']);
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
        
        $csv = $this->getFileContent( $request->csv_file );
        if ( count($csv) < 2 ) 
            return response()->json(['success' => false, 'message' => 'File not suitable for import'], Response::HTTP_BAD_REQUEST);

        array_shift($csv); // Remove header
        $csv_fields = collect($request->csv_field);
        $custom_fields = collect($request->custom_attr);
        
        try {
            foreach ($csv as $csv_line) {
                $contact_data = $csv_fields->mapWithKeys(function ($item, $key) use ($csv_line) {
                    return [$item => $csv_line[$key]];
                });
                $contact = Contact::create( $contact_data->toArray() );
                
                $custom_attributes = [];
                foreach($custom_fields as $key => $value) {
                    array_push($custom_attributes, ['key' => $value, 'value' => $csv_line[$key]]);
                }

                $contact->customAttributes()->createMany($custom_attributes);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        

        return response()->json(['success' => true], 200);
    }
}
