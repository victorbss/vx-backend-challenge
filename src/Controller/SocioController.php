<?php
namespace App\Controller;

use App\Entity\Socio;
use App\Form\SocioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/v1")
 */
class SocioController extends Controller
{
    /**
     * @Route("/socios", methods={"GET"})
     */
    public function listAction()
    {
        $socios = $this->getDoctrine()->getRepository('App:Socio')->findAll();

        if (empty($socios))
        {
            return new Response("Não há registro de sócios no sistema.", Response::HTTP_NOT_FOUND);
        }

        $socios = $this->get('jms_serializer')->serialize($socios, 'json');

        return new Response($socios);
    }

    /**
     * @Route("/socio/{id}", methods={"GET"})
     */
    public function getAction(Socio $id)
    {
        $resultado = $this->get('jms_serializer')->serialize($id, 'json');

        if ($resultado === null)
        {
            return new Response("Sócio não encontrado", Response::HTTP_NOT_FOUND);
        }

        return new Response($resultado);
    }

    /**
     * @Route("/socio", methods={"POST"})
     */
    public function addAction(Request $request)
    {
        $data = $request->getContent();
        parse_str($data, $data_arr);

        $socio = new Socio;
        $form = $this->createForm(SocioType::class, $socio);
        $form->submit($data_arr);

        $nome = $request->get('nome');
        $cpf = $request->get('cpf');

        if(empty($nome) || empty($cpf))
        {
            return new Response("Campos vazios não permitidos!", Response::HTTP_NOT_ACCEPTABLE);
        }

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($socio);
        $doctrine->flush();

        return new Response("Sócio cadastrado com sucesso!", Response::HTTP_CREATED);
    }

    /**
     * @Route("/socio/{id}", methods={"PUT"})
     */
    public function editAction(Socio $id, Request $request)
    {
        $data = $request->getContent();
        parse_str($data, $data_arr);

        $socio = $this->getDoctrine()->getRepository('App:Socio')->find($id);

        if (!$socio)
        {
            return new Response("Sócio não encontrado!", Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(SocioType::class, $socio);
        $form->submit($data_arr);

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->merge($socio);
        $doctrine->flush();

        return new Response("Sócio atualizado com sucesso!", Response::HTTP_OK);
    }

    /**
     * @Route("/socio/{id}", methods={"DELETE"})
     */
    public function removeAction(Socio $id)
    {
        $doctrine = $this->getDoctrine()->getManager();

        $doctrine->remove($id);
        $doctrine->flush();

        return new Response("Sócio removido com sucesso!", Response::HTTP_OK);
    }
}
