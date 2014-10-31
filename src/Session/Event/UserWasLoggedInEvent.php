<?php namespace Anomaly\Streams\Addon\Module\Users\Session\Event;

/**
 * Class UserWasLoggedInEvent
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Addon\Module\Users\Session\Event
 */
class UserWasLoggedInEvent
{

    /**
     * Get the user ID.
     *
     * @var
     */
    protected $userId;

    /**
     * Create a new UserWasLoggedInEvent instance.
     *
     * @param $userId
     */
    function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get the user ID.
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
 