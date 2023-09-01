<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Oportunidad;
use App\Licitacion;
use App\Correo;
use App\Credencial;
use App\Facades\DB;
use Auth;
use App\User;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Http\GraphRequest;
use Microsoft\Graph\Http\GraphResponse;
use Microsoft\Graph\Exception\GraphException;

use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;

class CorreoController extends Controller {

  protected $viewBag = [];

  public function __construct(){

    $this->middleware('auth');
    $this->viewBag['pageConfigs'] = ['pageHeader' => true];
    $this->viewBag['breadcrumbs'] = [
        [ 
          "link" => "/dashboard",
          "name" => "Home" 
        ],
      [ "link" => "/correos", "name" => "Correos" ]
    ];

  }
  public function index(Request $request) {
    return view('correo.index2');
  }
  public function tablefy(Request $request, Credencial $credencial) {
    $listado = Correo::buzon($credencial)
    ->appends(request()->input())
    ->map(function($n) {
      return [
        tiempo_transcurrido($n->fecha),
        empty($n->leido_el) ? '<b>' . $n->asunto . '</b>' : $n->asunto,
        $n->leido_por,
      ];
    })
    ->get();
    return $listado->response();
  }
  public function buzon(Request $request) {
    return view('correo.buzon');
  }
  public function oldindex(Request $request) {

    /*try {
        GraphHelper::initializeGraphForAppOnlyAuth();
        $messages = GraphHelper::getMessagesByUserId();  
        dd($messages->getPage()); 
        foreach ( $messages->getPage() as $mesage ) {
          dd($mesage ); 
        }
        dd( $messages->getPage());
  
        $users = GraphHelper::getUsers();

        // Output each user's details

        foreach ( $users->getPage() as $user ) {
            print('User: '.$user->displayName.'</br>' );
            print('ID: '.$user->id. '</br>' );
            $email = $user->mail ;
            $email = isset($email) ? $email : 'NO EMAIL';
            print('Email: '.$email. '</br> </br>');
        }

        $moreAvailable = $users->isEnd() ? 'False' : 'True';
        print(PHP_EOL.'More users available? '.$moreAvailable.PHP_EOL.PHP_EOL);
    } catch (Exception $e) {
        print(PHP_EOL.'Error getting users: '.$e->getMessage().PHP_EOL.PHP_EOL);
    }
    exit;
    //dd('Hello, '.$user->getDisplayName().'!'.PHP_EOL);
    */
    $search = $request->input('search');

    if ( !empty($search) ) {
      $listado = Correo::search($search)->orderBy('created_on', 'desc')->paginate(15)
        ->appends(request()->query());
    } else {
      $listado = Correo::orderBy('created_on', 'desc')
      ->whereRaw('texto is not null')
      ->paginate(50)->appends(request()->query());

    }

    $this->viewBag['listado'] = $listado;

    return view('correo.index', $this->viewBag);
  }
  public function responder(Request $request, Correo $correo) {
    return view( 'correo.responder', compact('correo'));
  }
  public function responder_store(Request $request, Correo $correo) {
    $data = $request->all();
    $perfil_id = $request->input('perfil_id');

    if(empty($correo->cid)) {
      return response()->json([
        'status'   => false,
        'message'  => 'correo sin cid',
      ]);
    }
    if(empty($perfil_id)) {
      return response()->json([
        'status'   => false,
        'message'  => 'Debe seleccionar una empresa',
      ]);
    }
    $perfil = User::perfil($perfil_id);
    print_r($perfil);
    if(empty($perfil) || empty($perfil->ex_user_id)) {
      return response()->json([
        'status'   => false,
        'message'  => 'Perfil incorrecto',
      ]);
    }

    $f  = '<br><br><table><tr><td style="width:200px;">';
    $f .= "<img src=\"cid:logo\" style=\"width:170px;\">";
    $f .= '</td><td style="width:400px;font-size:11px;">';
    $f .= '<b>' . $perfil->cargo . '</b><br>';
    $f .= 'Tel. ' . $perfil->linea . ' Anexo ' . $perfil->anexo . '<br/>';
    $f .= 'Mail: ' . $perfil->correo . '<br/>';
    $f .= '</td></tr></table>';


    $graph = new Graph();
    $graph->setAccessToken($perfil->ex_access_token);

  $replyMessage = array(
    "message" => array(
      "subject" => $data['asunto'],
      "body" => array(
        "contentType" => "html",
        "content" => $data['texto'] . $f,
      ),
      "toRecipients" => array(
        array(
          "emailAddress" => array(
            "address" => $correo->correo_desde,
          )
        )
      ),
      "from" => array(
        "emailAddress" => array(
          "address" => $perfil->correo,
        )
      ),
    ),
    "saveToSentItems" => true
  );
  if(!empty($perfil->logo)) {
      $archivo_logo = gs(config('constants.ruta_storage') . $perfil->logo);
      if(!empty($archivo_logo)) {
        $replyMessage['message']['attachments'][] = array(
          "@odata.type" => "#microsoft.graph.fileAttachment",
          "name" => "logo.png",
          "contentBytes" => base64_encode(file_get_contents($archivo_logo)),
          "isInline" => true,
          "contentId" => "logo"
        );
      }
    }
    if(!empty($data['adjunto'])) {
      foreach($data['adjunto'] as $ad) {
        $replyMessage['message']['attachments'][] = array(
          "@odata.type" => "#microsoft.graph.fileAttachment",
          "name" => $ad->getClientOriginalName(),
          "contentBytes" => base64_encode(file_get_contents($ad->getRealPath())),
        );
      }
    }
    try {
      $response = $graph->createRequest('POST', '/users/' . $perfil->ex_user_id . '/messages/' . $correo->cid . '/reply')
//        $response = $graph->createRequest('POST', '/users/' . $perfil->ex_user_id . '/sendMail')
        ->attachBody($replyMessage)
        ->execute();
    } catch (ClientException | ServerException $err) {
      print_r($err->getMessage());
      exit;
      $response = false;
    }
    return redirect('/correos');
}

  public function ver(Request $request, Correo $correo) {
    if(empty($correo->leido_el)) {
      $correo->update([
        'leido_el'  => DB::raw('now()'),
        'leido_por' => Auth::user()->id,
      ]);
    }
    return view( 'correo.ver', compact('correo'));
  }
  public function descargar(Request $request, Correo $correo, $uid) {
    $credencial = $correo->credencial();
    if(empty($correo->adjuntos)) {
      exit;
    }
    foreach($correo->adjuntos as $a) {
      if($a['id'] == $uid) {
        $graph = new Graph();
        $graph->setAccessToken($credencial->ex_access_token);
        try {
          $graphResponse = $graph->createRequest('GET', '/users/' . $credencial->ex_user_id . '/messages/' . $correo->cid . '/attachments/' . $uid)
          ->execute();

        } catch (GuzzleHttp\Exception\ClientException $err) {
          echo "Error:";
          print_r($err->getMessage());
          exit;
        }
        $res = $graphResponse->getBody();
        return response(base64_decode($res['contentBytes']))
            ->header('Content-Type', $res['contentType'])
            ->header('Content-Disposition', 'attachment;filename=' . $res['name']);
      }
    }
    exit;
  }
  
  public function create(Request $request) {
    return view('correo.create');
  }
  
  public function store(Request $request) {
    $data = $request->all();
    $perfil_id = $request->input('perfil_id');

    if(empty($perfil_id)) {
      return response()->json([
        'status'   => false,
        'message'  => 'Debe seleccionar una empresa',
      ]);
    }
    $perfil = User::perfil($perfil_id);
    if(empty($perfil) || empty($perfil->ex_user_id)) {
      return response()->json([
        'status'   => false,
        'message'  => 'Perfil incorrecto',
      ]);
    }

    $f  = '<br><br><table><tr><td style="width:200px;">';
    $f .= "<img src=\"cid:logo\" style=\"width:170px;\">";
    $f .= '</td><td style="width:400px;font-size:11px;">';
    $f .= '<b>' . $perfil->cargo . '</b><br>';
    $f .= 'Tel. ' . $perfil->linea . ' Anexo ' . $perfil->anexo . '<br/>';
    $f .= 'Mail: ' . $perfil->correo . '<br/>';
    $f .= '</td></tr></table>';


    $graph = new Graph();
    $graph->setAccessToken($perfil->ex_access_token);

  $replyMessage = array(
    "message" => array(
    "from" => array(
      "emailAddress" => array(
        "address" => $perfil->correo,
      )
    ),
    "toRecipients" => array(
      array(
        "emailAddress" => array(
          "address" => $data['para'],
        )
      )
    ),
    "subject" => $data['asunto'],
    "body" => array(
      "contentType" => "html",
      "content" => $data['texto'] . $f,
    ),
  ),
    "saveToSentItems" => true
  );
  if(!empty($perfil->logo)) {
      $archivo_logo = gs(config('constants.ruta_storage') . $perfil->logo);
      if(!empty($archivo_logo)) {
        $replyMessage['message']['attachments'][] = array(
          "@odata.type" => "#microsoft.graph.fileAttachment",
          "name" => "logo.png",
          "contentBytes" => base64_encode(file_get_contents($archivo_logo)),
          "isInline" => true,
          "contentId" => "logo"
        );
      }
    }
    if(!empty($data['adjunto'])) {
      foreach($data['adjunto'] as $ad) {
        $replyMessage['message']['attachments'][] = array(
          "@odata.type" => "#microsoft.graph.fileAttachment",
          "name" => $ad->getClientOriginalName(),
          "contentBytes" => base64_encode(file_get_contents($ad->getRealPath())),
        );
      }
    }
    try {
      $response = $graph->createRequest('POST', '/users/' . $perfil->ex_user_id . '/sendMail')
        ->attachBody($replyMessage)
        ->execute();
    } catch (ClientException | ServerException $err) {
      $response = false;
    }
    return redirect('/correos');

    if( !empty($data['empresa_id']) ) {
      $cliente = Cliente::porEmpresaForce($data['empresa_id']);
      $data['cliente_id'] = $cliente->id;
    }

    $correo->fill($data);
    $correo->save();
    $correo->log( 'creado');

    return response()->json([ 
      'status' => "success",
      'data' => [
        "value" => $correo->nombres . " " . $correo->apellidos,
        "id" => $correo->id 
      ],
      'redirect' => '/correos'
    ]);
  }

  public function edit(Request $request, Correo $correo) {

    $this->viewBag['correo'] = $correo;
    $this->viewBag['breadcrumbs'][]  = [ 'name' => "Editar Correo" ]; 
    return view('correos.edit',$this->viewBag );    

  }

  public function update( Request $request,Correo  $correo  ) {

    $correo->update($request->all());

    return response()->json([ 
      'status' => true,
      'redirect' => '/correos',
    ]);
  }

  public  function destroy(Correo $correo  ){
    $correo->eliminado = true;
    $correo->save();
    $correo->log('eliminado');    
    return response()->json(['status'=> true , 'refresh' => true  ]); 
  }

  public function autocomplete(Request $request) {
    $term = $request->input('query');
    $data = Correo::search($term)->selectRaw(" correo.id, concat_ws(' ',correo.nombres, correo.apellidos) as value")->get();
    return response()->json($data);
  }
  public function observacion(Request $request, Correo $correo) {
    $correo->log('texto',$request->input('texto'));
    return back();
  }
  public function fast( Correo $correo ){
    return view( 'correos.fast', [ 'correo' => $correo ]); 
  }

  public function show( Correo $correo) {

    $contacto = $correo->contacto();
    $adjuntos = $correo->adjuntos();

    return response()->json([ 'status' => true,
    'correo' => $correo, 'contacto' => $contacto, 'adjuntos' => $adjuntos ]);   

  }

}
