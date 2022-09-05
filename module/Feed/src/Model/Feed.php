<?php

declare(strict_types=1);

namespace Feed\Model;

/**
 * Feed Description
 *
 * Feed model that holds all relevant data of an RSS Feed
 */
class Feed
{

    // Title
    private ?string $title = null;

    // Description
    private ?string $description = null;

    // Array of items provided
    private array $items = [];

    // URL the data is taken from
    private ?string $url = null;

    // Link to the active page
    private ?string $link = null;

    // Author
    private ?string $author = null;

    // Image or logo
    private ?string $image = null;

    /**
     * Create new feed with given parameters. It should at least have a title and a description specified by the api or developer
     *
     * @param string $title
     * @param string $description
     * @param array $items
     * @param string|null $url
     * @param string|null $link
     * @param string|null $image
     * @param string|null $author
     *
     *
     */
    public function __construct(string $title, string $description, array $items = [], string $url = null, string $link = null, string $image = null, string $author = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->items = $items;
        $this->url = $url;
        $this->link = $link;
        $this->image = $image;
        $this->author = $author;
    }

    // START Getters

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Feed
     */
    public function setTitle(?string $title): Feed
    {
        $this->title = $title;
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
     * @return Feed
     */
    public function setDescription(?string $description): Feed
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return Feed
     */
    public function setItems(array $items): Feed
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     * @return Feed
     */
    public function setUrl(?string $url): Feed
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    // END Getters
    // START Setters

    /**
     * @param string|null $link
     * @return Feed
     */
    public function setLink(?string $link): Feed
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthor(): ?string
    {
        return $this->author;
    }

    /**
     * @param string|null $author
     * @return Feed
     */
    public function setAuthor(?string $author): Feed
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return Feed
     */
    public function setImage(?string $image): Feed
    {
        $this->image = $image;
        return $this;
    }

    //END Setters
}