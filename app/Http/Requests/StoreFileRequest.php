<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Helper;
class StoreFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
#            'file' => 'required|file|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf,zip'
#        ];
    }
    public function gsutil($file, $path, $name = null) {
      $temporal_dir  = config('constants.ruta_temporal');
      if($name === null) {
        $name = date('Y_m_d') . uniqid() . '.' . strtolower($file->extension());
      }
      //$file->move($temporal_dir, $name);
      $destino = trim($path, '/') . '/' . $name;

      //Helper::gsutil_mv($temporal_dir . $name, 'gs://creainter-peru/storage/' . $destino);
      Helper::gsutil_mv($file->getPathName(), 'gs://creainter-peru/storage/'. $destino, false);
      return $destino;
    }
}
