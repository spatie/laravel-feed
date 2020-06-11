<?php

namespace Spatie\Feed;

use Carbon\Carbon;
use Exception;
use Spatie\Feed\Exceptions\InvalidFeedItem;

class FeedItem
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $title;

    /** @var \Carbon\Carbon */
    protected $updated;

    /** @var string */
    protected $summary;

    /** @var string */
    protected $link;

    /** @var string */
    protected $enclosure;

    /** @var int */
    protected $enclosureLength;

    /** @var string */
    protected $enclosureType;

    /** @var string */
    protected $author;

    /** @var string[] */
    protected $category = [];

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

    public static function create(array $data = [])
    {
        return new static($data);
    }

    public function id(string $id)
    {
        $this->id = $id;

        return $this;
    }

    public function title(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function updated(Carbon $updated)
    {
        $this->updated = $updated;

        return $this;
    }

    public function summary(string $summary)
    {
        $this->summary = $summary;

        return $this;
    }

    public function link(string $link)
    {
        $this->link = $link;

        return $this;
    }

    public function enclosure(string $enclosure)
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    public function enclosureLength(int $enclosureLength)
    {
        $this->enclosureLength = $enclosureLength;

        return $this;
    }

    public function enclosureType(string $enclosureType)
    {
        $this->enclosureType = $enclosureType;

        return $this;
    }

    public function author(string $author)
    {
        $this->author = $author;

        return $this;
    }

    public function category(string ...$category)
    {
        $this->category = $category;

        return $this;
    }

    public function validate()
    {
        $requiredFields = ['id', 'title', 'updated', 'summary', 'link', 'author'];

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
