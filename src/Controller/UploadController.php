<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Repository\UploadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    #[Route(path: '/upload', name: 'upload')]
    public function upload(UploadRepository $uploadRepository): Response
    {
        $uploads = $uploadRepository->findAll();

        return $this->render('other/upload.html.twig', [
            'uploads' => $uploads,
        ]);
    }

    #[Route(path: '/api/upload', name: 'api_upload')]
    public function uploadApi(
        Request $request,
        FileUploader $fileUploader,
        EntityManagerInterface $entityManager
    ): Response
    {
        /** @var UploadedFile[] $files */
        $files = $request->files->all()['files'];

        foreach ($files as $file) {
            $fileName = $fileUploader->upload($file);
            $upload = new Upload();
            $upload->setUploadedBy($this->getUser());
            $upload->setUrl($fileName);
            $entityManager->persist($upload);
        }

        $entityManager->flush();

        return $this->json([
            'message' => 'Upload successful!',
        ]);
    }
}