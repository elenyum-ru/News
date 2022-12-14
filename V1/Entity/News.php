<?php

namespace Module\News\V1\Entity;

use App\Entity\BaseEntity;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Module\News\V1\Repository\NewsRepository;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
#[ORM\Table(name: 'news')]
class News extends BaseEntity
{
    public const STATUS_NEW = 10;
    public const STATUS_PUBLISH = 20;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['list', 'del', 'post', 'get'])]
    private ?int $id = null;

    #[Assert\Length(min: 3, max: 200)]
    #[ORM\Column(length: 255)]
    #[Groups(['get', 'list', 'post', 'put'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Groups(['get', 'list'])]
    #[OA\Property(type: 'string', format: 'datetime', example: '2012-01-18T11:45:00+03:00')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[Groups(['get', 'list'])]
    #[OA\Property(type: 'string', format: 'datetime', example: '2012-01-18T11:45:00+03:00')]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    #[Groups(['get', 'list', 'put'])]
    #[OA\Property(type: 'string', format: 'datetime', example: '2012-01-18T11:45:00+03:00')]
    private ?\DateTimeImmutable $publishedAt = null;

    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['get', 'post', 'put'])]
    private ?string $text = null;

    #[Assert\Type(type: 'string')]
    #[Assert\Length(min: 5, max: 400)]
    #[ORM\Column(type: Types::STRING, length: 400)]
    #[Groups(['get', 'list', 'post', 'put'])]
    private ?string $description = null;

    #[Assert\Type(type: 'int')]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    #[Groups(['put', 'list'])]
    private int $status;

    #[Assert\Type(type: 'string')]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[Groups(['get', 'list', 'post', 'put'])]
    private ?string $imgUrl = null;

    #[Assert\Type(type: 'array')]
    #[ORM\Column(type: Types::JSON, nullable: true)]
    #[Groups(['get', 'list', 'post', 'put'])]
    #[OA\Property(type: 'array', items: new OA\Items(type: 'string'))]
    private ?array $keywords = null;

    public function __construct()
    {
        $this->setCreatedAt(new DateTimeImmutable());
        $this->setStatus(self::STATUS_NEW);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getPublishedAt(): ?DateTimeImmutable
    {
        return $this->publishedAt;
    }

    /**
     * @param DateTimeImmutable|string|null $publishedAt
     * @return News
     * @throws Exception
     */
    public function setPublishedAt(DateTimeImmutable|string|null $publishedAt): self
    {
        if (is_string($publishedAt)) {
            $publishedAt = DateTimeImmutable::createFromFormat(DATE_ATOM, $publishedAt);
            if ($publishedAt === false) {
                throw new Exception('in correct datetime');
            }
        }
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return News
     */
    public function setDescription(?string $description): News
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    /**
     * @param string|null $imgUrl
     * @return News
     */
    public function setImgUrl(?string $imgUrl): News
    {
        $this->imgUrl = $imgUrl;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getKeywords(): ?array
    {
        return $this->keywords;
    }

    /**
     * @param array|null $keywords
     * @return News
     */
    public function setKeywords(?array $keywords): News
    {
        $this->keywords = $keywords;

        return $this;
    }
}