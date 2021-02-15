<?php

namespace Spatie\Feed;

use Carbon\Carbon;
use Exception;
use Spatie\Feed\Exceptions\InvalidFeedItem;

class FeedItem
{
    protected ?string $id = null;

    protected string $title;

    protected Carbon $updated;

    protected string $summary;

    protected string $link;

    protected string $enclosure;

    protected int $enclosureLength;

    protected string $enclosureType;

    protected string $author;

    protected array $category = [];

    protected array $requiredFields = ['id', 'title', 'updated', 'summary', 'link', 'author'];

    protected array $jsonFieldMappings = [
        'id' => 'id',
        'title' => 'title',
        'updated' => 'date_modified',
        'summary' => 'content_text',
        'link' => 'url',
    ];

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

    public static function create(array $data = []): self
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

    public function updated(Carbon $updated): self
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

    public function author(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function category(string ...$category): self
    {
        $this->category = $category;

        return $this;
    }

    public function validate(): void
    {
        foreach ($this->requiredFields as $requiredField) {
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

    public function toJson() {
        $json = [];

        foreach ($this->jsonFieldMappings as $key => $mapping) {
            $json[$mapping] = $this->$key;
        }

        return $json;
    }
}
