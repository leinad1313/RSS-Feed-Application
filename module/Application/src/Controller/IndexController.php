<?php

declare(strict_types=1);

namespace Application\Controller;

use Feed\Controller\FeedController;
use Feed\Form\FeedForm;
use Feed\Model\Feed;
use Laminas\Form\FormInterface;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use stdClass;

class IndexController extends AbstractActionController
{
    /** @var FormInterface */
    private FormInterface $form;

    /** @var FeedController @ */
    private FeedController $feedController;

    // Start of the feed JSON API url
    private const URL = 'https://api.rss2json.com/v1/api.json?api_key=egbqbbvcs4gzmz1431uhmyyovvv3tefehydmnfow&rss_url=';

    // Path to the locally saved feed URLs
    private const PATH_LOCAL_FEED_JSON = '/var/www/module/Feed/config/localFeed.config.json';

    // Predefined error messages
    private const FILE_GET_CONTENTS_ERROR = 'URL returns no data or has a wrong format';
    private const FORM_INVALID = 'Form is not valid. Input a working URL!';
    private const FORM_VALID_NO_DATA = 'Form is valid but has no data!';
    private const LOCAL_FEED_JSON_UNREACHABLE = 'The localFeed.json file is not reachable!';
    private const JSON_DECODE_ERROR = 'JSON decode unsuccessful!';
    private const JSON_WRONG_FORMAT = 'JSON has the wrong format!';

    public function __construct(FeedForm $form, FeedController $feedController) {
        $this->form = $form;
        $this->feedController = $feedController;
    }

    // Save new default/favorite feed to local .json
    public function favoriteAction(): Response {
        // Get variables from Query
        $feedUrl = $this->params()->fromQuery('feedUrl');

        // Get saved feed URLs from localFeed.config.json
        $errorMessage = '';
        if ($urlContent = @file_get_contents(self::PATH_LOCAL_FEED_JSON)) {
            // Check if JSON is successfully loaded as object
            if (($json = json_decode($urlContent)) && $json instanceof StdClass) {
                $jsonArray = get_object_vars($json);
                foreach ($json as $urlString => $localFeed) {
                    if ($localFeed->default === true) {
                        $jsonArray[$urlString]->default = false;
                    }

                    if ($urlString === $feedUrl) {
                        // Set default true
                        $jsonArray[$feedUrl]->default = true;
                        break;
                    }
                }
                // Save to file
                $jsonData = json_encode($jsonArray);
                if (!@file_put_contents(self::PATH_LOCAL_FEED_JSON, $jsonData)) {
                    $errorMessage = self::LOCAL_FEED_JSON_UNREACHABLE;
                }
            } else {
                $errorMessage = self::JSON_DECODE_ERROR;
            }
        }


        // Redirect to indexAction when finished. Pass error if any
        return $this->redirect()->toUrl('/' . ($errorMessage ? '&errorMessage=' . $errorMessage : ''));
    }

    // Save feed to local .json
    public function saveAction(): Response {
        // Get variables from Query
        $feedUrl = $this->params()->fromQuery('feedUrl');
        $title = $this->params()->fromQuery('title');
        $imageUrl = $this->params()->fromQuery('imageUrl');

        // Get saved feed URLs from localFeed.config.json
        $errorMessage = '';
        if ($urlContent = @file_get_contents(self::PATH_LOCAL_FEED_JSON)) {
            // Check if JSON is successfully loaded as object
            if (($json = json_decode($urlContent)) && $json instanceof StdClass) {
                $jsonArray = get_object_vars($json);
                foreach ($json as $urlString => $localFeed) {
                    if ($urlString != $feedUrl) {
                        // Save to file
                        $feed = ['imageUrl' => $imageUrl, 'title' => $title, 'default' => false];
                        $jsonArray[$feedUrl] = $feed;
                        break;
                    }
                }
                $jsonData = json_encode($jsonArray);
                if (!@file_put_contents(self::PATH_LOCAL_FEED_JSON, $jsonData)) {
                    $errorMessage = self::LOCAL_FEED_JSON_UNREACHABLE;
                }
            } else {
                $errorMessage = self::JSON_DECODE_ERROR;
            }
        }


        // Redirect to indexAction when finished. Set feedUrl to open saved feed directly
        return $this->redirect()->toUrl('/?feedUrl=' . ($feedUrl ?: '') . ($errorMessage ? '&errorMessage=' . $errorMessage : ''));
    }

    // Delete feed from local .json
    public function deleteAction(): Response {
        // Get variables from Query
        $feedUrl = $this->params()->fromQuery('feedUrl');

        // Get saved feed URLs from localFeed.config.json
        $errorMessage = '';
        if ($urlContent = @file_get_contents(self::PATH_LOCAL_FEED_JSON)) {
            // Check if JSON is successfully loaded as object
            if (($json = json_decode($urlContent)) && $json instanceof StdClass) {
                $jsonArray = get_object_vars($json);
                foreach ($json as $urlString => $localFeed) {
                    if ($urlString === $feedUrl) {
                        // Remove from file
                        unset($jsonArray[$feedUrl]);
                        // If we have a feed left set a new default feed
                        if ($localFeed->default === true && $jsonArray[array_key_first($jsonArray)]) {
                            $jsonArray[array_key_first($jsonArray)]->default = true;
                        }
                        break;
                    }
                }
                $jsonData = json_encode($jsonArray);
                if (!@file_put_contents(self::PATH_LOCAL_FEED_JSON, $jsonData)) {
                    $errorMessage = self::LOCAL_FEED_JSON_UNREACHABLE;
                }
            } else {
                $errorMessage = self::JSON_DECODE_ERROR;
            }
        }


        // Redirect to indexAction when finished. Pass error if any
        return $this->redirect()->toUrl('/' . ($errorMessage ? '&errorMessage=' . $errorMessage : ''));
    }

    public function indexAction(): ViewModel {
        // Get errors from response sites
        $errorMessage = $this->params()->fromQuery('errorMessage') ?: '';
        $localFeeds = null;
        // Get feedUrl if user is using a local feed to display or just return an empty string
        $url = $this->params()->fromQuery('feedUrl') ?: '';


        // Get saved feed URLs from localFeed.config.json
        if ($urlContent = @file_get_contents(self::PATH_LOCAL_FEED_JSON)) {
            // Check if JSON is successfully loaded as object
            if (($json = json_decode($urlContent)) && $json instanceof StdClass) {
                $localFeeds = $json;
                // Set default feed url if url is not already prefilled
                foreach ($localFeeds as $urlString => $localFeed) {
                    if ($localFeed->default && !$url) {
                        $url = $urlString;
                    }
                }
            } else {
                $errorMessage = self::JSON_DECODE_ERROR;
            }
        } else {
            $errorMessage = self::LOCAL_FEED_JSON_UNREACHABLE;
        }

        if (!$errorMessage && ($request = $this->getRequest()) && $request->isPost()) {
            $formData = $request->getPost()->toArray();
            $this->form->setData($formData);
            if ($this->form->isValid()) {
                $data = $this->form->getData();
                if (is_array($data) && isset($data['feedUrl'])) {
                    $url = $data['feedUrl'];
                } else {
                    $errorMessage = self::FORM_VALID_NO_DATA;
                }
            } else {
                $errorMessage = self::FORM_INVALID;
            }
        }

        // Get feed object if url is used
        $feed = null;
        if ($url) {
            $this->form->setData(['feedUrl' => $url]);
            if (!$errorMessage && $urlContent = @file_get_contents(self::URL . $url)) {
                // Check if JSON is successfully loaded as object
                if (($json = json_decode($urlContent)) && $json instanceof StdClass) {
                    $feed = $this->feedController->createFeedByRSSData($json);
                } else {
                    $errorMessage = self::JSON_DECODE_ERROR;
                }
            } else {
                $errorMessage = self::FILE_GET_CONTENTS_ERROR;
            }

            if (!$errorMessage && $feed instanceof Feed === false) {
                $errorMessage = self::JSON_WRONG_FORMAT;
            }
        }

        return new ViewModel(['form' => $this->form, 'feed' => $feed, 'localFeeds' => $localFeeds, 'errorMessage' => $errorMessage]);
    }
}
