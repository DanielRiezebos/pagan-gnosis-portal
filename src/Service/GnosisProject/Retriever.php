<?php

namespace App\Service\GnosisProject;

use App\Repository\GnosisProjectRepository;
use App\Repository\TagRepository;

class Retriever
{
    public function __construct(
        public GnosisProjectRepository $gnosisProjectRepository,
        public TagRepository $tagRepository
    ) {
        // ...
    }

    public function retrieveGnosisProjectsByTags(array $tags)
    {
        $requestedTags = $this->tagRepository->findBy(['label' => $tags]);
        return $this->gnosisProjectRepository->findByTags($requestedTags);
    }
}