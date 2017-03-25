<?php

namespace Proyecto\UserBundle\Controller;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Proyecto\UserBundle\Entity\Archivo;
use Proyecto\UserBundle\Entity\User;
use Proyecto\USerBundle\Models\Document;
use Proyecto\UserBundle\Form\UserType;

class UserController extends Controller
{
    
    
    
    public function listaUsuariosAction(){
        
         return $this->render('ProyectoUserBundle:User:listaUsuarios.html.twig');
    }
    public function acercaDeMiAction(){
        
         return $this->render('ProyectoUserBundle:User:acercaDeMi.html.twig');
    }
    public function homeAction(){
        
        return $this->render('ProyectoUserBundle:User:home.html.twig');
    }
    public function indexAction()
            
    {
      $repositorio=$this->getDoctrine()->getRepository('ProyectoUserBundle:Archivo');
      $query=$repositorio->createQueryBuilder('a')->orderBy('a.createdAt','DESC')->setMaxResults( 3)->getQuery();
              
      $archivos=$query->getResult();
        
        return $this->render('ProyectoUserBundle:User:index.html.twig',array('archivos'=>$archivos));
    }
    
     public function subirAction(Request $request) {

        if ($request->getMethod() == 'POST') {
            $image = $request->files->get('archivito');

            if (($image instanceof UploadedFile) && ($image->getError() == '0'))/* image es un instancia de uploadfile  y si no hay la crea   y el get error es igual a cero osea estatus recicibiod bien, pero todavia no se  guarda */ {
                if (($image->getSize() < 2000000000)) {
                    $originalName = $image->getClientOriginalName(); /* retorna el nombre del archivo original */

                    $name_array = explode('.', $originalName); /* separa los elemento que tengan un punto */
                    $file_type = $name_array[sizeof($name_array) - 1]; /* obtiene la extension del largo menos uno, me duevle la extension ya que empieza de cero el arreglo y termina en sizeof menos uno */
                    $valid_filetypes = array('jpg', 'jpeg', 'png'); /* crea un arreglo con todas las extenciones que vas a aceptar, valida que estos suban esos tipos de archivos */
                    if (in_array(strtolower($file_type), $valid_filetypes))/* valida si tiene alguna de esas extensiones, in_array es para de php, sirve para buscarelementos denro de un arreglo, y strlower para pasar a mayuscula, filetyep para recorrelo , si retorna verdadero entonces cumple */ {
                        $document = new Document();
                        $document->setFile($image); /* recibe como parametro el arreglo y con es hace el upload delarchivo */
                        $document->setSubDirectory('archivos'); /* dentro dela caparpeta upload puedo llamar una carpeta con esenombre,podrias tener carpeta para los usuarios,arcvhiso/ y algo siqueires mas */
                        $document->processFile(); /**/
                        
                        $usuarios= $this->get('security.token_storage')->getToken()->getUser();
                        
                       
                        
                        $archivo = new Archivo();
                        $archivo->setArchivos($image->getBasename()); /*  getbasenameese metodo se almancena el nombre con que symfony lo guardo en la carpeta .tmp */
                        $archivo->setTitle('yussef');
                        
                         //relate this product to the category
                        
                        $archivo->setUser($usuarios);
                      
                        $archivo->setStatus(1);
                        $archivo->setDescription('nuevo archivo');
                        
                       
                        
                         
                       
                        $em = $this->getDoctrine()->getManager();
                        $em->persist($usuarios);
                        $em->persist($archivo);
                        $em->flush();
                        $this->get('session')->getFlashBag()->add(
                                'mensaje', 'el archivo se ha subido correctamente'
                        );
                        return $this->redirectToRoute('proyecto_user_index');
                    } else {
                        $this->get('session')->getFlashBag()->add(
                                'mensaje', 'la extensión del archivo no es la correcta'
                        );
                        //redirecciono        
                        return $this->redirect($this->generateUrl('proyecto_user_subir'));
                    }
                }
            } else {
                $this->get('session')->getFlashBag()->add(
                        'mensaje', 'no entró o se produjo algún error inesoperado'
                );
                //redirecciono        
                return $this->redirect($this->generateUrl('proyecto_user_subir'));
                //die("no entró o se produjo algún error inesoperado");
            }
        }
        return $this->render('ProyectoUserBundle:User:subir.html.twig');
    }
       public function registrarAction(){
           
           $unUsuario= new User();
           $form=$this->createCreateForm($unUsuario);
          return $this->render('ProyectoUserBundle:User:registrar.html.twig',array('form'=>$form->createView()));    
       }
       
       private function createCreateForm($entity){
          $form= $this->createForm(new UserType(),$entity,array(
               'action'=>$this->generateUrl('proyecto_user_crearRegistro'),
               'method'=>'POST'
           ));
           return $form;
       }
       
       public function crearRegistroAction(Request $request){
         $user = new User();
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);
           if($form->isValid()){
              $password = $form->get('password')->getData();
               $encoder = $this->container->get('security.password_encoder');
               
                $encoded = $encoder->encodePassword($user, $password);
                
               $user->setPassword($encoded);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
               
               return $this->redirectToroute('proyecto_user_index');
               
           }
           return $this->render('ProyectoUserBundle:User:registrar.html.twig',array('form'=>$form->createView()));  
           
       }
       
}


