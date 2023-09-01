<?php                                                                                                                                                           
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Survey;
use App\User;
use App\Oportunidad;
use App\Correo;
use App\CorreoHilo;
use App\Facades\DB;
use App\Contacto;
use App\Mail\UserMasiveMail;
use App\Helpers\GraphHelper;

class ReadEmail extends  Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:read';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Leer Correo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {     
      exit;
        $c = [
          'tenant_id' => 1,
          'id' => 3,
          'empresa_id' => 1 
        ];

        GraphHelper::initializeGraphForAppOnlyAuth();
        $messages = GraphHelper::getMessagesByUserId();

        foreach( $messages->getPage() as $message ) {
           
          $from = $message->getFrom()->getEmailAddress();
          $date = $message->getReceivedDateTime();
          //dd($from->getName());

          $busqueda = DB::select("SELECT * FROM osce.contacto_por_correo(:tid, :cid)", ['tid' => $c['tenant_id'], 'cid' => $from->getAddress()]);

          if( isset($busqueda[0])  ){
            $busqueda = (array) $busqueda[0];
          }

          if ( !empty($busqueda['contacto_id']) ) {

            $contacto_id = $busqueda['contacto_id'];
            $contacto =  Contacto::find($contacto_id);
            $contacto->correo_nombre = $from->getName();
            $contacto->save();
            //DB::update('osce.contacto', ['correo_nombre' => $from->getName()], 'id = ' . $contacto_id);

          } else {

            $contacto = new Contacto();
            $contacto->nombres = $from->getName() ?? null;
            $contacto->correo_nombre = $from->getName() ?? null ;
            $contacto->correo  = $from->getAddress()?? null;
            $contacto->cliente_id = $busqueda['cliente_id'] ?? null;
            $contacto->empresa_id = $busqueda['empresa_id'] ?? null;
            $contacto->tenant_id  = $c['tenant_id'] ?? null;
            $contacto->save();
            $contacto_id = $contacto->id;
            /*$contacto_id = DB::insert('osce.contacto', [
              'nombres' => $from->getName() ?? null,
              'correo_nombre' => $from->getName() ?? null ,
              'correo'  => $from->getAddress()?? null,
              'cliente_id' => $busqueda['cliente_id'] ?? null,
              'empresa_id' => $busqueda['empresa_id'] ?? null,
              'tenant_id'  => $c['tenant_id'] ?? null,
            ]);*/

          }

          $excor = DB::select("SELECT id, length(texto) contenido FROM osce.correo WHERE cid = :cid", ['cid' => $message->getId()  ]);

          $excor = !isset($excor[0]) ? (array) $excor[0] : null;

          if ( !empty($excor) ) {
            $correo_id = $excor['id'];

          } else {

            $correo = new Correo(); 
            $correo->tenant_id    = $c['tenant_id'];
            $correo->correo_desde = $from->getAddress();
            $correo->asunto       = $message->getSubject();
            $correo->empresa_id   = $busqueda['empresa_id'] ?? null;
            $correo->credencial_id= $c['id'];
            $correo->cid          = $message->getId();
            $correo->fecha        = $date->format( 'Y-m-d H:i:s');
            $correo->adjuntos_cantidad =   $message->getAttachments() !== null  ? count( $message->getAttachments()) : 0 ;
            $correo->save();

            $correo_id = $correo->id;

          }

          //Obtener contenido - Guardar 

          $limpio =  quitar_tildes($message->getSubject() );

          $seguimiento = trim(preg_replace("/^rv\:/", "", $limpio));
          $seguimiento = trim(preg_replace("/^re\:/", "", $seguimiento));
          $seguimiento = trim(preg_replace("/^fwd\:/", "", $seguimiento));

          echo $limpio . "\n";

          $tags = array('solicitud de cotizacion','terminos de referencia','remitir su cotizacion','cotizacion','cotización','invitacion','requerimiento','reiterativo','contratacion','adquisicion','cotizar','servicio de','solicito');

          $tags = implode('|', $tags);

          if ( !empty($message->attachments) && preg_match("/\b(" . $tags . ")\b/i", $limpio, $matches)) {
            //$body = $x->getContent($n->uidd);
            $body = $message->getHTMLBody();

            if ( empty($excor['contenido']) ) {
              $correo = Correo::find($correo_id);
              $correo->texto = $body; 
              $correo->save();

              /*DB::update('osce.correo', [
                'texto' => $body
              ], 'id = ' . $correo_id);*/

            }

            echo "COT: " . $message->getSubject() . "\n";
            $limpio = trim(preg_replace("/^rv\:/", "", $limpio));
            $limpio = trim(preg_replace("/^re\:/", "", $limpio));
            $limpio = trim(preg_replace("/^fwd\:/", "", $limpio));

            $parcial = $limpio;

            $limpio = str_replace('solicitud de cotizacion', '', $limpio);
            $limpio = str_replace('contratacion del', '', $limpio);
            $limpio = str_replace('compra de', '', $limpio);
            $limpio = str_replace('adquisicion de', '', $limpio);
            $limpio = str_replace('cotizar urgente', '', $limpio);
            $limpio = str_replace('cotizar', '', $limpio);
            $limpio = str_replace('reiterativo', '', $limpio);

            $limpio = trim_array($limpio, [' ','"','-','.',',']);

            if(empty($limpio)) {
              $limpio = $parcial;
            }

            $limpio = strtoupper($limpio);

            if(empty($limpio)) {
              $limpio = $parcial;
            }

            $limpio = strtoupper($limpio);

            $exopor = DB::select("
              SELECT id, correo_id
              FROM osce.oportunidad
              WHERE rotulo = :rr AND created_on >= NOW() - INTERVAL '12' DAY AND contacto_id = :cc
              AND correo_id IS NOT NULL", [
                'rr' => $limpio,
                'cc' => $contacto_id,
            ]);

            print_r($exopor);

            $exopor = !isset($exopor[0]) ? (array) $exopor[0] : null;

            if ( !empty($exopor) ) {

              if ( $exopor['correo_id'] != $correo_id ) {

                $dd = DB::select("SELECT token_id FROM osce.correo_hilo WHERE correo_id = :id", ['id' => $exopor['correo_id']]);

                $dd = !isset($dd[0]) ? (array) $dd[0] : null;

                if( !empty($dd) ) {

                  $ff = DB::select("SELECT token_id FROM osce.correo_hilo WHERE token_id= :t and correo_id = :b", ['t' => $dd['token_id'], 'b' => $correo_id]);

                  $ff = !isset($ff[0]) ? (array) $ff[0] : null;

                  if(empty($ff)) {
                    DB::insert('osce.correo_hilo', [
                      'token_id'   => $dd['token_id'],
                      'correo_id' => $correo_id,
                    ]);
                  }

                } else {

                  $uniqid = uniqid();

                  DB::insert('osce.correo_hilo', [
                    'token_id'   => $uniqid,
                    'correo_id' => $exopor['correo_id'],
                  ]);

                  DB::insert('osce.correo_hilo', [
                    'token_id'   => $uniqid,
                    'correo_id' => $correo_id,
                  ]);
                }
              }
            }


            //$exopor2 = DB::select("SELECT id FROM osce.oportunidad WHERE correo_id = :cid", ['cid' => $correo_id]);
            //print_r($exopor2);

            $opx = DB::select("SELECT osce.fn_registrar_oportunidad_de_correo(:tenant, :correo, :usuario, :empresa, :fecha) id;", [
              'fecha'   => $date->format("Y-m-d"),
              'tenant'  => $c['tenant_id'],
              'correo'  => $correo_id,
              'usuario' => 1,
              'empresa' => $c['empresa_id'],
            ]);

            $opx = !isset($opx[0]) ? (array) $opx[0] : null;

            if ( !empty($opx) && !empty($opx['id'])) {

              echo "id => " . $opx['id'] . "\n";
              $oportunidad = DB::select("SELECT * FROM osce.oportunidad WHERE id = " . $opx['id']);

              if ( empty($oportunidad)) {
                echo "Sin oportunidad\n";
                continue;
              }

              $archivos = $message->getAttachments();
              $subidos = 0;

              foreach( $archivos as $ar ) {

                $ecorreo = DB::select("SELECT * FROM osce.documento WHERE correo_id = :correo AND filename = :filename", [
                  'correo' => $correo_id,
                  'filename' => $ar->name,
                ]);

                $ecorreo = !isset($ecorreo[0]) ? (array) $ecorreo[0] : null;

                if ( empty( $ecorreo ) ) {

                  $status = $ar->save("/var/www/html/interno.creainter.com.pe/temp/");

                  $root = "/var/www/html/interno.creainter.com.pe/temp/" . $ar->name;

                  $directorio   = 'OPORTUNIDADES/' . $oportunidad['codigo'] . '/CORREO-' . $correo_id;

                  $file_rotulo  = $ar->name;
                  $extension = explode(".", $ar->name());
                  $extension = $extension[count($extension) - 1];
                  $file_archivo = gs_file( $extension );
                  $destination = 'tenant-' . $c['tenant_id'] . '/' . $file_archivo;

                  gsutil_cp( $root, 'gs://creainter-peru/storage/' . $destination);

                  DB::insert('osce.documento', [
                    'empresa_id' => $oportunidad['empresa_id'] ?? null,
                    'correo_id'  => $correo_id,
                    'oportunidad_id' => $oportunidad['id'],
                    'tenant_id'  => $c['tenant_id'],
                    'archivo'    => $destination,
                    'rotulo'     => $file_rotulo,
                    'filename'   => $file_rotulo,
                    'directorio' => $directorio,
                    'filesize' => filesize($root),
                    //'filesize'   => $ar->size,
                    //'formato'  => strtoupper(file_ext($ar['filename'])),
                    'formato'    => strtoupper($ar->getExtension()),
                    'folio'      => 0,
                    'tipo'       => 'ADJUNTO',
                    'created_by' => 1,
                  ]);

                }

                @unlink($root);
              }

              $oportunidad = Oportunidad::find($opx['id']);
              $oportunidad->rotulo     = $limpio;
              $oportunidad->automatica = 1;
              $oportunidad->cliente_id = $busqueda['cliente_id'] ?? null;
              $oportunidad->empresa_id = $busqueda['empresa_id'] ?? null;
              $oportunidad->contacto_id = $contacto_id;
              $oportunidad->save();

              /*
              DB::update('osce.oportunidad', [
                'rotulo'     => $limpio,
                'automatica' => 1,
                'cliente_id' => $busqueda['cliente_id'],
                'empresa_id' => $busqueda['empresa_id'],
                'contacto_id' => $contacto_id,
              ], 'id = ' . $opx['id']);*/

              DB::select("SELECT osce.oportunidad_etiquetar_sin_licitacion(:tenant, :id, :user)", [
                'tenant' => $c['tenant_id'],
                'id'     => $opx['id'],
                'user'   => 1,
              ]);

            }
          //$ops ++;

        }
      } 
    }
        
}            
