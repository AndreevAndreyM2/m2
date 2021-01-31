<?php


namespace MR\Grid\Api\Data;

interface JobInterface
{
    const ID = 'id';

    const NAME = 'name';

    const DESCRIPTION = 'description';

    const SHORT_DESCRIPTION = 'short_description';

    public function getId();

    public function setId($id);

    public function getName();

    public function setName($name);

    public function getDescription();

    public function setDescription($description);

    public function getShortDescription();

    public function setShortDescription($short_description);


}