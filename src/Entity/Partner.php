<?php declare(strict_types=1);
require_once __DIR__ . '/../Core/Entity.php';

class Partner implements Entity
{
    const PARTNER_PATH = 'partners';

    private ?int $id = null;
    private string $name;
    private string $logo;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Partner
     */
    public function setId(int $id): Partner
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Partner
     */
    public function setName(string $name): Partner
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     * @return Partner
     */
    public function setLogo(string $logo): Partner
    {
        $this->logo = $logo;
        return $this;
    }


    /**
     * @return mixed
     */
    public function toArray(): array
    {
        return [
            "id"=>$this->getId(),
            "name"=>$this->getName(),
            "logo"=>$this->getLogo()
        ];
    }
}