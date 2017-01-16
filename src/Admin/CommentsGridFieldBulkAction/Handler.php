<?php

namespace SilverStripe\Comments\Admin\CommentsGridFieldBulkAction;

use SilverStripe\Core\Convert;
use SilverStripe\Comments\Admin\CommentsGridFieldBulkAction;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;

/**
 * A {@link GridFieldBulkActionHandler} for bulk marking comments as spam
 *
 * @package comments
 */
class Handlers extends CommentsGridFieldBulkAction
{
    /**
     * {@inheritDoc}
     */
    private static $allowed_actions = array(
        'spam',
        'approve',
    );

    /**
     * {@inheritDoc}
     */
    private static $url_handlers = array(
        'spam' => 'spam',
        'approve' => 'approve',
    );

    /**
     * @param  HTTPRequest $request
     * @return HTTPResponse
     */
    public function spam(HTTPRequest $request)
    {
        $ids = array();

        foreach ($this->getRecords() as $record) {
            array_push($ids, $record->ID);
            $record->markSpam();
        }

        $response = new HTTPResponse(Convert::raw2json(array(
            'done' => true,
            'records' => $ids
        )));

        $response->addHeader('Content-Type', 'text/json');

        return $response;
    }

    /**
     * @param  HTTPRequest $request
     * @return HTTPResponse
     */
    public function approve(HTTPRequest $request)
    {
        $ids = array();

        foreach ($this->getRecords() as $record) {
            array_push($ids, $record->ID);
            $record->markApproved();
        }

        $response = new HTTPResponse(Convert::raw2json(array(
            'done' => true,
            'records' => $ids
        )));

        $response->addHeader('Content-Type', 'text/json');

        return $response;
    }
}
