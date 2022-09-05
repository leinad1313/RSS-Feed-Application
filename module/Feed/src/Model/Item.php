<?php

declare(strict_types=1);

namespace Feed\Model;


/**
 * Item description
 * 
 * Item model that will be used to hold the data of the entries of the Feed model
 */
class Item {
    // Title
    private ?string $title = null;

    // Description
    private ?string $description = null;

    // Publish date
    private ?string $pubDate = null;

    // Array of categories
    private array $categories = [];

    // Link to the active page
    private ?string $link = null;

    // Guid, secondary link
    private ?string $guid = null;

    // Image or logo
    private ?string $thumbnail = null;

    // Author
    private ?string $author = null;


    /**
     * Create new Item with given parameters. It should at least have a title and a description specified by the api or developer
     *
     * @param string $title
     * @param string $description
     * @param string|null $pubDate
     * @param array $categories
     * @param string|null $link
     * @param string|null $guid
     * @param string|null $thumbnail
     * @param string|null $author
     */
    public function __construct(string $title, string $description, string $pubDate = null, array $categories = [], string $link = null, string $guid = null, string $thumbnail = null, string $author = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->pubDate = $pubDate;
        $this->categories = $categories;
        $this->link = $link;
        $this->guid = $guid;
        $this->thumbnail = $thumbnail;
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
     * @return Item
     */
    public function setTitle(?string $title): Item
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPubDate(): ?string
    {
        return $this->pubDate;
    }

    /**
     * @param string|null $pubDate
     * @return Item
     */
    public function setPubDate(?string $pubDate): Item
    {
        $this->pubDate = $pubDate;
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
     * @return Item
     */
    public function setDescription(?string $description): Item
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param array $categories
     * @return Item
     */
    public function setCategories(array $categories): Item
    {
        $this->categories = $categories;
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
     * @return Item
     */
    public function setLink(?string $link): Item
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGuid(): ?string
    {
        return $this->guid;
    }

    /**
     * @param string|null $guid
     * @return Item
     */
    public function setGuid(?string $guid): Item
    {
        $this->guid = $guid;
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
     * @return Item
     */
    public function setAuthor(?string $author): Item
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    /**
     * @param string|null $thumbnail
     * @return Item
     */
    public function setThumbnail(?string $thumbnail): Item
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    // END Setters
}