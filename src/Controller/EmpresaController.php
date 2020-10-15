<?php
namespace App\Controller;

use App\Entity\Empresa;
use App\Form\EmpresaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/v1")
 */
class EmpresaController extends Controller
{
    /**
     * @Route("/empresas", methods={"GET"})
     */
    public function listAction()
    {
        $empresas = $this->getDoctrine()->getRepository('App:Empresa')->findAll();

        if (empty($empresas))
        {
            return new Response("Não há registro de empresas no sistema.", Response::HTTP_NOT_FOUND);
        }

        $empresas = $this->get('jms_serializer')->serialize($empresas, 'json');

        return new Response($empresas);
    }

    /**
     * @Route("/empresa/{id}", methods={"GET"})
     */
    public function getAction(Empresa $id)
    {
        $resultado = $this->get('jms_serializer')->serialize($id, 'json');

        if ($resultado === null)
        {
            return new Response("Empresa não encontrada.", Response::HTTP_NOT_FOUND);
        }

        return new Response($empresa);
    }

    /**
     * @Route("/empresa", methods={"POST"})
     */
    public function addAction(Request $request)
    {
        $data = $request->getContent();
        parse_str($data, $data_arr);

        $empresa = new Empresa;
        $form = $this->createForm(EmpresaType::class, $empresa);
        $form->submit($data_arr);

        $nome = $request->get('nome');
        $cnpj = $request->get('cnpj');

        if(empty($nome) || empty($cnpj))
        {
            return new Response("Campos vazios não permitidos!", Response::HTTP_NOT_ACCEPTABLE);
        }

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($empresa);
        $doctrine->flush();

        return new Response("Empresa cadastrada com sucesso!", Response::HTTP_CREATED);
    }

    /**
     * @Route("/empresa/{id}", methods={"PUT"})
     */
    public function editAction(Empresa $id, Request $request)
    {
        $data = $request->getContent();
        parse_str($data, $data_arr);

        $empresa = $this->getDoctrine()->getRepository('App:Empresa')->find($id);

        if (!$empresa)
        {
            return new Response("Empresa não encontrada.", Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(EmpresaType::class, $empresa);
        $form->submit($data_arr);

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->merge($empresa);
        $doctrine->flush();

        return new Response("Empresa atualizada com sucesso!", Response::HTTP_CREATED);
    }

    /**
     * @Route("/empresa/{id}", methods={"DELETE"})
     */
    public function removeAction(Empresa $id)
    {
        $doctrine = $this->getDoctrine()->getManager();

        $doctrine->remove($id);
        $doctrine->flush();

        return new Response("Empresa removida com sucesso!", Response::HTTP_OK);
    }
}
