<?php

namespace ru\timmson\FruitManagement\service;

use ru\timmson\FruitManagement\dao\ProjectDAO;
use ru\timmson\FruitManagement\dao\WorkLogDAO;
use ru\timmson\FruitManagement\http\Image;

/**
 * Class ProjectService
 * @package ru\timmson\FruitManagement\service
 */
class ProjectService implements Service
{

    /**
     * @var ProjectDAO
     */
    private ProjectDAO $projectDAO;

    /**
     * @var WorkLogDAO
     */
    private WorkLogDAO $workLogDAO;

    /**
     * @var Image
     */
    private Image $image;

    /**
     * ProjectService constructor.
     * @param ProjectDAO $projectDAO
     * @param WorkLogDAO $workLogDAO
     * @param Image $image
     */
    public function __construct(ProjectDAO $projectDAO, WorkLogDAO $workLogDAO, Image $image)
    {
        $this->projectDAO = $projectDAO;
        $this->workLogDAO = $workLogDAO;
        $this->image = $image;
    }

    /**
     * @inheritDoc
     */
    public function sync(array $request, string $user): array
    {
        $view = [];

        if (isset($request['mode']) && ($request['mode'] == 'async') && ($request['oper'] == 'gif')) {
            $data = $this->workLogDAO->getWorkedLog($request['project']);
            $diagramWidth = 800;
            $diagramHeight = 300;
            $image = $this->image->create($diagramWidth, $diagramHeight);

            $colorBackground = $this->image->colorAllocate($image, 192, 192, 192);
            $colorForeground = $this->image->colorAllocate($image, 255, 255, 255);
            $colorBlack = $this->image->colorAllocate($image, 0, 0, 0);

            $this->image->filledRectangle($image, 0, 0, $diagramWidth - 1, $diagramHeight - 1, $colorBackground);
            $this->image->filledRectangle($image, 1, 1, $diagramWidth - 2, $diagramHeight - 2, $colorForeground);

            $maxLoad = 0;
            for ($i = 0; $i < count($data); $i++) {
                if ($maxLoad < $data[$i]['spent_hours']) {
                    $maxLoad = $data[$i]['spent_hours'];
                }
            }

            $multx = ($diagramWidth - 50) / count($data);
            $multy = ($diagramHeight - 30) / $maxLoad;
            $oldX = 0;
            $oldY = 0;
            for ($i = 0; $i < count($data); $i++) {
                $newX = 25 + $i * $multx;
                $newY = $diagramHeight - $data[$i]['spent_hours'] * $multy;
                if ($i != 0) {
                    imageline($image, $oldX, $oldY, $newX, $newY, $colorBackground);
                }

                $this->image->arc($image, $newX, $newY, 10, 10, 0, 360, $colorBackground);
                $this->image->string($image, 10, $newX + 10, $newY, $data[$i]['spent_hours'] . "h", $colorBlack);
                $this->image->string($image, 10, $newX + 10, $newY + 15, $data[$i]['week'] . "w", $colorBlack);

                $oldX = $newX;
                $oldY = $newY;
            }

            $this->image->send($image);

            return [];

        } else {

            $data = $this->projectDAO->getProjectsWithTaskCountAndSpentHours();
            $view["data"] = $data;

        }

        return $view;
    }

    /**
     * @inheritDoc
     */
    public function async(array $request, string $user): array
    {
        return $this->sync($request, $user);
    }
}