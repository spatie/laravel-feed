<?php

namespace Spatie\Feed;

use Carbon\CarbonInterface;
use Exception;
use Spatie\Feed\Exceptions\InvalidFeedItem;

class FeedItem
{
    public ?Feed $feed = null;

    protected ?string $id = null;

    protected string $title;

    protected CarbonInterface $updated;

    protected string $summary;

    protected string $link;

    protected string $enclosure;

    protected string $image;

    protected int $enclosureLength;

    protected string $enclosureType;

    protected string $authorName;

    protected string $authorEmail;

    protected array $category = [];

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if ($key === 'category') {
                $this->category = (array) $value;

                continue;
            }

            $this->$key = $value;
        }
    }

    public static function create(array $data = []): static
    {
        return new static($data);
    }

    public function id(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function updated(CarbonInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function summary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function link(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function enclosure(string $enclosure): self
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    public function enclosureLength(int $enclosureLength): self
    {
        $this->enclosureLength = $enclosureLength;

        return $this;
    }

    public function enclosureType(string $enclosureType): self
    {
        $this->enclosureType = $enclosureType;

        return $this;
    }

    public function image(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function authorName(string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    public function authorEmail(string $authorEmail): self
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    public function category(string ...$category): self
    {
        $this->category = $category;

        return $this;
    }

    public function timestamp(): string
    {
        if ($this->feed->format() === 'rss') {
            return $this->updated->toRssString();
        }

        return $this->updated->toRfc3339String();
    }

    public function validate(): void
    {
        $requiredFields = ['id', 'title', 'updated', 'summary', 'link', 'authorName'];

        foreach ($requiredFields as $requiredField) {
            if (is_null($this->$requiredField)) {
                throw InvalidFeedItem::missingField($this, $requiredField);
            }
        }
    }

    public function __get($key)
    {
        if (! isset($this->$key)) {
            throw new Exception("Property `{$key}` doesn't exist");
        }

        return $this->$key;
    }

    public function __isset($key)
    {
        return isset($this->$key);
    }
}
